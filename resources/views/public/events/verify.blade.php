@extends('layouts.app')

@section('title', 'Ticket Verification - Scanner')

@section('content')
<style>
    .scanner-container { padding: 2rem 1rem; display: flex; justify-content: center; }
    .scanner-card { width: 100%; max-width: 520px; background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.12); overflow: hidden; }
    .scanner-header { background: var(--corporate-red); color: white; padding: 20px 25px; text-align: center; }
    .scanner-header h2 { margin: 0; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 800; }
    .scanner-body { padding: 25px; }
    .info-section { background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 20px; border: 1px solid #e2e8f0; }
    .info-section h3 { color: var(--corporate-red); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 12px; font-weight: 800; }
    .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2e8f0; align-items: center; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 0.8rem; color: #64748b; font-weight: 600; }
    .info-value { font-size: 0.9rem; color: #1e293b; font-weight: 700; text-align: right; }
    
    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .status-pending { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
    .status-in { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .status-out { background: #e2e8f0; color: #475569; border: 1px solid #94a3b8; }
    
    .time-card { background: linear-gradient(135deg, #f0fdf4, #ecfdf5); border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px 20px; margin-bottom: 8px; display: flex; align-items: center; gap: 15px; }
    .time-card.out { background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-color: #cbd5e1; }
    .time-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .time-icon.in { background: #10b981; color: white; }
    .time-icon.out { background: #64748b; color: white; }
    .time-label { font-size: 0.7rem; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; }
    .time-value { font-size: 1rem; color: #1e293b; font-weight: 800; }
    
    .action-btn { width: 100%; padding: 18px; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 800; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    .btn-checkin { background: linear-gradient(135deg, #059669, #10b981); color: white; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3); }
    .btn-checkin:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4); }
    .btn-checkout { background: linear-gradient(135deg, #334155, #475569); color: white; box-shadow: 0 8px 25px rgba(51, 65, 85, 0.3); }
    .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(51, 65, 85, 0.4); }
    .btn-disabled { background: #e2e8f0; color: #94a3b8; cursor: not-allowed; box-shadow: none; }
    .btn-disabled:hover { transform: none; box-shadow: none; }
    
    .alert-box { padding: 14px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    
    @media (max-width: 600px) {
        .scanner-container { padding: 1rem 0.5rem; }
        .scanner-body { padding: 15px; }
        .action-btn { font-size: 1rem; padding: 16px; }
    }
</style>

<div class="scanner-container">
    <div class="scanner-card">
        {{-- Header --}}
        <div class="scanner-header">
            <div style="font-size: 2rem; margin-bottom: 8px;">🎫</div>
            <h2>Ticket Verification</h2>
            <p style="margin: 5px 0 0; font-size: 0.8rem; opacity: 0.85;">Scanner / Attendance System</p>
        </div>

        <div class="scanner-body">
            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert-box alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-box alert-error">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            {{-- Ticket Status --}}
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 70px; height: 70px; background: var(--corporate-red); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 12px; box-shadow: 0 8px 20px rgba(148,0,0,0.2);">
                    ✓
                </div>
                <h3 style="color: var(--corporate-red); margin: 0 0 5px; font-size: 1.1rem;">Valid Ticket</h3>
                <div>
                    @if($registration->status === 'Checked-Out')
                        <span class="status-badge status-out"><i class="fa-solid fa-door-closed"></i> Checked Out</span>
                    @elseif($registration->attended)
                        <span class="status-badge status-in"><i class="fa-solid fa-check-double"></i> Checked In</span>
                    @else
                        <span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Pending Entry</span>
                    @endif
                </div>
            </div>

            {{-- Attendee Info --}}
            <div class="info-section">
                <h3><i class="fa-solid fa-user"></i> Attendee Details</h3>
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $registration->attendee->full_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value" style="font-size: 0.8rem;">{{ $registration->attendee->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $registration->attendee->phone }}</span>
                </div>
                @if($registration->attendee->organization)
                <div class="info-row">
                    <span class="info-label">Organization</span>
                    <span class="info-value">{{ $registration->attendee->organization }}</span>
                </div>
                @endif
            </div>

            {{-- Event Info --}}
            <div class="info-section">
                <h3><i class="fa-solid fa-calendar-day"></i> Event Info</h3>
                <div class="info-row">
                    <span class="info-label">Event</span>
                    <span class="info-value">{{ $registration->event->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ticket ID</span>
                    <span class="info-value" style="font-family: monospace; color: var(--corporate-red);">{{ $registration->ticket_id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Location</span>
                    <span class="info-value">{{ $registration->event->location }}</span>
                </div>
            </div>

            {{-- Timestamps --}}
            @if($registration->checked_in_at || $registration->checked_out_at)
            <div style="margin-bottom: 20px;">
                @if($registration->checked_in_at)
                <div class="time-card">
                    <div class="time-icon in"><i class="fa-solid fa-arrow-right-to-bracket"></i></div>
                    <div>
                        <div class="time-label">Time In (Muda wa Kuingia)</div>
                        <div class="time-value">{{ $registration->checked_in_at->format('h:i:s A') }}</div>
                        <div style="font-size: 0.75rem; color: #64748b;">{{ $registration->checked_in_at->format('D, M d Y') }}</div>
                    </div>
                </div>
                @endif
                @if($registration->checked_out_at)
                <div class="time-card out">
                    <div class="time-icon out"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                    <div>
                        <div class="time-label">Time Out (Muda wa Kutoka)</div>
                        <div class="time-value">{{ $registration->checked_out_at->format('h:i:s A') }}</div>
                        <div style="font-size: 0.75rem; color: #64748b;">{{ $registration->checked_out_at->format('D, M d Y') }}</div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            {{-- Action Buttons (Public - No Login Required) --}}
            <div style="margin-top: 10px;">
                @if(!$registration->attended || $registration->status === 'Checked-Out')
                    {{-- Show CHECK-IN button --}}
                    <form action="{{ route('public.attendance.update', $registration->ticket_id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="check_in">
                        <button type="submit" class="action-btn btn-checkin">
                            <i class="fa-solid fa-arrow-right-to-bracket" style="font-size: 1.3rem;"></i>
                            WEKA MAHUDHURIO - CHECK IN
                        </button>
                    </form>
                @elseif($registration->attended && $registration->status !== 'Checked-Out')
                    {{-- Already checked in - show success and CHECK-OUT --}}
                    <button class="action-btn btn-disabled" disabled>
                        <i class="fa-solid fa-check-double"></i>
                        ✅ AMEINGIZWA (CHECKED IN)
                    </button>
                    <form action="{{ route('public.attendance.update', $registration->ticket_id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="check_out">
                        <button type="submit" class="action-btn btn-checkout">
                            <i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 1.3rem;"></i>
                            WEKA KUTOKA - CHECK OUT
                        </button>
                    </form>
                @endif
            </div>

            {{-- Footer --}}
            <div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;">
                    <i class="fa-solid fa-shield-halved"></i> Secure Attendance System &bull; {{ config('app.name') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
