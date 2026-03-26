@extends('layouts.app')

@section('title', 'Ticket Verification')

@section('content')
<style>
    @media (max-width: 600px) {
        .verify-card { padding: 1.5rem !important; }
        .verify-container { padding: 2rem 1rem !important; }
    }
</style>
<div class="container verify-container" style="padding: 4rem 0; display: flex; justify-content: center;">
    <div class="card verify-card" style="width: 100%; max-width: 500px; padding: 2.5rem; text-align: center;">
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
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Ticket ID</p>
                    <h4 style="margin: 0; font-family: monospace; color: #333;">{{ $registration->ticket_id }}</h4>
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
                <div style="margin-top: 1.5rem; border-top: 1px solid #f1f1f1; pt: 1.5rem;">
                    @if(!$registration->check_in_at)
                        <form action="{{ route('registrations.attendance', $registration->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="check_in">
                            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem; box-shadow: 0 4px 15px rgba(148,0,0,0.2); background: #166534; border-color: #166534;">
                                <i class="fa-solid fa-right-to-bracket" style="margin-right: 8px;"></i> Check-in Attendee
                            </button>
                        </form>
                    @elseif(!$registration->check_out_at)
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 8px; margin-bottom: 15px; text-align: left;">
                            <p style="color: #166534; font-weight: 700; margin-bottom: 5px; font-size: 0.85rem;">
                                <i class="fa-solid fa-circle-check"></i> Checked in: {{ \Carbon\Carbon::parse($registration->check_in_at)->format('h:i A') }}
                            </p>
                            <p style="color: #666; font-size: 0.75rem; margin: 0;">Arrival recorded on {{ \Carbon\Carbon::parse($registration->check_in_at)->format('M d, Y') }}</p>
                        </div>
                        
                        <form action="{{ route('registrations.attendance', $registration->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="check_out">
                            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: #94a3b8; border-color: #94a3b8;">
                                <i class="fa-solid fa-right-from-bracket" style="margin-right: 8px;"></i> Check-out Attendee
                            </button>
                        </form>
                    @else
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                            <div style="display: flex; flex-direction: column; gap: 10px; text-align: left;">
                                <div style="display: flex; justify-content: space-between; border-bottom: 1px dashed #e2e8f0; pb: 8px;">
                                    <span style="font-size: 0.8rem; color: #64748b;">Check-in</span>
                                    <span style="font-weight: 700; color: #1e293b;">{{ \Carbon\Carbon::parse($registration->check_in_at)->format('h:i A') }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 0.8rem; color: #64748b;">Check-out</span>
                                    <span style="font-weight: 700; color: #1e293b;">{{ \Carbon\Carbon::parse($registration->check_out_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                            <div style="margin-top: 15px; color: #166534; font-weight: 800; font-size: 0.9rem;">
                                <i class="fa-solid fa-square-check"></i> Attendance Complete
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('registrations.attendance', $registration->id) }}" method="POST" style="margin-top: 15px;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Absent">
                        <button type="submit" style="background: none; border: none; color: #94a3b8; font-size: 0.75rem; text-decoration: underline; cursor: pointer;" onclick="return confirm('Reset attendance for this member?')">
                            Reset Attendance Record
                        </button>
                    </form>
                </div>
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
