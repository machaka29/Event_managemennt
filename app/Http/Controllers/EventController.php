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
        $events = \App\Models\Event::with('registrations')->latest()->get();
        return view('dashboard', compact('events'));
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

    private function authorizeOwner(\App\Models\Event $event)
    {
        // Allow all Admins and Organizers to manage all events
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'organizer') {
            return;
        }

        if ($event->organizer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
