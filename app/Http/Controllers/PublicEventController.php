<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\Registration;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewAttendeeRegistration;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status', 'approved');

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->sort === 'recent') {
            $query->latest();
        } elseif ($request->sort === 'date_asc') {
            $query->orderBy('date', 'asc');
        } else {
            $query->latest();
        }

        // On homepage (no filters), show only 3. If filtering, show more?
        // Actually, the mockup shows 3 events in "Upcoming Events".
        $events = $query->paginate(6)->withQueryString(); 
        
        $categories = \App\Models\Category::withCount('events')->get();
        $locations = Event::distinct()->pluck('location')->filter()->values();

        return view('welcome', compact('events', 'locations', 'categories'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('public.events.show', compact('event'));
    }

    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // check capacity
        if ($event->registrations()->count() >= $event->capacity) {
            return back()->with('error', 'Sorry, this event is already full.');
        }

        // check window
        $now = now()->toDateString();
        if ($now < $event->reg_start_date || $now > $event->reg_end_date) {
            return back()->with('error', 'Registration for this event is currently closed.');
        }

        // Validation for guest registration
        $request->validate([
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|max:255',
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'organization' => 'nullable|string|max:255',
        ]);

        // Find or create attendee by email
        $attendee = Attendee::where('email', $request->email)->first();
        
        if (!$attendee) {
            // Generate unique access code: EM-XXXX-RAND (Backend only)
            $count = \App\Models\Attendee::count() + 1;
            $access_code = 'EM-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(\Illuminate\Support\Str::random(4));

            $attendee = Attendee::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'organization' => $request->organization,
                'access_code' => $access_code,
            ]);
        } else {
            // Update existing attendee info if provided
            $attendee->update($request->only(['full_name', 'phone', 'organization']));
        }

        // check duplicate registration for this specific event
        $duplicate = Registration::where('event_id', $event->id)
                                 ->where('attendee_id', $attendee->id)
                                 ->exists();
        if ($duplicate) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $ticket_id = 'EmCa-' . strtoupper(Str::random(5)) . '-26';

        $registration = Registration::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
            'ticket_id' => $ticket_id,
        ]);

        // Send Notification to Admins and Organizer
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewAttendeeRegistration($attendee, $event));

        if ($event->organizer && $event->organizer->role !== 'admin') {
            $event->organizer->notify(new NewAttendeeRegistration($attendee, $event));
        }

        return redirect()->route('events.public.ticket', $ticket_id)->with('success', 'Registration confirmed successfully!');
    }

    public function ticket($ticket_id)
    {
        $registration = Registration::with(['attendee', 'event'])->where('ticket_id', $ticket_id)->firstOrFail();
        $qrData = route('events.public.verify', ['ticket_id' => $registration->ticket_id]);
        return view('public.events.ticket', compact('registration', 'qrData'));
    }

    public function downloadTicket($ticket_id)
    {
        $registration = Registration::with(['attendee', 'event'])->where('ticket_id', $ticket_id)->firstOrFail();
        
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=" . urlencode(route('events.public.verify', ['ticket_id' => $registration->ticket_id])) . "&format=svg";
        $qrCodeBase64 = base64_encode(file_get_contents($qrUrl));
        
        $pdf = Pdf::loadView('public.events.ticket_pdf', compact('registration', 'qrCodeBase64'))
                  ->setPaper('a4')
                  ->setOption(['isRemoteEnabled' => true]);
        
        return $pdf->download('Ticket-' . $registration->ticket_id . '.pdf');
    }

    public function verifyTicket($ticket_id)
    {
        $registration = Registration::with(['attendee', 'event'])->where('ticket_id', $ticket_id)->firstOrFail();
        
        // Support JSON response for scanner apps or direct data access
        if (request()->wantsJson() || request()->has('json')) {
            return response()->json([
                'success' => true,
                'ticket_id' => $registration->ticket_id,
                'status' => $registration->attended ? 'Verified' : 'Authentic',
                'member' => [
                    'full_name' => $registration->attendee->full_name,
                    'email' => $registration->attendee->email,
                    'phone' => $registration->attendee->phone,
                    'access_id' => $registration->attendee->access_code,
                    'organization' => $registration->attendee->organization,
                ],
                'event' => [
                    'title' => $registration->event->title,
                    'date' => $registration->event->date,
                    'location' => $registration->event->location,
                ]
            ]);
        }

        return view('public.events.verify', compact('registration'));
    }
}
