@extends('layouts.app')

@section('title', 'Your Ticket - ' . $registration->event->title)

@section('content')
<div class="container" style="padding: 2rem 15px; display: flex; flex-direction: column; align-items: center;">
    <div class="card" style="width: 100%; max-width: 650px; padding: 0; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); background: white; border-radius: 16px;">
        <!-- Ticket Header -->
        <div style="background: var(--corporate-red); color: white; padding: 2rem 1.5rem; text-align: center; position: relative;">
            <div style="position: absolute; top: 0.75rem; left: 1rem; opacity: 0.3; font-family: 'Century Gothic', sans-serif; font-size: 0.7rem; letter-spacing: 2px;">OFFICIAL TICKET</div>
            <h2 style="color: white; margin-top: 1rem; margin-bottom: 0.25rem; font-size: 1.5rem; letter-spacing: -0.5px;">Registration Confirmed!</h2>
            <p style="opacity: 0.9; font-size: 0.95rem;">Present this at the event entrance.</p>
        </div>

        <!-- Ticket Body -->
        <div style="padding: 1.5rem; position: relative; border-bottom: 2px dashed #eee;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1.5rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <span style="display: inline-block; padding: 0.2rem 0.6rem; background: var(--accent-soft-red); color: var(--corporate-red); border-radius: 20px; font-size: 0.7rem; font-weight: bold; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">Event Details</span>
                    <h3 style="margin-bottom: 0.75rem; font-size: 1.5rem; line-height: 1.2; color: #1a202c;">{{ $registration->event->title }}</h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568; margin-bottom: 0.5rem; font-size: 0.9rem;">
                        <i class="fa-solid fa-calendar-day" style="color: var(--corporate-red); width: 16px;"></i>
                        <span>{{ \Carbon\Carbon::parse($registration->event->date)->format('l, F d, Y') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568; font-size: 0.9rem;">
                        <i class="fa-solid fa-clock" style="color: var(--corporate-red); width: 16px;"></i>
                        <span>{{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}</span>
                    </div>
                </div>
                
                <div style="text-align: center; background: white; padding: 0.75rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #f0f0f0; margin: 0 auto;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrData) }}" 
                         alt="QR Code" 
                         style="width: 120px; height: 120px; display: block;">
                    <p style="font-size: 0.6rem; color: var(--text-muted); margin-top: 0.5rem; font-weight: bold;">SCAN TO VERIFY</p>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 15px;">
                <div style="flex: 1; min-width: 140px; padding: 1rem; background: #fdfdfd; border-radius: 8px; border: 1px solid #f7f7f7;">
                    <p style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem;">Attendee Name</p>
                    <p style="font-weight: 700; font-size: 1rem; color: #2d3748;">{{ $registration->attendee->full_name }}</p>
                </div>
                <div style="flex: 1; min-width: 140px; padding: 1rem; background: #fdfdfd; border-radius: 8px; border: 1px solid #f7f7f7;">
                    <p style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.4rem;">Location</p>
                    <p style="font-weight: 700; font-size: 1rem; color: #2d3748;">{{ $registration->event->location }}</p>
                </div>
            </div>

            <!-- Perforation circles for design -->
            <div style="position: absolute; left: -16px; bottom: -16px; width: 32px; height: 32px; background: #fafafa; border-radius: 50%; z-index: 2;"></div>
            <div style="position: absolute; right: -16px; bottom: -16px; width: 32px; height: 32px; background: #fafafa; border-radius: 50%; z-index: 2;"></div>
        </div>

        <div style="padding: 1.5rem; background: #fafafa; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="flex: 1; min-width: 150px;">
                <p style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Ticket ID</p>
                <p style="font-family: monospace; font-size: 1.1rem; font-weight: bold; color: var(--corporate-red); letter-spacing: 1px;">{{ $registration->ticket_id }}</p>
            </div>
            <div style="display: flex; gap: 10px; flex: 1; min-width: 250px; justify-content: flex-end;">
                <button id="downloadBtn" onclick="downloadTicket()" class="btn" style="flex: 1; padding: 10px 15px; border-radius: 8px; font-weight: bold; background: white; border: 1px solid #ddd; color: #444; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; font-size: 0.85rem;">
                    <i class="fa-solid fa-download"></i> Download
                </button>
                <button onclick="window.print()" class="btn" style="flex: 1; padding: 10px 15px; border-radius: 8px; font-weight: bold; background: var(--corporate-red); color: white; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; box-shadow: 0 4px 10px rgba(148, 0, 0, 0.2); font-size: 0.85rem;">
                    <i class="fa-solid fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Branding Footer -->
    <div style="margin-top: 2rem; text-align: center; color: var(--text-muted); font-size: 0.9rem;">
        <p>Managed by <strong>EmCa TECHONOLOGIES</strong></p>
    </div>

<<<<<<< HEAD
    <div style="margin-top: 3rem; width: 100%; max-width: 650px; display: flex; justify-content: center;">
        @php
            $backUrl = route('home');
            $backText = 'Back to Home';
            if(auth()->check()) {
                if(auth()->user()->role === 'admin') {
                    $backUrl = route('admin.dashboard');
                    $backText = 'Back to Dashboard';
                } elseif(auth()->user()->role === 'organizer') {
                    $backUrl = route('dashboard');
                    $backText = 'Back to Dashboard';
                }
            }
        @endphp
        <a href="{{ $backUrl }}" class="btn-back" style="display: inline-flex; align-items: center; gap: 8px; color: #666; text-decoration: none; font-weight: 600; font-size: 1rem; transition: 0.3s; padding: 10px 20px; border: 1px solid #ddd; border-radius: 30px; background: white;"
           onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.color='var(--corporate-red)';" onmouseout="this.style.borderColor='#ddd'; this.style.color='#666';">
            <i class="fa-solid fa-arrow-left"></i> {{ $backText }}
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
