@extends('layouts.organizer')

@section('title', 'All Registrations - Organizer Panel')

@section('content')
<div style="margin-bottom: 2rem;" class="page-header">
    <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;" class="page-title">All Registrations</h1>
    <p style="color: #666; font-size: 1rem;" class="page-subtitle">View and manage attendee registrations across all your events.</p>
</div>

<style>
    @media (max-width: 768px) {
        .page-header { margin-bottom: 1.5rem !important; }
        .page-title { font-size: 1.4rem !important; }
        .page-subtitle { font-size: 0.9rem !important; }
        .table-responsive { border: none !important; }
        
        .col-id { width: 50px !important; font-size: 0.7rem !important; }
        .col-event { display: none !important; }
        .col-date { font-size: 0.7rem !important; }
        .col-status { width: 60px !important; }
        .col-action { width: 60px !important; }
        .hide-mobile { display: none !important; }
    }
</style>

<div class="card" style="padding: 0; overflow: hidden; border: 1px solid #e0e0e0; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
<div class="table-responsive">
    <table class="table-compact" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--corporate-red); color: white; text-align: left;">
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;" class="col-id">ID</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;">Attendee</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;" class="col-event">Event</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;" class="col-date">Date</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800; text-align: center;" class="col-status">Status</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800; text-align: right;" class="col-action">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
                <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                    <td class="col-id">
                        <span style="background: var(--accent-soft-red); color: var(--corporate-red); padding: 4px 8px; border-radius: 4px; font-family: 'Courier New', monospace; font-weight: 800; font-size: 0.75rem; border: 1px solid rgba(148,0,0,0.1);">
                            {{ $reg->ticket_id }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 800; color: #1E293B; font-size: 0.95rem;">{{ $reg->attendee->full_name }}</div>
                        <div style="color: #64748B; font-size: 0.75rem; margin-top: 2px;">
                            <i class="fa-regular fa-envelope"></i> {{ $reg->attendee->email }}
                        </div>
                    </td>
                    <td class="col-event" style="color: #475569; font-weight: 600;">{{ Str::limit($reg->event->title, 25) }}</td>
                    <td class="col-date" style="color: #64748B; font-size: 0.85rem;">
                        <i class="fa-regular fa-calendar-alt"></i> {{ $reg->created_at->format('M d, Y') }}
                    </td>
                    <td style="text-align: center;" class="col-status">
                        @if($reg->attended)
                            <span style="background: var(--corporate-red); color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">
                                <i class="fa-solid fa-check"></i> <span class="hide-mobile">DONE</span>
                            </span>
                        @else
                            <span style="background: #F1F5F9; color: #64748B; padding: 5px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; border: 1px solid #E2E8F0;">
                                <i class="fa-solid fa-clock"></i> <span class="hide-mobile">REG</span>
                            </span>
                        @endif
                    </td>
                    <td style="text-align: right;" class="col-action">
                        <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" class="btn-outline" style="min-height: 30px; padding: 0 10px; font-size: 0.7rem; font-weight: 800; border-radius: 6px; text-transform: uppercase;">
                            <i class="fa-solid fa-ticket"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding: 50px; text-align: center; color: #94A3B8;">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 12px; opacity: 0.4; display: block;"></i>
                        No registrations found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    <div style="padding: 20px;">
        {{ $registrations->links() }}
    </div>
</div>
@endsection
