@extends('layouts.app')

@section('title', 'Ticket Verification - Scanner')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;800&family=Outfit:wght@400;600;800;900&display=swap');

    .scanner-page-wrapper { 
        min-height: 100vh; 
        background: #0f172a; 
        font-family: 'Outfit', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .futuristic-scanner-card {
        width: 100%;
        max-width: 480px;
        background: #1e293b;
        border-radius: 32px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 40px 100px -20px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .scanner-status-header {
        padding: 40px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Status Themes */
    .theme-valid { background: linear-gradient(180deg, rgba(16, 185, 129, 0.2) 0%, transparent 100%); }
    .theme-invalid { background: linear-gradient(180deg, rgba(239, 68, 68, 0.2) 0%, transparent 100%); }
    .theme-warning { background: linear-gradient(180deg, rgba(245, 158, 11, 0.2) 0%, transparent 100%); }

    .scanner-ring {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .ring-valid { background: rgba(16, 185, 129, 0.1); border: 4px solid #10b981; color: #10b981; box-shadow: 0 0 40px rgba(16, 185, 129, 0.3); }
    .ring-invalid { background: rgba(239, 68, 68, 0.1); border: 4px solid #ef4444; color: #ef4444; box-shadow: 0 0 40px rgba(239, 68, 68, 0.3); }
    .ring-pending { background: rgba(245, 158, 11, 0.1); border: 4px solid #f59e0b; color: #f59e0b; box-shadow: 0 0 40px rgba(245, 158, 11, 0.3); }

    .status-text { font-size: 1.5rem; font-weight: 900; letter-spacing: 1px; color: white; text-transform: uppercase; margin-bottom: 5px; }
    .status-sub { font-size: 0.85rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; }

    .scanner-content { padding: 0 30px 40px; }

    .glass-info-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .info-label-micro { font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px; display: block; }
    .info-value-large { font-size: 1.25rem; font-weight: 800; color: white; display: block; margin-bottom: 12px; }
    .info-grid-scanner { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-top: 1px solid rgba(255,255,255,0.05); pt-15; margin-top: 15px; }

    .action-container-scanner { position: relative; }

    .btn-scanner-action {
        width: 100%;
        padding: 22px;
        border-radius: 20px;
        border: none;
        font-size: 1.1rem;
        font-weight: 900;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-green { background: #10b981; color: white; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4); }
    .btn-green:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(16, 185, 129, 0.5); }
    
    .btn-slate { background: #334155; color: white; border: 1px solid rgba(255,255,255,0.1); }
    .btn-slate:hover { background: #1e293b; border-color: rgba(255,255,255,0.2); }

    .btn-locked { background: #0f172a; color: #475569; pointer-events: none; opacity: 0.6; }

    .pin-input-field {
        background: rgba(0,0,0,0.2);
        border: 2px solid #334155;
        border-radius: 16px;
        padding: 20px;
        width: 100%;
        color: white;
        font-size: 1.5rem;
        text-align: center;
        letter-spacing: 10px;
        font-family: 'JetBrains Mono', monospace;
        margin: 15px 0;
        transition: 0.3s;
    }
    .pin-input-field:focus { border-color: #10b981; background: rgba(0,0,0,0.4); outline: none; box-shadow: 0 0 20px rgba(16, 185, 129, 0.2); }

    .alert-micro { padding: 12px 16px; border-radius: 12px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
    .alert-micro-success { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
    .alert-micro-error { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }

    .nav-top-scanner { position: absolute; top: 0; left: 0; right: 0; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; z-index: 10; }
    .back-nav-scanner { color: #64748b; text-decoration: none; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 6px; }
    .back-nav-scanner:hover { color: white; }

    /* Scan line animation */
    .scan-line { position: absolute; height: 2px; width: 100%; background: #10b981; box-shadow: 0 0 10px #10b981; animation: scanning 3s linear infinite; opacity: 0; }
    .active-scanning .scan-line { opacity: 0.4; }
    @keyframes scanning { 0% { top: 0%; } 100% { top: 100%; } }

    @media (max-width: 480px) {
        .scanner-page-wrapper { padding: 0; }
        .futuristic-scanner-card { border-radius: 0; height: 100vh; }
    }
</style>

<div class="scanner-page-wrapper">
    <div class="futuristic-scanner-card {{ $isExpired ? 'theme-invalid' : ($registration->attended ? 'theme-valid' : 'theme-warning') }}">
        <div class="scan-line"></div>
        
        <div class="nav-top-scanner">
            <a href="{{ route('home') }}" class="back-nav-scanner">
                <i class="fa-solid fa-house"></i>
            </a>
            @if(session('gate_pass_' . $registration->event->id) === true)
                <a href="{{ route('events.public.verify', ['ticket_id' => $registration->ticket_id, 'reset' => 1]) }}" class="back-nav-scanner" style="color: #ef4444;">
                    <i class="fa-solid fa-lock-open"></i> LOCK
                </a>
            @endif
        </div>

        <div class="scanner-status-header">
            @if($isExpired)
                <div class="scanner-ring ring-invalid">
                    <i class="fa-solid fa-calendar-xmark fa-2x"></i>
                </div>
                <div class="status-text">Expired</div>
                <div class="status-sub">Access Terminated</div>
            @elseif($registration->status === 'Checked-Out')
                <div class="scanner-ring ring-invalid" style="border-color: #cbd5e1; color: #cbd5e1; box-shadow: none;">
                    <i class="fa-solid fa-door-open fa-2x"></i>
                </div>
                <div class="status-text">Checked Out</div>
                <div class="status-sub">Departure Recorded</div>
            @elseif($registration->attended)
                <div class="scanner-ring ring-valid">
                    <i class="fa-solid fa-check-double fa-2x"></i>
                </div>
                <div class="status-text">Active Entry</div>
                <div class="status-sub">Attendance Confirmed</div>
            @else
                <div class="scanner-ring ring-pending">
                    <i class="fa-solid fa-clock fa-2x"></i>
                </div>
                <div class="status-text">Valid Ticket</div>
                <div class="status-sub">Awaiting Entry</div>
            @endif
        </div>

        <div class="scanner-content">
            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert-micro alert-micro-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-micro alert-micro-error">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            <div class="glass-info-card">
                <span class="info-label-micro">Primary Guest</span>
                <span class="info-value-large">{{ $registration->attendee->full_name }}</span>
                
                <div class="info-grid-scanner">
                    <div>
                        <span class="info-label-micro">Ticket Reference</span>
                        <span style="color: #10b981; font-family: 'JetBrains Mono', monospace; font-weight: 800; font-size: 0.9rem;">#{{ $registration->ticket_id }}</span>
                    </div>
                    <div>
                        <span class="info-label-micro">Contact Info</span>
                        <span style="color: white; font-weight: 700; font-size: 0.85rem;">{{ $registration->attendee->phone }}</span>
                    </div>
                </div>
            </div>

            <div class="glass-info-card" style="border-style: dashed;">
                <span class="info-label-micro">Experience Title</span>
                <span style="color: white; font-weight: 700; font-size: 1rem; display: block;">{{ $registration->event->title }}</span>
                <span style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 5px;">
                    <i class="fa-solid fa-location-dot"></i> {{ $registration->event->location }}
                </span>
            </div>

            @php
                $sessionKey = 'gate_pass_' . $registration->event->id;
                $isAuthorized = session($sessionKey) === true;
            @endphp

            @if(!$isExpired)
                <form action="{{ route('public.attendance.update', $registration->ticket_id) }}" method="POST" class="action-container-scanner">
                    @csrf
                    
                    @if(!$isAuthorized)
                        <div style="margin-bottom: 25px;">
                            <span class="info-label-micro" style="text-align: center; display: block; margin-bottom: 0;">AUTHORIZATION PIN REQUIRED</span>
                            <input type="password" name="gate_password" class="pin-input-field" placeholder="••••" required maxlength="4">
                            <p style="color: #475569; font-size: 0.7rem; text-align: center; font-weight: 700;">Enter the 4-digit security code for this event</p>
                        </div>
                    @endif

                    @if(!$registration->attended || $registration->status === 'Checked-Out')
                        <input type="hidden" name="action" value="check_in">
                        <button type="submit" class="btn-scanner-action btn-green">
                            <i class="fa-solid fa-bolt"></i> RECORD ENTRY
                        </button>
                    @elseif($registration->attended && $registration->status !== 'Checked-Out')
                        <input type="hidden" name="action" value="check_out">
                        <button type="submit" class="btn-scanner-action btn-slate">
                            <i class="fa-solid fa-door-open"></i> RECORD EXIT
                        </button>
                    @endif
                </form>
            @else
                <div class="btn-scanner-action btn-locked">
                    <i class="fa-solid fa-lock"></i> SYSTEM LOCKED
                </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.65rem; color: #475569; letter-spacing: 2px;">
                    QUANTUM VERIFICATION SYSTEM &bull; v2.4
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-focus PIN if not authorized
        const pinInput = document.querySelector('.pin-input-field');
        if(pinInput) pinInput.focus();

        // Add scanning class if checking in
        @if(!$registration->attended && !$isExpired)
            document.querySelector('.futuristic-scanner-card').classList.add('active-scanning');
        @endif
    });
</script>
@endsection
