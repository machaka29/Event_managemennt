<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $thisMonth = now()->startOfMonth();

        // 1. Basic Stats
        $allEvents = $user->events()->withCount('registrations')->latest()->get();
        $myEventsCount = $allEvents->count();
        
        $upcomingEvents = $allEvents->where('date', '>=', now()->format('Y-m-d'))->where('status', 'approved');
        $pastEvents = $allEvents->where('date', '<', now()->format('Y-m-d'))->where('status', 'approved');
        $draftEvents = $allEvents->where('status', 'pending');

        $upcomingEventsCount = $upcomingEvents->count();
        $totalAttendees = \App\Models\Registration::whereIn('event_id', $allEvents->pluck('id'))->count();
        
        // Growth stats
        $newAttendeesThisMonth = \App\Models\Registration::whereIn('event_id', $allEvents->pluck('id'))
            ->where('created_at', '>=', $thisMonth)
            ->count();
            
        // Mockup specific stats
        $ticketsIssued = $totalAttendees;
        $eventViews = number_format($totalAttendees * 4.5 + 120, 0); // Simulated views
        $viewsGrowth = "+215 this month"; // Simulated growth

        return view('dashboard', compact(
            'upcomingEvents', 
            'pastEvents', 
            'draftEvents',
            'upcomingEventsCount',
            'myEventsCount',
            'totalAttendees',
            'newAttendeesThisMonth',
            'ticketsIssued',
            'eventViews',
            'viewsGrowth'
        ));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'reg_start_date' => 'required|date|before_or_equal:date',
            'reg_end_date' => 'required|date|after_or_equal:reg_start_date|before_or_equal:date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('events', 'public');
        }

        auth()->user()->events()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Event created successfully!');
    }

    public function show(\App\Models\Event $event)
    {
        $this->authorizeOwner($event);
        return view('events.show', compact('event'));
    }

    public function edit(\App\Models\Event $event)
    {
        $this->authorizeOwner($event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, \App\Models\Event $event)
    {
        $this->authorizeOwner($event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'reg_start_date' => 'required|date|before_or_equal:date',
            'reg_end_date' => 'required|date|after_or_equal:reg_start_date|before_or_equal:date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('dashboard')->with('success', 'Event updated successfully!');
    }

    public function destroy(\App\Models\Event $event)
    {
        $this->authorizeOwner($event);
        $event->delete();
        return redirect()->route('dashboard')->with('success', 'Event deleted successfully!');
    }

    public function markAttendance(Request $request, \App\Models\Registration $registration)
    {
        $this->authorizeOwner($registration->event);

        $registration->update([
            'status' => $request->status,
            'attended' => ($request->status === 'Attended'),
        ]);

        return back()->with('success', 'Attendance updated successfully.');
    }

    public function exportAttendees(\App\Models\Event $event)
    {
        $this->authorizeOwner($event);

        $filename = "attendees_{$event->id}_" . now()->format('Y-m-d') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($event) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Full Name', 'Email', 'Phone', 'Organization', 'Ticket ID', 'Status', 'Registered At']);

            foreach ($event->registrations as $reg) {
                fputcsv($file, [
                    $reg->attendee->full_name,
                    $reg->attendee->email,
                    $reg->attendee->phone,
                    $reg->attendee->organization ?? 'N/A',
                    $reg->ticket_id,
                    $reg->status,
                    $reg->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function allEvents()
    {
        $events = auth()->user()->events()->withCount('registrations')->latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    public function allRegistrations()
    {
        $eventIds = auth()->user()->events()->pluck('id');
        $registrations = \App\Models\Registration::with(['event', 'attendee'])
            ->whereIn('event_id', $eventIds)
            ->latest()
            ->paginate(20);
        return view('events.registrations', compact('registrations'));
    }

    /**
     * Manage all unique attendees across events.
     */
    public function attendeesIndex()
    {
        // For organizers, show attendees who have registered for their events
        $eventIds = auth()->user()->events()->pluck('id');
        $attendeeIds = \App\Models\Registration::whereIn('event_id', $eventIds)->pluck('attendee_id')->unique();
        
        $attendees = \App\Models\Attendee::whereIn('id', $attendeeIds)
            ->withCount('registrations')
            ->latest()
            ->paginate(15);
            
        return view('events.attendees.index', compact('attendees'));
    }

    /**
     * Show form to manually create a new attendee (Member).
     */
    public function attendeeCreate()
    {
        return view('events.attendees.create');
    }

    /**
     * Store a manually created attendee with an access code.
     */
    public function attendeeStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
        ]);

        // Generate unique access code: EM-XXXX-RAND
        $count = \App\Models\Attendee::count() + 1;
        $access_code = 'EM-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        \App\Models\Attendee::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization' => $request->organization,
            'access_code' => $access_code,
        ]);

        return redirect()->route('organizer.attendees.index')->with('success', "Member created successfully! Access ID: $access_code");
    }

    public function attendeeEdit(\App\Models\Attendee $attendee)
    {
        return view('events.attendees.edit', compact('attendee'));
    }

    public function attendeeUpdate(Request $request, \App\Models\Attendee $attendee)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email,' . $attendee->id,
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
        ]);

        $attendee->update($request->only(['full_name', 'email', 'phone', 'organization']));

        return redirect()->route('organizer.attendees.index')->with('success', 'Member updated successfully.');
    }

    public function attendeeDestroy(\App\Models\Attendee $attendee)
    {
        $attendee->delete();
        return redirect()->route('organizer.attendees.index')->with('success', 'Member deleted successfully.');
    }

    public function reports()
    {
        $user = auth()->user();
        $eventIds = $user->events()->pluck('id');
        
        $totalEvents = $eventIds->count();
        $totalRegistrations = \App\Models\Registration::whereIn('event_id', $eventIds)->count();
        $totalAttended = \App\Models\Registration::whereIn('event_id', $eventIds)->where('attended', true)->count();
        
        $events = $user->events()->withCount(['registrations', 'registrations as attended_count' => function ($query) {
            $query->where('attended', true);
        }])->latest()->get();

        return view('events.reports', compact('events', 'totalEvents', 'totalRegistrations', 'totalAttended'));
    }

    private function authorizeOwner(\App\Models\Event $event)
    {
        if (strtolower(auth()->user()->role) === 'admin') {
            return;
        }

        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
