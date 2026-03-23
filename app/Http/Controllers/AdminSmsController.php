<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Services\NextSmsService;
use Illuminate\Http\Request;

class AdminSmsController extends Controller
{
    protected $smsService;

    public function __construct(NextSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function create()
    {
        $events = Event::withCount('registrations')->get();
        return view('admin.sms.create', compact('events'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'target_audience' => 'required',
            'message' => 'required|string',
            'sender_id' => 'nullable|string|max:11',
        ]);

        $message = $request->message;
        $target = $request->target_audience;
        $sender = $request->sender_id;

        if ($target === 'all') {
            $attendees = Attendee::whereNotNull('phone')->get();
        } else {
            // Target is an event ID
            // Using Registration to get corresponding attendees
            $attendees = Attendee::whereHas('registrations', function($query) use ($target) {
                $query->where('event_id', $target);
            })->whereNotNull('phone')->get();
        }

        if ($attendees->isEmpty()) {
            return back()->with('error', 'No verified members found with phone numbers for this specific audience.');
        }

        $sentCount = 0;
        foreach ($attendees as $attendee) {
            $success = $this->smsService->sendSms($attendee->phone, $message, $sender);
            if ($success) {
                $sentCount++;
            }
        }

        return back()->with('success', "SMS Broadcast dispatched! Successfully sent to {$sentCount} members out of {$attendees->count()}.");
    }
}
