@extends('layouts.organizer')

@section('title', 'All Registrations - Organizer Panel')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">All Registrations</h1>
    <p style="color: #666; font-size: 1rem;">View and manage attendee registrations across all your events.</p>
</div>

<div class="card" style="padding: 0; overflow: hidden; border: 1px solid #e0e0e0; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--corporate-red); color: white; text-align: left;">
                <th style="padding: 18px 20px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Ticket ID</th>
                <th style="padding: 18px 20px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Attendee Details</th>
                <th style="padding: 18px 20px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Event Name</th>
                <th style="padding: 18px 20px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Reg. Date</th>
                <th style="padding: 18px 20px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; text-align: center;">Status</th>
                <th style="padding: 18px 20px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
                <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s;" onmouseover="this.style.background='#fff9f9'" onmouseout="this.style.background='white'">
                    <td style="padding: 20px;">
                        <span style="background: var(--accent-soft-red); color: var(--corporate-red); padding: 5px 12px; border-radius: 4px; font-family: 'Courier New', monospace; font-weight: bold; border: 1px solid rgba(148,0,0,0.2);">
                            {{ $reg->ticket_id }}
                        </span>
                    </td>
                    <td style="padding: 20px;">
                        <div style="font-weight: bold; color: #333; font-size: 1rem;">{{ $reg->attendee->full_name }}</div>
                        <div style="color: #888; font-size: 0.8rem; margin-top: 2px;">
                            <i class="fa-regular fa-envelope" style="margin-right: 5px;"></i> {{ $reg->attendee->email }}
                        </div>
                    </td>
                    <td style="padding: 20px; color: #555;">{{ Str::limit($reg->event->title, 30) }}</td>
                    <td style="padding: 20px; color: #777; font-size: 0.9rem;">
                        <i class="fa-regular fa-calendar-alt" style="margin-right: 5px;"></i> {{ $reg->created_at->format('M d, Y') }}
                    </td>
                    <td style="padding: 20px; text-align: center;">
                        @if($reg->attended)
                            <span style="background: #10b981; color: white; padding: 6px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: bold; box-shadow: 0 2px 5px rgba(16,185,129,0.2);">
                                <i class="fa-solid fa-check-double"></i> ATTENDED
                            </span>
                        @else
                            <span style="background: #f59e0b; color: white; padding: 6px 14px; border-radius: 50px; font-size: 0.75rem; font-weight: bold; box-shadow: 0 2px 5px rgba(245,158,11,0.2);">
                                <i class="fa-solid fa-hourglass-half"></i> REGISTERED
                            </span>
                        @endif
                    </td>
                    <td style="padding: 20px; text-align: right;">
                        <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" class="btn-secondary" style="padding: 8px 15px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-ticket"></i> VIEW TICKET
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 50px; text-align: center; color: #999;">
                        <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                        No registrations found for your events yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $registrations->links() }}
    </div>
</div>
@endsection
