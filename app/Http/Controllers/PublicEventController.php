<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\Registration;
use App\Models\Category;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('status', 'approved');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
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
        $events = $query->paginate(6); 
        
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

        // Get attendee code from request OR session
        $access_code = $request->access_code ?? session('member_access_id');
        
        if (!$access_code) {
            return back()->with('error', 'Please enter your Member ID to register.');
        }

<<<<<<< HEAD
        // check duplicate
        $existingAttendee = Attendee::where('email', $request->email)->first();
        if ($existingAttendee) {
            $duplicate = Registration::where('event_id', $event->id)
                                     ->where('attendee_id', $existingAttendee->id)
                                     ->exists();
            if ($duplicate) {
                return back()->with('error', 'You are already registered for this event.');
            }
            // Update attendee details with the latest registration info
            $existingAttendee->update([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'organization' => $request->organization,
            ]);
            $attendee = $existingAttendee;
        } else {
            $attendee = Attendee::create($request->all());
=======
        $attendee = Attendee::where('access_code', $access_code)->first();
        
        if (!$attendee) {
            return back()->with('error', 'Invalid Member ID. Please check and try again.');
        }

        // Auto-login: set session if not already set or if it's a different ID
        session(['member_access_id' => $access_code]);

        // check duplicate registration for this specific event
        $duplicate = Registration::where('event_id', $event->id)
                                 ->where('attendee_id', $attendee->id)
                                 ->exists();
        if ($duplicate) {
            return back()->with('error', 'You are already registered for this event.');
>>>>>>> 6cc1c78 (new changes)
        }

        $ticket_id = strtoupper(Str::random(8));

        Registration::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
            'ticket_id' => $ticket_id,
        ]);

        return redirect()->route('events.public.ticket', $ticket_id)->with('success', 'Registration confirmed successfully!');
    }

    public function ticket($ticket_id)
    {
        $registration = Registration::with(['attendee', 'event'])->where('ticket_id', $ticket_id)->firstOrFail();
        return view('public.events.ticket', compact('registration'));
    }

    public function downloadTicket($ticket_id)
    {
        $registration = Registration::with(['attendee', 'event'])->where('ticket_id', $ticket_id)->firstOrFail();
        
        // Fetch QR Code as SVG and encode to base64 to avoid GD extension dependency in DomPDF
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=" . urlencode(route('events.public.verify', ['ticket_id' => $registration->ticket_id, 'json' => 1])) . "&format=svg";
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
