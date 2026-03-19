@extends('layouts.admin')

@section('title', 'Global Attendees - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Attendees</h1>
        <p style="color: #666; font-size: 1rem;">View all registrations and attendees across all global events.</p>
    </div>
</div>

<div class="card" style="max-width: 100%; border: 1px solid var(--corporate-red); border-radius: 8px; overflow: hidden; padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--header-gradient); text-align: left; border-bottom: 2px solid var(--corporate-red);">
                <th style="padding: 15px 20px; color: var(--corporate-red);">Attendee Name</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Email</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Event</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Registration Date</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Status</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: right;">Ticket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendees as $reg)
                <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $reg->attendee->full_name }}</td>
                    <td style="padding: 15px 20px;">{{ $reg->attendee->email }}</td>
                    <td style="padding: 15px 20px;">{{ $reg->event->title }}</td>
                    <td style="padding: 15px 20px;">{{ $reg->created_at->format('M d, Y') }}</td>
                    <td style="padding: 15px 20px;">
                        @if($reg->attended)
                            <span style="color: #10b981;">● Attended</span>
                        @else
                            <span style="color: #f59e0b;">● Registered</span>
                        @endif
                    </td>
                    <td style="padding: 15px 20px; text-align: right;">
                        <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" style="color: var(--corporate-red);"><i class="fa-solid fa-ticket"></i> View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $attendees->links() }}
    </div>
</div>
@endsection
