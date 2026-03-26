<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Century Gothic', sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; border-bottom: 2px solid #940000; padding-bottom: 10px; }
        .content { padding: 20px 0; }
        .footer { font-size: 0.8rem; color: #777; text-align: center; border-top: 1px solid #eee; padding-top: 10px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #940000; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #940000; margin: 0;">Registration Confirmed!</h2>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $registration->attendee->full_name }}</strong>,</p>
            <p>Thank you for registering for <strong>{{ $registration->event->title }}</strong>.</p>
            <p>Your registration was successful. Please find your ticket details below:</p>
            
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td><strong>Event:</strong></td>
                    <td>{{ $registration->event->title }}</td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($registration->event->start_date)->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Location:</strong></td>
                    <td>{{ $registration->event->location }}</td>
                </tr>
                <tr>
                    <td><strong>Ticket ID:</strong></td>
                    <td><code style="background: #f4f4f4; padding: 2px 5px; border-radius: 3px;">{{ $registration->ticket_id }}</code></td>
                </tr>
            </table>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('events.public.ticket', $registration->ticket_id) }}" class="btn" style="color: white;">View My Ticket</a>
            </div>

            <p>We look forward to seeing you at the event!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
