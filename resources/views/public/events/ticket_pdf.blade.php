<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - {{ $registration->attendee->access_code }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 0; }
        .ticket-container { width: 100%; max-width: 650px; margin: 10px auto; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; }
        .header { background: #940000; color: #fff; padding: 25px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; letter-spacing: 2px; }
        .header p { margin: 5px 0 0; opacity: 0.9; font-size: 14px; }
        .body { padding: 40px; position: relative; border-bottom: 2px dashed #eee; margin-bottom: 0; }
        .event-section { margin-bottom: 35px; width: 65%; }
        .label { font-size: 11px; color: #888; text-transform: uppercase; margin-bottom: 5px; font-weight: bold; }
        .value { font-size: 16px; font-weight: bold; color: #111; margin-bottom: 15px; }
        .event-title { font-size: 22px; font-weight: bold; color: #000; margin-bottom: 15px; border-left: 4px solid #940000; padding-left: 15px; }
        
        .qr-section { position: absolute; top: 40px; right: 40px; text-align: center; width: 140px; }
        .qr-code { width: 130px; height: 130px; border: 1px solid #eee; padding: 5px; background: #fff; }
        .scan-msg { font-size: 10px; margin-top: 8px; color: #999; text-transform: uppercase; letter-spacing: 1px; }
        
        .attendee-info { display: table; width: 100%; margin-top: 20px; }
        .info-col { display: table-cell; width: 50%; vertical-align: top; }
        
        .ticket-id-section { margin-top: 50px; text-align: center; padding-top: 30px; }
        .ticket-id { font-size: 32px; letter-spacing: 6px; color: #940000; font-weight: bold; font-family: 'Courier New', Courier, monospace; }
        
        .footer { background: #fff9f9; padding: 20px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; }
        .watermark { position: absolute; bottom: 10px; right: 10px; font-size: 10px; color: #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h1>EVENT TICKET</h1>
            <p>Official Confirmation of Registration</p>
        </div>
        
        <div class="body">
            <div class="event-section">
                <div class="label">Event Name</div>
                <div class="event-title">{{ $registration->event->title }}</div>
                
                <div class="attendee-info">
                    <div class="info-col">
                        <div class="label">Date & Time</div>
                        <div class="value">
                            {{ \Carbon\Carbon::parse($registration->event->date)->format('D, M d, Y') }}<br>
                            {{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}
                        </div>
                    </div>
                    <div class="info-col">
                        <div class="label">Location</div>
                        <div class="value">{{ $registration->event->location }}</div>
                    </div>
                </div>
            </div>

            <div class="qr-section">
                <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" class="qr-code">
                <div class="scan-msg">Verify Authenticity</div>
            </div>

            <div class="attendee-info" style="margin-top: 40px; background: #fcfcfc; padding: 20px; border-radius: 5px;">
                <div class="info-col">
                    <div class="label">Attendee Name</div>
                    <div class="value" style="font-size: 18px;">{{ $registration->attendee->full_name }}</div>
                </div>
                <div class="info-col">
                    <div class="label">Member ID / Access ID</div>
                    <div class="value" style="font-family: monospace;">{{ $registration->attendee->access_code }}</div>
                </div>
            </div>

            <div class="ticket-id-section">
                <div class="label">Serial Number / Ticket ID</div>
                <div class="ticket-id">{{ $registration->attendee->access_code }}</div>
            </div>
            
            <div class="watermark">EMCA TICKETING SYSTEM</div>
        </div>

        <div class="footer">
            <p style="margin-bottom: 5px; font-weight: bold;">Important Information</p>
            <p style="margin: 0;">Please bring this ticket (digital or printed) to the venue. Present the QR code for check-in via the authorized mobile scanner. This ticket is unique to the attendee listed above.</p>
            <p style="margin-top: 15px; font-size: 10px; opacity: 0.6;">&copy; {{ date('Y') }} EmCa Technologies. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
