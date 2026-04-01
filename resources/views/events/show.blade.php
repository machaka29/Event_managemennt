@extends('layouts.organizer')

@section('title', $event->title . ' - EmCa Techonologies')

@section('content')
<style>
    .ev-show-wrap { font-family: 'Century Gothic', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }

    /* ── HERO HEADER ── */
    .ev-hero-header {
        background: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
        border-radius: 16px;
        padding: 35px 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        color: #1e293b;
        border: 1px solid #e2e8f0;
        border-top: 4px solid var(--corporate-red);
    }

    .ev-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
        position: relative;
        z-index: 2;
    }
    .ev-hero-info { flex: 1; min-width: 250px; }
    .ev-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--accent-soft-red);
        color: var(--corporate-red);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 16px;
        border: 1px solid rgba(148,0,0,0.1);
    }
    .ev-hero-title {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 12px;
        letter-spacing: -0.5px;
        line-height: 1.15;
        color: #1e293b;
    }
    .ev-hero-sub {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ev-hero-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        position: relative;
        z-index: 2;
    }
    .ev-hero-btn {
        padding: 12px 22px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .ev-btn-primary {
        background: var(--corporate-red);
        color: white;
        box-shadow: 0 4px 15px rgba(148,0,0,0.2);
    }
    .ev-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(148,0,0,0.3); }
    .ev-btn-glass {
        background: #FFFFFF;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .ev-btn-glass:hover { background: var(--accent-soft-red); color: var(--corporate-red); border-color: rgba(148,0,0,0.2); }
    .ev-btn-danger-glass {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }
    .ev-btn-danger-glass:hover { background: #fee2e2; }

    /* ── META STRIP ── */
    .ev-meta-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 30px;
        position: relative;
        z-index: 2;
    }
    .ev-meta-item {
        background: #FFFFFF;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .ev-meta-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--accent-soft-red);
        color: var(--corporate-red);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .ev-meta-label { font-size: 0.6rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
    .ev-meta-value { font-size: 0.95rem; color: #1e293b; font-weight: 700; margin-top: 3px; }

    /* ── MAIN GRID ── */
    .ev-main-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
        align-items: flex-start;
    }

    /* ── CARDS ── */
    .ev-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: box-shadow 0.3s;
    }
    .ev-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
    .ev-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }
    .ev-card-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .ev-card-title i { color: var(--corporate-red); font-size: 0.9rem; }
    .ev-card-body { padding: 28px; }

    /* ── DESCRIPTION ── */
    .ev-description {
        color: #475569;
        line-height: 1.75;
        font-size: 0.95rem;
        white-space: pre-wrap;
    }

    /* ── EVENT IMAGE ── */
    .ev-image-container {
        margin-top: 24px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }
    .ev-image-container img {
        width: 100%;
        display: block;
        object-fit: cover;
        max-height: 300px;
    }

    /* ── ATTENDEE TABLE ── */
    .ev-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .ev-table { width: 100%; border-collapse: collapse; min-width: 650px; }
    .ev-table thead tr { background: #f8fafc; }
    .ev-table th {
        padding: 14px 28px;
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 800;
        color: #94a3b8;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }
    .ev-table td {
        padding: 16px 28px;
        font-size: 0.88rem;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
    }
    .ev-table tbody tr { transition: background 0.2s; }
    .ev-table tbody tr:hover { background: #fafbfc; }
    .ev-attendee-name { font-weight: 700; color: #1e293b; }
    .ev-ticket-mono { font-family: 'Courier New', monospace; color: var(--corporate-red); font-weight: 700; font-size: 0.8rem; }
    .ev-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .ev-badge-in { background: #ecfdf5; color: #059669; }
    .ev-badge-out { background: #f1f5f9; color: #475569; }
    .ev-badge-pending { background: #fffbeb; color: #d97706; }

    .ev-empty-state {
        padding: 60px 30px;
        text-align: center;
    }
    .ev-empty-state i { font-size: 3rem; color: #e2e8f0; margin-bottom: 15px; display: block; }
    .ev-empty-state p { color: #94a3b8; font-weight: 600; font-size: 0.9rem; }

    /* ── CAPACITY CARD ── */
    .ev-capacity-visual { text-align: center; padding: 35px 28px; }
    .ev-capacity-ring {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: conic-gradient(
            var(--corporate-red) calc(var(--percent) * 1%),
            #f1f5f9 0
        );
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .ev-capacity-inner {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .ev-cap-number { font-size: 2.2rem; font-weight: 900; color: #1e293b; line-height: 1; }
    .ev-cap-total { font-size: 0.7rem; color: #94a3b8; font-weight: 700; margin-top: 4px; }
    .ev-cap-label { font-size: 0.75rem; color: #64748b; font-weight: 700; }
    .ev-cap-percent {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 12px;
        padding: 6px 16px;
        background: var(--accent-soft-red);
        color: var(--corporate-red);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 800;
    }

    /* ── REGISTRATION WINDOW CARD ── */
    .ev-reg-window { padding: 24px 28px; }
    .ev-reg-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .ev-reg-row:last-child { border-bottom: none; }
    .ev-reg-key { font-size: 0.78rem; color: #64748b; font-weight: 600; }
    .ev-reg-val { font-size: 0.85rem; color: #1e293b; font-weight: 700; }
    .ev-status-dot {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .ev-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .ev-dot-green { background: #10b981; box-shadow: 0 0 6px rgba(16,185,129,0.4); }
    .ev-dot-red { background: #ef4444; }
    .ev-dot-amber { background: #f59e0b; }

    /* ── LINK CARD ── */
    .ev-link-container { padding: 24px 28px; }
    .ev-link-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        display: block;
    }
    .ev-link-row {
        display: flex;
        gap: 8px;
        margin-bottom: 14px;
    }
    .ev-link-input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.78rem;
        color: #475569;
        background: #f8fafc;
        font-family: 'Courier New', monospace;
        min-width: 0;
    }
    .ev-link-btn {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
        font-size: 1rem;
    }
    .ev-link-btn-copy { background: #1e293b; color: white; }
    .ev-link-btn-copy:hover { background: #0f172a; transform: scale(1.05); }
    .ev-link-btn-wa { background: #25D366; color: white; text-decoration: none; }
    .ev-link-btn-wa:hover { background: #1da954; transform: scale(1.05); }
    .ev-link-hint { font-size: 0.72rem; color: #94a3b8; font-weight: 500; line-height: 1.5; }

    .ev-export-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        color: var(--corporate-red);
        background: var(--accent-soft-red);
        border: 1px solid rgba(148,0,0,0.1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .ev-export-btn:hover { background: rgba(148,0,0,0.1); }

    /* ── RESPONSIVE ── */
    @media (max-width: 992px) {
        .ev-main-grid { grid-template-columns: 1fr; }
        .ev-hero-header { padding: 28px 24px; }
        .ev-hero-title { font-size: 1.5rem; }
        .ev-meta-strip { grid-template-columns: 1fr 1fr; }
        .ev-card-body { padding: 20px; }
        .ev-card-header { padding: 16px 20px; }
        .ev-table th, .ev-table td { padding: 12px 16px; }
    }
    @media (max-width: 576px) {
        .ev-meta-strip { grid-template-columns: 1fr; }
        .ev-hero-actions { width: 100%; }
        .ev-hero-btn { flex: 1; justify-content: center; font-size: 0.72rem; padding: 10px 14px; }
    }
</style>

<div class="ev-show-wrap">
    {{-- ═══ HERO HEADER ═══ --}}
    <div class="ev-hero-header">
        <div class="ev-hero-top">
            <div class="ev-hero-info">
                <div class="ev-hero-badge">
                    <i class="fa-solid fa-calendar-check"></i> My Event
                </div>
                <h1 class="ev-hero-title">{{ $event->title }}</h1>
                <div class="ev-hero-sub">
                    <i class="fa-solid fa-layer-group"></i>
                    {{ $event->category->name ?? 'General Event' }}
                </div>
            </div>
            <div class="ev-hero-actions">
                <a href="{{ route('events.public.show', $event->slug) }}" target="_blank" class="ev-hero-btn ev-btn-glass">
                    <i class="fa-solid fa-eye"></i> View Public
                </a>
                <a href="{{ route('events.edit', $event) }}" class="ev-hero-btn ev-btn-glass">
                    <i class="fa-solid fa-pencil"></i> Edit
                </a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ev-hero-btn ev-btn-danger-glass">
                        <i class="fa-solid fa-trash-can"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="ev-meta-strip">
            <div class="ev-meta-item">
                <div class="ev-meta-icon"><i class="fa-solid fa-calendar-day"></i></div>
                <div>
                    <div class="ev-meta-label">Date</div>
                    <div class="ev-meta-value">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</div>
                </div>
            </div>
            <div class="ev-meta-item">
                <div class="ev-meta-icon"><i class="fa-solid fa-clock"></i></div>
                <div>
                    <div class="ev-meta-label">Time</div>
                    <div class="ev-meta-value">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
                </div>
            </div>
            <div class="ev-meta-item">
                <div class="ev-meta-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <div class="ev-meta-label">Location</div>
                    <div class="ev-meta-value">{{ $event->location }}</div>
                </div>
            </div>
            @if($event->venue)
            <div class="ev-meta-item">
                <div class="ev-meta-icon"><i class="fa-solid fa-building"></i></div>
                <div>
                    <div class="ev-meta-label">Venue</div>
                    <div class="ev-meta-value">{{ $event->venue }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ═══ MAIN GRID ═══ --}}
    <div class="ev-main-grid">
        {{-- LEFT COLUMN --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">

            {{-- Description Card --}}
            <div class="ev-card">
                <div class="ev-card-header">
                    <div class="ev-card-title"><i class="fa-solid fa-align-left"></i> About This Event</div>
                </div>
                <div class="ev-card-body">
                    <div class="ev-description">{{ $event->description }}</div>
                    @if($event->image_path)
                    <div class="ev-image-container">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                    </div>
                    @endif
                </div>
            </div>

            {{-- Attendee Table Card --}}
            <div class="ev-card">
                <div class="ev-card-header">
                    <div class="ev-card-title"><i class="fa-solid fa-users"></i> Attendees</div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 0.78rem; font-weight: 800; color: var(--corporate-red); background: var(--accent-soft-red); padding: 5px 14px; border-radius: 20px;">
                            {{ $event->registrations->count() }} Registered
                        </span>
                        <a href="{{ route('events.export', $event) }}" class="ev-export-btn">
                            <i class="fa-solid fa-file-export"></i> Export CSV
                        </a>
                    </div>
                </div>

                @if($event->registrations()->count() > 0)
                <div class="ev-table-wrap">
                    <table class="ev-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Ticket ID</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Check-In</th>
                                <th style="text-align: center;">Check-Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->registrations as $reg)
                            <tr>
                                <td class="ev-attendee-name">{{ $reg->attendee->full_name }}</td>
                                <td class="ev-ticket-mono">{{ $reg->ticket_id }}</td>
                                <td style="text-align: center;">
                                    @if($reg->status === 'Checked-Out')
                                        <span class="ev-status-badge ev-badge-out"><i class="fa-solid fa-door-open"></i> Out</span>
                                    @elseif($reg->attended)
                                        <span class="ev-status-badge ev-badge-in"><i class="fa-solid fa-check-double"></i> In</span>
                                    @else
                                        <span class="ev-status-badge ev-badge-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($reg->checked_in_at)
                                        <div style="font-size: 0.82rem; font-weight: 700; color: #059669;">{{ $reg->checked_in_at->format('h:i A') }}</div>
                                        <div style="font-size: 0.6rem; color: #94a3b8;">{{ $reg->checked_in_at->format('M d') }}</div>
                                    @else
                                        <span style="color: #cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($reg->checked_out_at)
                                        <div style="font-size: 0.82rem; font-weight: 700; color: #475569;">{{ $reg->checked_out_at->format('h:i A') }}</div>
                                        <div style="font-size: 0.6rem; color: #94a3b8;">{{ $reg->checked_out_at->format('M d') }}</div>
                                    @else
                                        <span style="color: #cbd5e1;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="ev-empty-state">
                    <i class="fa-solid fa-users-slash"></i>
                    <p>No registrations yet. Share your event link to get started!</p>
                </div>
                @endif
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">

            {{-- Capacity Ring Card --}}
            @php
                $regCount = $event->registrations->count();
                $capacity = $event->capacity ?: 1;
                $percent = round(min(($regCount / $capacity) * 100, 100), 1);
            @endphp
            <div class="ev-card">
                <div class="ev-card-header">
                    <div class="ev-card-title"><i class="fa-solid fa-chart-pie"></i> Capacity</div>
                </div>
                <div class="ev-capacity-visual">
                    <div class="ev-capacity-ring" style="--percent: {{ $percent }}">
                        <div class="ev-capacity-inner">
                            <div class="ev-cap-number">{{ $regCount }}</div>
                            <div class="ev-cap-total">of {{ $event->capacity }}</div>
                        </div>
                    </div>
                    <div class="ev-cap-label">Registered Slots</div>
                    <div class="ev-cap-percent">
                        <i class="fa-solid fa-chart-simple"></i> {{ $percent }}% Filled
                    </div>
                </div>
            </div>

            {{-- Registration Window Card --}}
            <div class="ev-card">
                <div class="ev-card-header">
                    <div class="ev-card-title"><i class="fa-solid fa-calendar-days"></i> Registration Window</div>
                </div>
                <div class="ev-reg-window">
                    <div class="ev-reg-row">
                        <span class="ev-reg-key">Opens</span>
                        <span class="ev-reg-val">{{ \Carbon\Carbon::parse($event->reg_start_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="ev-reg-row">
                        <span class="ev-reg-key">Closes</span>
                        <span class="ev-reg-val">{{ \Carbon\Carbon::parse($event->reg_end_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="ev-reg-row">
                        <span class="ev-reg-key">Status</span>
                        <span class="ev-reg-val">
                            @php
                                $now = now();
                                $start = \Carbon\Carbon::parse($event->reg_start_date);
                                $end = \Carbon\Carbon::parse($event->reg_end_date);
                            @endphp
                            @if($now->lessThan($start))
                                <span class="ev-status-dot" style="color: #f59e0b;"><span class="ev-dot ev-dot-amber"></span> Upcoming</span>
                            @elseif($now->greaterThan($end))
                                <span class="ev-status-dot" style="color: #ef4444;"><span class="ev-dot ev-dot-red"></span> Closed</span>
                            @else
                                <span class="ev-status-dot" style="color: #10b981;"><span class="ev-dot ev-dot-green"></span> Open</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Registration Link Card --}}
            <div class="ev-card">
                <div class="ev-card-header">
                    <div class="ev-card-title"><i class="fa-solid fa-link"></i> Share Link</div>
                </div>
                <div class="ev-link-container">
                    <span class="ev-link-label">Public Registration URL</span>
                    <div class="ev-link-row">
                        <input type="text" id="publicLink" value="{{ route('events.public.show', $event->slug) }}" readonly class="ev-link-input">
                        <button onclick="copyLink()" id="copyBtn" class="ev-link-btn ev-link-btn-copy" title="Copy Link">
                            <i class="fa-solid fa-copy"></i>
                        </button>
                        <a href="https://wa.me/?text={{ urlencode('Check out our event ' . $event->title . ' and register here: ' . route('events.public.show', $event->slug)) }}" 
                           target="_blank" class="ev-link-btn ev-link-btn-wa" title="Share via WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                    <p class="ev-link-hint">
                        <i class="fa-solid fa-circle-info" style="color: #cbd5e1;"></i>
                        Share this link with attendees for self-registration.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink() {
    const input = document.getElementById('publicLink');
    const btn = document.getElementById('copyBtn');
    const original = btn.innerHTML;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(input.value).then(showCopied);
    } else {
        input.select();
        input.setSelectionRange(0, 99999);
        try { document.execCommand('copy'); showCopied(); } catch(e) {}
    }

    function showCopied() {
        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
        btn.style.background = '#059669';
        setTimeout(() => { btn.innerHTML = original; btn.style.background = '#1e293b'; }, 2000);
    }
}
</script>
@endsection
