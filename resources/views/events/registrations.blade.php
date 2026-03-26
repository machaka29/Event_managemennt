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
<div style="padding: 15px 20px; border-bottom: 1px solid #eee; background: #fafafa; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <h3 style="margin: 0; font-size: 0.9rem; color: #444; font-weight: 700;">Registration Records</h3>
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="position: relative;">
            <i class="fa-solid fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999; font-size: 0.75rem;"></i>
            <input type="text" id="tableSearch" placeholder="Filter registrations..." 
                style="padding: 6px 12px 6px 30px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.8rem; outline: none; width: 200px; transition: 0.3s;"
                onfocus="this.style.borderColor='var(--corporate-red)';"
                onblur="this.style.borderColor='#ddd';">
        </div>
        <div style="font-size: 0.75rem; color: #888; font-weight: 700;">Total: {{ $registrations->total() }}</div>
    </div>
</div>
<div class="table-responsive">
    <table id="mainTable" class="table-compact" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--corporate-red); color: white; text-align: left;">
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;" class="col-id">ID</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;">Attendee</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;" class="col-event">Event</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;" class="col-date">Date</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;">Check-in</th>
                <th style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800;">Check-out</th>
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
                    <td style="color: #166534; font-weight: 700; font-size: 0.85rem;">
                        {{ $reg->check_in_at ? $reg->check_in_at->format('h:i A') : '---' }}
                    </td>
                    <td style="color: #475569; font-weight: 700; font-size: 0.85rem;">
                        {{ $reg->check_out_at ? $reg->check_out_at->format('h:i A') : '---' }}
                    </td>
                    <td style="text-align: center;" class="col-status">
                        @if($reg->check_out_at)
                            <span style="background: #1e293b; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">
                                <i class="fa-solid fa-flag-checkered"></i> <span class="hide-mobile">LEFT</span>
                            </span>
                        @elseif($reg->check_in_at)
                            <span style="background: #166534; color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">
                                <i class="fa-solid fa-person-walking-arrow-right"></i> <span class="hide-mobile">IN</span>
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

@push('scripts')
<script>
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        let searchTerm = this.value.toLowerCase();
        let table = document.getElementById('mainTable');
        let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });
</script>
@endpush
