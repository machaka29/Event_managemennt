<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Registration Notification</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f7f6; }
        .container { width: 90%; max-width: 600px; margin: 20px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-top: 5px solid #940000; }
        .header { background-color: #940000; color: #fff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px; }
        .info-box { background-color: #f9f9f9; border: 1px solid #eee; padding: 20px; border-radius: 6px; margin: 20px 0; }
        .info-row { display: flex; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; }
        .info-label { font-weight: bold; width: 140px; color: #666; }
        .info-value { flex: 1; color: #333; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #999; border-top: 1px solid #eee; }
        .btn { display: inline-block; padding: 12px 25px; background-color: #940000; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Registration</h1>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>A new participant has just registered for an event on the <strong>{{ config('app.name') }}</strong> platform.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #940000;">Event Details</h3>
                <div class="info-row">
                    <div class="info-label">Event Name:</div>
                    <div class="info-value">{{ $event->title }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Event Date:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Location:</div>
                    <div class="info-value">{{ $event->location }} ({{ $event->venue }})</div>
                </div>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #940000;">Attendee Information</h3>
                <div class="info-row">
                    <div class="info-label">Full Name:</div>
                    <div class="info-value">{{ $attendee->full_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $attendee->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $attendee->phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Organization:</div>
                    <div class="info-value">{{ $attendee->organization ?? 'N/A' }}</div>
                </div>
                <div class="info-row" style="border-bottom: none;">
                    <div class="info-label">Ticket ID:</div>
                    <div class="info-value" style="font-weight: bold; color: #940000;">{{ $registration->ticket_id }}</div>
                </div>
            </div>

            <p>The attendee is now visible on both the Admin and Organizer dashboards.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('admin.dashboard') }}" class="btn">GO TO DASHBOARD</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
