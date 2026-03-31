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
<div class="table-responsive" style="overflow-x: auto;">
    <table id="mainTable" style="width: 100%; border-collapse: collapse; min-width: 900px;">
        <thead>
            <tr style="background: var(--corporate-red); color: white;">
                <th style="padding: 12px 20px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">Attendee</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;" class="hide-mobile">Email / Phone</th>
                <th style="padding: 12px 15px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;" class="col-event">Event</th>
                <th style="padding: 12px 15px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">Status</th>
                <th style="padding: 12px 15px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">Check-In</th>
                <th style="padding: 12px 15px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">Check-Out</th>
                <th style="padding: 12px 15px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px;">Ticket</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                    <td style="padding: 12px 20px;">
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.85rem;">{{ $reg->attendee->full_name }}</div>
                        <div style="font-size: 0.65rem; color: #94a3b8; font-family: monospace;">{{ $reg->ticket_id }}</div>
                    </td>
                    <td style="padding: 12px 15px;" class="hide-mobile">
                        <div style="color: #64748b; font-size: 0.8rem;">{{ $reg->attendee->email }}</div>
                        <div style="color: #94a3b8; font-size: 0.7rem; margin-top: 2px;">{{ $reg->attendee->phone }}</div>
                    </td>
                    <td style="padding: 12px 15px;" class="col-event">
                        <div style="color: #475569; font-weight: 600; font-size: 0.8rem;">{{ Str::limit($reg->event->title, 25) }}</div>
                    </td>
                    <td style="padding: 12px 15px; text-align: center;">
                        @if($reg->status === 'Checked-Out')
                            <span style="color: #475569; font-weight: 800; background: #e2e8f0; padding: 4px 10px; border-radius: 20px; font-size: 0.65rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-door-closed"></i> Out
                            </span>
                        @elseif($reg->attended)
                            <span style="color: #059669; font-weight: 800; background: #ECFDF5; padding: 4px 10px; border-radius: 20px; font-size: 0.65rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-check-double"></i> In
                            </span>
                        @else
                            <span style="color: #64748b; font-weight: 800; background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 0.65rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-clock"></i> Pending
                            </span>
                        @endif
                    </td>
                    <td style="padding: 12px 15px; text-align: center;">
                        @if($reg->checked_in_at)
                            <div style="font-size: 0.8rem; font-weight: 700; color: #059669;">{{ $reg->checked_in_at->format('h:i A') }}</div>
                            <div style="font-size: 0.6rem; color: #94a3b8; margin-top: 2px;">{{ $reg->checked_in_at->format('M d') }}</div>
                        @else
                            <span style="color: #cbd5e1; font-size: 0.75rem;">—</span>
                        @endif
                    </td>
                    <td style="padding: 12px 15px; text-align: center;">
                        @if($reg->checked_out_at)
                            <div style="font-size: 0.8rem; font-weight: 700; color: #475569;">{{ $reg->checked_out_at->format('h:i A') }}</div>
                            <div style="font-size: 0.6rem; color: #94a3b8; margin-top: 2px;">{{ $reg->checked_out_at->format('M d') }}</div>
                        @else
                            <span style="color: #cbd5e1; font-size: 0.75rem;">—</span>
                        @endif
                    </td>
                    <td style="padding: 12px 15px; text-align: right;">
                        <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; text-decoration: none; border: 1px solid rgba(148,0,0,0.15); transition: all 0.3s; margin-left: auto;" title="View Ticket" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='#FFF5F5'; this.style.color='var(--corporate-red)';">
                            <i class="fa-solid fa-ticket" style="font-size: 0.8rem;"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 50px; text-align: center; color: #94A3B8;">
                        <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 12px; opacity: 0.4; display: block;"></i>
                        No registrations found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
    <div style="padding: 20px;">
        {{ $registrations->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('tableSearch').addEventListener('input', function() {
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
