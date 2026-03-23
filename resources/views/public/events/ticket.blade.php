@extends('layouts.app')

@section('title', 'Your Ticket - ' . $registration->event->title)

@section('content')
<div class="container" style="padding: 4rem 0; display: flex; flex-direction: column; align-items: center;">
    <div class="card" style="width: 100%; max-width: 650px; padding: 0; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); background: white; border-radius: 16px;">
        <!-- Ticket Header -->
        <div style="background: var(--corporate-red); color: white; padding: 2.5rem 2rem; text-align: center; position: relative;">
            <div style="position: absolute; top: 1rem; left: 1rem; opacity: 0.2; font-family: 'Century Gothic', sans-serif; font-size: 0.8rem; letter-spacing: 2px;">OFFICIAL TICKET</div>
            <h2 style="color: white; margin-bottom: 0.5rem; font-size: 2rem;">Registration Confirmed!</h2>
            <p style="opacity: 0.9; font-size: 1.1rem;">Present this ticket at the event entrance.</p>
        </div>

        <!-- Ticket Body -->
        <div style="padding: 3rem; position: relative; border-bottom: 2px dashed #eee;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 2rem;">
                <div style="flex: 1;">
                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: var(--accent-soft-red); color: var(--corporate-red); border-radius: 20px; font-size: 0.75rem; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 1px;">Event Details</span>
                    <h3 style="margin-bottom: 0.75rem; font-size: 1.75rem; line-height: 1.2; color: #1a202c;">{{ $registration->event->title }}</h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568; margin-bottom: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>{{ \Carbon\Carbon::parse($registration->event->date)->format('l, F d, Y') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>{{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}</span>
                    </div>
                </div>
                
                <!-- Dynamic QR Code with Encoded Data -->
                @php
                    $qrData = "EVENT TICKET\n" .
                              "------------------\n" .
                              "Event: " . $registration->event->title . "\n" .
                              "Date: " . \Carbon\Carbon::parse($registration->event->date)->format('M d, Y') . " " . \Carbon\Carbon::parse($registration->event->time)->format('h:i A') . "\n" .
                              "Location: " . $registration->event->location . "\n" .
                              "Attendee: " . $registration->attendee->full_name . "\n" .
                              "Ticket ID: #" . $registration->ticket_id;
                @endphp
                <div style="text-align: center; background: white; padding: 0.75rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #f0f0f0;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrData) }}" 
                         alt="QR Code" 
                         style="width: 140px; height: 140px; display: block;">
                    <p style="font-size: 0.65rem; color: var(--text-muted); margin-top: 0.5rem; font-weight: bold;">SCAN TO VERIFY</p>
                </div>
            </div>

            <div style="margin-top: 3rem; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div style="padding: 1rem; background: #fdfdfd; border-radius: 8px; border: 1px solid #f7f7f7;">
                    <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Attendee Name</p>
                    <p style="font-weight: 700; font-size: 1.1rem; color: #2d3748;">{{ $registration->attendee->full_name }}</p>
                </div>
                <div style="padding: 1rem; background: #fdfdfd; border-radius: 8px; border: 1px solid #f7f7f7;">
                    <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Location</p>
                    <p style="font-weight: 700; font-size: 1.1rem; color: #2d3748;">{{ $registration->event->location }}</p>
                </div>
            </div>

            <!-- Perforation circles for design -->
            <div style="position: absolute; left: -16px; bottom: -16px; width: 32px; height: 32px; background: #fafafa; border-radius: 50%; z-index: 2;"></div>
            <div style="position: absolute; right: -16px; bottom: -16px; width: 32px; height: 32px; background: #fafafa; border-radius: 50%; z-index: 2;"></div>
        </div>

        <!-- Ticket Bottom Section -->
        <div style="padding: 2.5rem 3rem; background: #fafafa; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Registration ID</p>
                <p style="font-family: monospace; font-size: 1.25rem; font-weight: bold; color: var(--corporate-red); letter-spacing: 2px;">#{{ $registration->ticket_id }}</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button id="downloadBtn" onclick="downloadTicket()" class="btn" style="padding: 10px 20px; border-radius: 8px; font-weight: bold; background: white; border: 1px solid #ddd; color: #444; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <i class="fa-solid fa-download"></i> Download
                </button>
                <button onclick="window.print()" class="btn" style="padding: 10px 20px; border-radius: 8px; font-weight: bold; background: var(--corporate-red); color: white; border: none; display: flex; align-items: center; gap: 8px; cursor: pointer; box-shadow: 0 4px 10px rgba(148, 0, 0, 0.2);">
                    <i class="fa-solid fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Branding Footer -->
    <div style="margin-top: 2rem; text-align: center; color: var(--text-muted); font-size: 0.9rem;">
        <p>Managed by <strong>EmCa TECHONOLOGY</strong></p>
    </div>

    <div style="margin-top: 3rem; width: 100%; max-width: 650px; display: flex; justify-content: center;">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Home
        </a>
    </div>
</div>

<!-- Libraries for PDF/Image Download -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function downloadTicket() {
    const btn = document.getElementById('downloadBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner"></span> Downloading...';
    btn.disabled = true;

    const ticket = document.querySelector('.card');
    
    // Use html2canvas to capture the ticket
    html2canvas(ticket, {
        scale: 2, // Higher quality
        useCORS: true, // Allow external images (like the QR code)
        backgroundColor: null
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const { jsPDF } = window.jspdf;
        
        // Calculate dimensions to fit PDF
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        pdf.addImage(imgData, 'PNG', 0, 10, pdfWidth, pdfHeight);
        pdf.save('Ticket-{{ $registration->ticket_id }}.pdf');
        
        btn.innerHTML = originalText;
        btn.disabled = false;
    }).catch(err => {
        console.error('Download failed:', err);
        alert('Failed to download ticket. Please try printing instead.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>

<style>
.spinner {
    width: 14px;
    height: 14px;
    border: 2px solid #ccc;
    border-top-color: #444;
    border-radius: 50%;
    display: inline-block;
    animation: spin 1s linear infinite;
    margin-right: 5px;
}
@keyframes spin { to { transform: rotate(360deg); } }

@media print {
    body * { visibility: hidden; }
    .card, .card * { visibility: visible; }
    .card { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; border: 1px solid #eee; }
    .btn, .btn-back, #downloadBtn { display: none !important; }
}
</style>
@endsection
