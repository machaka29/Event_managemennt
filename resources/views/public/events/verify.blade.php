@extends('layouts.app')

@section('title', 'Ticket Verification')

@section('content')
<div class="container" style="padding: 4rem 0; display: flex; justify-content: center;">
    <div class="card" style="width: 100%; max-width: 500px; padding: 2.5rem; text-align: center;">
        <div style="margin-bottom: 2rem;">
            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" style="margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="width: 80px; height: 80px; background: var(--corporate-red); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem;">
                ✓
            </div>
            <h2 style="color: var(--corporate-red); margin-bottom: 0.5rem;">Valid Ticket</h2>
            <p style="color: var(--text-muted); font-size: 1.1rem;">This ticket is authentic and registered.</p>
        </div>

        <div style="background: var(--primary-bg); padding: 1.5rem; border-radius: 8px; text-align: left; margin-bottom: 2rem;">
            <div style="margin-bottom: 1.5rem; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
                <h3 style="margin-bottom: 10px; color: var(--corporate-red); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Member Details</h3>
                <div style="margin-bottom: 1rem;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Full Name</p>
                    <h4 style="margin: 0; font-size: 1.1rem;">{{ $registration->attendee->full_name }}</h4>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Email / Phone</p>
                    <h4 style="margin: 0; font-weight: 500;">{{ $registration->attendee->email }} | {{ $registration->attendee->phone }}</h4>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Member ID / Access ID</p>
                    <h4 style="margin: 0; font-family: monospace; color: #333;">{{ $registration->attendee->access_code }}</h4>
                </div>
                @if($registration->attendee->organization)
                <div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Organization</p>
                    <h4 style="margin: 0; font-weight: 500;">{{ $registration->attendee->organization }}</h4>
                </div>
                @endif
            </div>

            <div style="margin-top: 1rem;">
                <h3 style="margin-bottom: 10px; color: var(--corporate-red); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Event Info</h3>
                <div style="margin-bottom: 1rem;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Event Title</p>
                    <h4 style="margin: 0;">{{ $registration->event->title }}</h4>
                </div>
                <div style="margin-bottom: 1rem;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Ticket ID</p>
                    <h4 style="margin: 0; color: var(--corporate-red); letter-spacing: 1px;">{{ $registration->ticket_id }}</h4>
                </div>
                <div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Status</p>
                    @if($registration->attended)
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; background: var(--corporate-red); color: white; border-radius: 999px; font-size: 0.8rem; font-weight: bold;">Verified & Checked In</span>
                    @else
                        <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #f3f3f3; color: #666; border-radius: 999px; font-size: 0.8rem; font-weight: bold; border: 1px solid #ddd;">Authentic - Not Checked In</span>
                    @endif
                </div>
            </div>
        </div>

        @auth
            @if(auth()->user()->role === 'organizer' || auth()->user()->role === 'admin')
                @if($registration->status !== 'Attended')
                    <form action="{{ route('registrations.attendance', $registration->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Attended">
                        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem;">
                            Mark as Attended
                        </button>
                    </form>
                @else
                    <button class="btn btn-outline" disabled style="width: 100%; font-size: 1.1rem; padding: 1rem; border-color: grey; color: grey;">
                        Attendance Already Marked
                    </button>
                @endif
            @endif
        @endauth
        
        @guest
            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                <p style="font-size: 0.85rem; color: var(--text-muted);">Are you an organizer? <a href="{{ route('login') }}" style="color: var(--corporate-red);">Log in to mark attendance</a>.</p>
            </div>
        @endguest
    </div>
</div>
@endsection
