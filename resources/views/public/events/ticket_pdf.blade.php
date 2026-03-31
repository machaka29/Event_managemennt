<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket - {{ $registration->ticket_id }}</title>
    <style>
        /* General page setup */
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            color: #1a1a1a;
            font-size: 14px;
            line-height: 1.4;
        }
        
        /* Container and Card */
        .page-container {
            padding: 2cm;
            background-color: #f5f5f5;
            min-height: 29.7cm; /* A4 height approx */
        }
        .ticket-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            border: 1px solid #e1e1e1;
            border-top: 10px solid #940000;
            padding: 40px;
        }

        /* Header */
        .header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .logo-area {
            float: left;
            width: 50%;
        }
        .logo {
            height: 35px;
            margin-bottom: 5px;
        }
        .system-tag {
            font-size: 10px;
            color: #999;
            font-weight: bold;
            display: block;
        }
        .ticket-title {
            float: right;
            width: 50%;
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            color: #000;
            margin-top: 5px;
        }

        /* Grid for details and QR */
        .details-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-col {
            width: 65%;
            vertical-align: top;
        }
        .qr-col {
            width: 35%;
            vertical-align: top;
            text-align: center;
        }

        /* Detail rows inside the left column */
        .section-label {
            font-size: 10px;
            color: #940000;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }
        .info-row {
            margin-bottom: 15px;
        }
        .label {
            font-size: 12px;
            color: #666;
            font-weight: normal;
            width: 80px;
            display: inline-block;
        }
        .value {
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }
        .event-main-title {
            font-size: 20px;
            color: #000;
            margin-bottom: 15px;
            display: block;
        }

        /* QR Code Box */
        .qr-box {
            border: 1px solid #f0f0f0;
            padding: 10px;
            display: inline-block;
            background: #fff;
            margin-bottom: 5px;
        }
        .qr-img {
            width: 150px;
            height: 150px;
        }
        .qr-helper {
            font-size: 10px;
            color: #999;
            font-weight: bold;
        }

        /* Attendee Info Block */
        .info-block {
            border: 1px solid #eee;
            margin-bottom: 25px;
        }
        .block-header {
            background-color: #f9f9f9;
            padding: 10px 15px;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            text-transform: uppercase;
        }
        .block-body {
            padding: 15px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-td {
            width: 50%;
            padding: 5px 0;
            vertical-align: top;
        }
        .info-label-inline {
            font-size: 11px;
            color: #888;
            margin-right: 5px;
        }
        .info-value-inline {
            font-size: 13px;
            font-weight: bold;
        }

        /* Important block (Yellow background) */
        .warning-box {
            background-color: #fffcef;
            border: 1px solid #ffeb8c;
            padding: 15px;
            margin-bottom: 30px;
        }
        .warning-text {
            font-size: 12px;
            color: #856404;
        }

        /* Footer */
        .footer {
            border-top: 2px dashed #eee;
            padding-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #aaa;
        }

        /* Ticket ID display */
        .ticket-id-display {
            font-family: 'Courier', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #940000;
            margin-top: 10px;
            letter-spacing: 2px;
        }
        
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="ticket-card">
            
            <div class="header">
                <div class="logo-area">
                    @if($logoBase64)
                        <img src="data:image/png;base64,{{ $logoBase64 }}" class="logo">
                    @endif
                    <span class="system-tag">EVENTS REGISTRATION</span>
                </div>
                <div class="ticket-title">CONFIRMATION TICKET</div>
                <div class="clear"></div>
            </div>

            <table class="details-grid">
                <tr>
                    <td class="details-col">
                        <span class="section-label">EVENT DETAILS</span>
                        <div class="info-row">
                            <span class="event-main-title">{{ $registration->event->title }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="label">Date:</span>
                            <span class="value">{{ \Carbon\Carbon::parse($registration->event->date)->format('F d, Y') }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="label">Time:</span>
                            <span class="value">{{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}</span>
                        </div>
                        
                        <div class="info-row" style="margin-bottom: 25px;">
                            <span class="label">Location:</span>
                            <span class="value">
                                {{ $registration->event->location }}<br>
                                @if($registration->event->venue)
                                <span style="font-size: 11px; color: #777; font-weight: normal;">{{ $registration->event->venue }}</span>
                                @endif
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="label">Ticket ID:</span>
                            <div class="ticket-id-display">{{ $registration->ticket_id }}</div>
                        </div>
                    </td>
                    <td class="qr-col">
                        <div class="qr-box">
                            <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" class="qr-img">
                        </div>
                        <div class="qr-helper">SCAN TO VERIFY ATTENDANCE</div>
                    </td>
                </tr>
            </table>

            <div class="info-block">
                <div class="block-header">ATTENDEE INFORMATION</div>
                <div class="block-body">
                    <table class="info-table">
                        <tr>
                            <td class="info-td">
                                <span class="info-label-inline">Name:</span>
                                <span class="info-value-inline">{{ $registration->attendee->full_name }}</span>
                            </td>
                            <td class="info-td">
                                <span class="info-label-inline">Phone:</span>
                                <span class="info-value-inline">{{ $registration->attendee->phone }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="info-td">
                                <span class="info-label-inline">Organization:</span>
                                <span class="info-text-inline">{{ $registration->attendee->organization ?? 'N/A' }}</span>
                            </td>
                            <td class="info-td">
                                <span class="info-label-inline">Email:</span>
                                <span class="info-value-inline">{{ $registration->attendee->email }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="info-block" style="background-color: #fafbfc;">
                <div class="block-body" style="padding: 10px 15px;">
                    <table class="info-table">
                        <tr>
                            <td style="width: 33%">
                                <span class="info-label-inline">Ticket Type:</span><br>
                                <span class="info-value-inline">Standard Access</span>
                            </td>
                            <td style="width: 33%; border-left: 1px solid #eee; padding-left: 15px;">
                                <span class="info-label-inline">Registration Date:</span><br>
                                <span class="info-value-inline">{{ $registration->created_at->format('M d, Y') }}</span>
                            </td>
                            <td style="width: 33%; border-left: 1px solid #eee; padding-left: 15px;">
                                <span class="info-label-inline">Registration No:</span><br>
                                <span class="info-value-inline" style="font-family: Courier;">{{ str_pad($registration->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="warning-box">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 30px; vertical-align: top; color: #d97706; font-size: 20px;">!</td>
                        <td class="warning-text">
                            <strong>IMPORTANT:</strong> Please bring this ticket (digital or printed) for entry. The QR code will be scanned at the door for verification. Treat this ticket like cash.
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} EmCa Techonologies. This ticket is generated automatically upon valid registration.
            </div>

        </div>
    </div>
</body>
</html>
