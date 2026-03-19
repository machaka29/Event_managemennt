@extends('layouts.app')

@section('title', 'Your Ticket - ' . $registration->event->title)

@section('content')
<div class="container" style="padding: 4rem 0; display: flex; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 600px; padding: 0; overflow: hidden; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <!-- Ticket Header -->
        <div style="background: var(--corporate-red); color: white; padding: 2rem; text-align: center;">
            <h2 style="color: white; margin-bottom: 0.5rem;">Registration Confirmed!</h2>
            <p style="opacity: 0.9;">See you at the event.</p>
        </div>

        <!-- Ticket Body -->
        <div style="padding: 2.5rem; background: white; border: 2px dashed var(--border-color); margin: 1rem; border-radius: 8px; position: relative;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 2rem;">
                <div>
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.5rem;">{{ $registration->event->title }}</h3>
                    <p style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($registration->event->date)->format('l, F d, Y') }}</p>
                    <p style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}</p>
                </div>
                <!-- QR Code -->
                <div style="width: 100px; height: 100px; border: 1px solid var(--border-color); padding: 0.25rem; background: white;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('events.public.verify', $registration->ticket_id)) }}" alt="QR Code" style="width: 100%; height: 100%;">
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid var(--border-color); margin: 1.5rem 0;">

            <div class="grid grid-cols-2">
                <div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Attendee</p>
                    <p style="font-weight: bold;">{{ $registration->attendee->full_name }}</p>
                </div>
                <div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Location</p>
                    <p style="font-weight: bold;">{{ $registration->event->location }}</p>
                </div>
            </div>

            <div style="margin-top: 2rem; text-align: center;">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">Unique Ticket ID</p>
                <h4 style="font-size: 1.5rem; letter-spacing: 2px; color: var(--corporate-red);">{{ $registration->ticket_id }}</h4>
            </div>
            
            <!-- Perforation circles -->
            <div style="position: absolute; left: -10px; bottom: 100px; width: 20px; height: 20px; background: var(--primary-bg); border-radius: 50%;"></div>
            <div style="position: absolute; right: -10px; bottom: 100px; width: 20px; height: 20px; background: var(--primary-bg); border-radius: 50%;"></div>
        </div>

        <!-- Ticket Footer -->
        <div style="padding: 1.5rem; text-align: center; background: var(--accent-soft-red);">
            <button onclick="window.print()" class="btn btn-primary">Print Ticket</button>
            <p style="margin-top: 1rem; font-size: 0.8rem;">Please present this ticket at the entrance.</p>
        </div>
    </div>
</div>
@endsection
