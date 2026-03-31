@extends('layouts.app')

@section('title', 'Confirmation Ticket - ' . $registration->event->title)

@section('content')
<div class="ticket-page-wrapper">
    <div class="container">
        
        <!-- Back Navigation at the top -->
        <div class="nav-back-container">
            @php
                $backUrl = route('home');
                $backText = 'Return to Events';
                if(auth()->check()) {
                    if(auth()->user()->role === 'admin') {
                        $backUrl = route('admin.dashboard');
                        $backText = 'Back to Admin Dashboard';
                    } elseif(auth()->user()->role === 'organizer') {
                        $backUrl = route('dashboard');
                        $backText = 'Back to Organizer Panel';
                    }
                }
            @endphp
            <a href="{{ $backUrl }}" class="btn-back-link">
                <i class="fa-solid fa-arrow-left"></i> {{ $backText }}
            </a>
        </div>

        <!-- The Main Ticket Container -->
        <div class="confirmation-ticket-card">
            
            <div class="ticket-header-logo">
                <div>
                    <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" class="emca-logo">
                    <span class="system-tag">EVENTS REGISTRATION</span>
                </div>
                <h1 class="ticket-title">CONFIRMATION TICKET</h1>
            </div>

            <div class="ticket-grid-top">
                <!-- Left: Event Details -->
                <div class="event-details-section">
                    <h3 class="section-heading">EVENT DETAILS</h3>
                    
                    <div class="detail-row">
                        <span class="detail-label">Event:</span>
                        <span class="detail-value fw-bold" style="font-size: 1.15rem;">{{ $registration->event->title }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Date:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($registration->event->date)->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Time:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}</span>
                    </div>
                    
                    <div class="detail-row align-top">
                        <span class="detail-label">Venue:</span>
                        <span class="detail-value">
                            {{ $registration->event->location }}<br>
                            @if($registration->event->venue)
                            <span class="sub-venue">{{ $registration->event->venue }}</span>
                            @endif
                        </span>
                    </div>

                    <div class="ticket-id-box">
                        <span class="detail-label">Ticket ID:</span>
                        <span class="detail-value text-red fw-bold mono-font">{{ $registration->ticket_id }}</span>
                    </div>
                </div>

                <!-- Right: QR Code -->
                <div class="qr-code-section">
                    <div class="qr-box">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrData) }}&margin=0" alt="QR Code" class="qr-image">
                    </div>
                    <p class="qr-instructions">Scan to verify attendance</p>
                </div>
            </div>

            <!-- Middle: Attendee Info -->
            <div class="info-block">
                <div class="block-header">ATTENDEE INFORMATION</div>
                <div class="block-content two-columns">
                    <div>
                        <div class="info-entry">
                            <span class="info-label">Name:</span>
                            <span class="info-text fw-bold">{{ $registration->attendee->full_name }}</span>
                        </div>
                        <div class="info-entry">
                            <span class="info-label">Organization:</span>
                            <span class="info-text">{{ $registration->attendee->organization ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="info-entry">
                            <span class="info-label">Phone:</span>
                            <span class="info-text">{{ $registration->attendee->phone }}</span>
                        </div>
                        <div class="info-entry">
                            <span class="info-label">Email:</span>
                            <span class="info-text">{{ $registration->attendee->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle: Ticket Info -->
            <div class="info-block mb-4">
                <div class="block-content bg-light-gray flex-row-info">
                    <div class="flex-item">
                        <span class="info-label">Ticket Type:</span>
                        <span class="info-text fw-bold">Standard Access</span>
                    </div>
                    <div class="flex-item border-left-divider">
                        <span class="info-label">Registration Date:</span>
                        <span class="info-text fw-bold">{{ $registration->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex-item border-left-divider">
                        <span class="info-label">Registration No:</span>
                        <span class="info-text mono-font">{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

            <!-- Warning Section -->
            <div class="warning-alert">
                <div class="warning-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="warning-text">
                    <strong>IMPORTANT:</strong> Please bring this ticket (digital or printed) for entry. The QR code will be scanned at the door for verification. Treat this ticket like cash.
                </div>
            </div>

            <!-- Actions Footer -->
            <div class="ticket-actions">
                <a href="{{ route('events.public.ticket.download', $registration->ticket_id) }}" class="action-btn btn-solid-red">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </a>
                
                <button onclick="window.print()" class="action-btn btn-outline-red">
                    <i class="fa-solid fa-print"></i> Print Ticket
                </button>
            </div>

        </div>
    </div>
</div>

<style>
/* Base Fonts & Wrappers */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

.ticket-page-wrapper {
    background-color: #f3f4f6;
    min-height: 100vh;
    padding: 3rem 15px;
    font-family: 'Inter', sans-serif;
    display: flex;
    justify-content: center;
}

.nav-back-container {
    max-width: 750px;
    margin: 0 auto 1.5rem auto;
}

.btn-back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #4b5563;
    font-weight: 600;
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.2s;
}

.btn-back-link:hover {
    color: var(--corporate-red);
}

/* The Ticket Card */
.confirmation-ticket-card {
    background: #ffffff;
    max-width: 750px;
    margin: 0 auto;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    border-top: 8px solid var(--corporate-red);
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
    padding: 40px 45px;
    color: #1f2937;
}

.fw-bold { font-weight: 700 !important; }
.text-red { color: var(--corporate-red); }
.mono-font { font-family: 'Courier New', Courier, monospace; letter-spacing: 0.5px; }

/* Header */
.ticket-header-logo {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 35px;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 20px;
}

.emca-logo {
    height: 30px;
    display: block;
    margin-bottom: 8px;
}

.system-tag {
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 1.5px;
    color: #9ca3af;
    text-transform: uppercase;
}

.ticket-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #111827;
    margin: 0;
    text-align: right;
    letter-spacing: -0.5px;
}

/* Top Grid (Details + QR) */
.ticket-grid-top {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    margin-bottom: 35px;
}

.event-details-section {
    flex: 1;
}

.section-heading {
    font-size: 0.8rem;
    font-weight: 800;
    color: var(--corporate-red);
    letter-spacing: 1px;
    margin: 0 0 20px 0;
}

.detail-row {
    display: flex;
    margin-bottom: 12px;
    align-items: center;
}

.detail-row.align-top {
    align-items: flex-start;
}

.detail-label {
    width: 90px;
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 600;
    flex-shrink: 0;
}

.detail-value {
    font-size: 1rem;
    color: #1f2937;
    flex: 1;
}

.sub-venue {
    font-size: 0.85rem;
    color: #6b7280;
    display: block;
    margin-top: 4px;
}

.ticket-id-box {
    margin-top: 25px;
    background: #f9fafb;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px dashed #d1d5db;
    display: inline-flex;
    align-items: center;
}

/* QR Code Section */
.qr-code-section {
    width: 220px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.qr-box {
    background: #ffffff;
    border: 2px solid #f3f4f6;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    margin-bottom: 12px;
    width: 180px;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qr-image {
    width: 100%;
    height: 100%;
    mix-blend-mode: multiply;
}

.qr-instructions {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Info Blocks */
.info-block {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    margin-bottom: 25px;
    overflow: hidden;
}

.block-header {
    background: #f9fafb;
    padding: 12px 20px;
    font-size: 0.8rem;
    font-weight: 800;
    color: #111827;
    letter-spacing: 1px;
    border-bottom: 1px solid #e5e7eb;
}

.block-content {
    padding: 20px;
}

.block-content.two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px 30px;
}

.info-entry {
    margin-bottom: 10px;
    display: flex;
    align-items: baseline;
}

.info-entry:last-child {
    margin-bottom: 0;
}

.info-label {
    width: 110px;
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
    flex-shrink: 0;
}

.info-text {
    font-size: 0.95rem;
    color: #111827;
}

.bg-light-gray {
    background-color: #fafbfc;
}

.flex-row-info {
    display: flex;
    justify-content: space-between;
    padding: 15px 20px;
}

.flex-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
    flex: 1;
}

.border-left-divider {
    border-left: 1px solid #e5e7eb;
    padding-left: 20px;
}

.flex-item .info-label {
    width: auto;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Warning Section */
.warning-alert {
    background-color: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 8px;
    padding: 16px 20px;
    display: flex;
    gap: 15px;
    align-items: flex-start;
    margin-bottom: 35px;
}

.warning-icon {
    color: #d97706;
    font-size: 1.2rem;
    margin-top: 2px;
}

.warning-text {
    font-size: 0.9rem;
    color: #92400e;
    line-height: 1.5;
}

/* Actions */
.ticket-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    border-top: 2px dashed #e5e7eb;
    padding-top: 30px;
}

.action-btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    min-width: 220px;
}

.btn-solid-red {
    background-color: var(--corporate-red);
    color: white;
    border: 2px solid var(--corporate-red);
    box-shadow: 0 4px 12px rgba(148, 0, 0, 0.2);
}

.btn-solid-red:hover {
    background-color: #7a0000;
    border-color: #7a0000;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(148, 0, 0, 0.3);
}

.btn-outline-red {
    background-color: transparent;
    color: var(--corporate-red);
    border: 2px solid var(--corporate-red);
}

.btn-outline-red:hover {
    background-color: #fff5f5;
    transform: translateY(-2px);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .confirmation-ticket-card {
        padding: 25px 20px;
    }
    
    .ticket-header-logo {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .ticket-title {
        text-align: left;
        font-size: 1.4rem;
    }
    
    .ticket-grid-top {
        flex-direction: column;
        gap: 25px;
    }
    
    .qr-code-section {
        width: 100%;
        order: -1; /* Move QR to top on mobile */
        margin-bottom: 10px;
    }
    
    .qr-box {
        width: 160px;
        height: 160px;
    }
    
    .block-content.two-columns {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .flex-row-info {
        flex-direction: column;
        gap: 15px;
    }
    
    .border-left-divider {
        border-left: none;
        padding-left: 0;
        border-top: 1px solid #e5e7eb;
        padding-top: 15px;
    }
    
    .ticket-actions {
        flex-direction: column;
    }
    
    .action-btn {
        width: 100%;
    }
}

/* Print Styles */
@media print {
    @page {
        margin: 0;
        size: portrait;
    }
    
    /* Hide EVERYTHING by default */
    body * {
        visibility: hidden;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Hide layout elements completely */
    .top-nav, footer, .nav-back-container, .ticket-actions {
        display: none !important;
    }

    /* Show ONLY the ticket card and its children */
    .confirmation-ticket-card, 
    .confirmation-ticket-card * {
        visibility: visible;
        margin: 0 !important;
    }

    /* Position the ticket at the very top left */
    .confirmation-ticket-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        max-width: 100% !important;
        border: 1px solid #940000 !important;
        border-top: 8px solid #940000 !important;
        box-shadow: none !important;
        padding: 1.5rem !important; /* Slightly more compact for print */
    }

    body, .ticket-page-wrapper, .container, main {
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        min-height: 0 !important;
    }
}
</style>
@endsection
