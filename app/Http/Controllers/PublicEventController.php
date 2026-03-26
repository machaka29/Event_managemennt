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
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminRegistrationNotification;
use App\Mail\AttendeeRegistrationNotification;

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

    public function searchAjax(Request $request)
    {
        $query = Event::with('category')->where('status', 'approved');

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('location', 'like', '%' . $searchTerm . '%')
                  ->orWhere('venue', 'like', '%' . $searchTerm . '%');
            });
        }

        $events = $query->latest()->paginate(6);
        
        $html = '';
        foreach($events as $event) {
            $imageUrl = $event->image_path ? asset('storage/' . $event->image_path) : null;
            $icon = $event->category->icon ?? 'fa-calendar-day';
            $categoryName = $event->category->name ?? 'Event';
            $date = \Carbon\Carbon::parse($event->date)->format('D, M d, Y');
            $detailUrl = route('events.public.show', $event->id);
            
            $imageHtml = $imageUrl 
                ? '<img src="'.$imageUrl.'" alt="'.htmlspecialchars($event->title).'" style="width: 100%; height: 100%; object-fit: cover;">'
                : '<i class="fa-solid '.$icon.'" style="font-size: 3.5rem; color: #cbd5e1;"></i>';

            $html .= '
            <div class="card event-item" style="padding: 0; overflow: hidden; text-align: left;">
                <div style="height: 200px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                    '.$imageHtml.'
                    <div style="position: absolute; top: 15px; right: 15px; background: var(--corporate-red); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        '.$categoryName.'
                    </div>
                </div>

                <div style="padding: 25px; flex: 1; display: flex; flex-direction: column;">
                    <h3 style="font-size: 1.15rem; color: #1e293b; margin-bottom: 1rem; font-weight: 800; line-height: 1.3;">
                        '.htmlspecialchars($event->title).'
                    </h3>
                    
                    <div style="color: #64748b; font-size: 0.85rem; margin-bottom: 2rem; display: grid; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-calendar" style="color: var(--corporate-red); width: 14px;"></i>
                            '.$date.'
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-location-dot" style="color: var(--corporate-red); width: 14px;"></i>
                            '.htmlspecialchars($event->location).'
                        </div>
                    </div>

                    <a href="'.$detailUrl.'" class="btn btn-outline" style="width: 100%; margin-top: auto;">
                        View Details
                    </a>
                </div>
            </div>';
        }

        return response()->json([
            'html' => $html,
            'hasMorePages' => $events->hasMorePages(),
            'nextPageUrl' => $events->nextPageUrl()
        ]);
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

        // New Stricter Validation
        $request->validate([
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.-]+$/'],
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'regex:/^\+255[0-9]{9}$/'],
            'organization' => 'nullable|string|max:255',
        ]);

        // Standardize Attendee (find by email OR phone)
        $attendee = Attendee::where('email', $request->email)
                            ->orWhere('phone', $request->phone)
                            ->first();

        if (!$attendee) {
            // Generate unique access code: EM-XXXX-RAND (Backend only)
            $count = \App\Models\Attendee::count() + 1;
            $access_code = 'EM-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(\Illuminate\Support\Str::random(4));

            $attendee = Attendee::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'organization' => $request->organization,
                'access_code' => $access_code
            ]);
        } else {
            // Update existing attendee info if provided
            $attendee->update($request->only(['full_name', 'phone', 'organization']));
        }

        // check duplicate registration for this specific event (Strict: both attendee identity and inputs)
        $duplicate = Registration::where('event_id', $event->id)
            ->where(function($q) use ($attendee, $request) {
                $q->where('attendee_id', $attendee->id);
            })->exists();

        if ($duplicate) {
            return back()->with('error', 'You (or this phone/email) are already registered for this event.');
        }

        $ticket_id = 'EmCa-' . strtoupper(Str::random(5)) . '-26';

        $registration = Registration::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
            'ticket_id' => $ticket_id,
            'is_read' => false,
        ]);

        // Send Notification to Admins and Organizer (in-app)
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewAttendeeRegistration($attendee, $event));

        if ($event->organizer && $event->organizer->role !== 'admin') {
            $event->organizer->notify(new NewAttendeeRegistration($attendee, $event));
        }
        
        // Send Email Notification to Admin
        try {
            if ($admins->count() > 0) {
                Mail::to($admins)->send(new AdminRegistrationNotification($registration));
            }
        } catch (\Exception $e) {
            \Log::error('Mail Admin Notification Error: ' . $e->getMessage());
        }

        // Send Email Notification to Attendee
        try {
            Mail::to($attendee->email)->send(new AttendeeRegistrationNotification($registration));
        } catch (\Exception $e) {
            \Log::error('Mail Attendee Notification Error: ' . $e->getMessage());
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
        $isExpired = $registration->event->date < (now()->toDateString());
        
        // Support JSON response for scanner apps or direct data access
        if (request()->wantsJson() || request()->has('json')) {
            return response()->json([
                'success' => true,
                'ticket_id' => $registration->ticket_id,
                'status' => $registration->attended ? 'Verified' : ($isExpired ? 'Expired' : 'Authentic'),
                'is_expired' => $isExpired,
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

        return view('public.events.verify', compact('registration', 'isExpired'));
    }

    /**
     * Public attendance marking (for guards/scanners - no login required)
     */
    public function markPublicAttendance(Request $request, $ticket_id)
    {
        $registration = Registration::with(['attendee', 'event'])->where('ticket_id', $ticket_id)->firstOrFail();

        // Prevent attendance for past events
        if ($registration->event->date < now()->toDateString()) {
            return back()->with('error', '❌ Tukio hili lilishapita (Event has ended). Tiketi hii imechuja wakati.');
        }

        if ($request->action === 'check_in') {
            if ($registration->attended && $registration->status !== 'Checked-Out') {
                return back()->with('error', 'Mshiriki huyu tayari amesajiliwa kuingia (Already checked in).');
            }
            $registration->update([
                'status' => 'Attended',
                'attended' => true,
                'checked_in_at' => now(),
                'checked_out_at' => null, // Reset check-out if re-entering
            ]);
            return back()->with('success', '✅ ' . $registration->attendee->full_name . ' ameingizwa kikamilifu! (Checked in at ' . now()->format('h:i:s A') . ')');
        }

        if ($request->action === 'check_out') {
            if (!$registration->attended) {
                return back()->with('error', 'Mshiriki huyu hajaingizwa bado. Tafadhali sajili kuingia kwanza (Not checked in yet).');
            }
            if ($registration->status === 'Checked-Out') {
                return back()->with('error', 'Mshiriki huyu tayari ametoka (Already checked out).');
            }
            $registration->update([
                'status' => 'Checked-Out',
                'checked_out_at' => now(),
            ]);
            return back()->with('success', '🚪 ' . $registration->attendee->full_name . ' ametoka kikamilifu! (Checked out at ' . now()->format('h:i:s A') . ')');
        }

        return back()->with('error', 'Kitendo kisichojulikana (Unknown action).');
    }
}
