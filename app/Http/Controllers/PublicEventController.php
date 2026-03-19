<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Attendee;
use App\Models\Registration;
use Illuminate\Support\Str;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        $events = $query->latest()->get();
        return view('welcome', compact('events'));
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

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'organization' => 'nullable|string|max:255',
        ]);

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
        }

        $ticket_id = strtoupper(Str::random(8));

        Registration::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
            'ticket_id' => $ticket_id,
        ]);

        return redirect()->route('events.public.ticket', $ticket_id);
    }

    public function ticket($ticket_id)
    {
        $registration = Registration::where('ticket_id', $ticket_id)->firstOrFail();
        return view('public.events.ticket', compact('registration'));
    }
}
