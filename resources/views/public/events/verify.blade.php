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

            <div style="width: 80px; height: 80px; background: var(--success, #10b981); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem;">
                ✓
            </div>
            <h2 style="color: var(--success, #10b981); margin-bottom: 0.5rem;">Valid Ticket</h2>
            <p style="color: var(--text-muted); font-size: 1.1rem;">This ticket is authentic and registered.</p>
        </div>

        <div style="background: var(--primary-bg); padding: 1.5rem; border-radius: 8px; text-align: left; margin-bottom: 2rem;">
            <div style="margin-bottom: 1rem;">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.2rem;">Attendee Name</p>
                <h4 style="margin: 0;">{{ $registration->attendee->full_name }}</h4>
            </div>
            <div style="margin-bottom: 1rem;">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.2rem;">Event</p>
                <h4 style="margin: 0;">{{ $registration->event->title }}</h4>
            </div>
            <div style="margin-bottom: 1rem;">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.2rem;">Ticket ID</p>
                <h4 style="margin: 0; color: var(--corporate-red); letter-spacing: 1px;">{{ $registration->ticket_id }}</h4>
            </div>
            <div>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.2rem;">Attendance Status</p>
                @if($registration->status === 'Attended')
                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #d1fae5; color: #065f46; border-radius: 999px; font-size: 0.85rem; font-weight: bold;">Already Checked In</span>
                @else
                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: #fee2e2; color: #991b1b; border-radius: 999px; font-size: 0.85rem; font-weight: bold;">Not Checked In</span>
                @endif
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
