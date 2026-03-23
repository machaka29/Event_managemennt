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
            <tr style="background: var(--accent-soft-red); text-align: left; border-bottom: 2px solid var(--corporate-red);">
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
                            <span style="color: #28a745; font-weight: bold; background: #e6ffed; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-check-double"></i> Attended
                            </span>
                        @else
                            <span style="color: #666; font-weight: 500; background: #f3f4f6; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-user-check"></i> Registered
                            </span>
                        @endif
                    </td>
                    <td style="padding: 15px 20px; text-align: right;">
                        <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" 
                           style="color: var(--corporate-red); border: 1.5px solid var(--corporate-red); padding: 6px 15px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: bold; transition: 0.3s; display: inline-block;"
                           onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';"
                           onmouseout="this.style.background='transparent'; this.style.color='var(--corporate-red)';">
                            <i class="fa-solid fa-ticket"></i> View Ticket
                        </a>
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
