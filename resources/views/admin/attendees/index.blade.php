@extends('layouts.admin')

@section('title', 'Global Registrations - Admin Panel')

@section('content')
<div style="background: white; padding: 20px 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="font-size: 1.3rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase;">Registrations</h1>
            <div style="width: 40px; height: 3px; background: var(--corporate-red); margin-top: 8px; border-radius: 2px;"></div>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 8px; font-weight: 600;">View all registrations and attendance across all events.</p>
        </div>
    </div>
</div>

<div style="background: white; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 15px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa; flex-wrap: wrap; gap: 10px;">
        <h2 style="margin: 0; font-size: 0.85rem; color: #475569; font-weight: 700;">All Event Registrations</h2>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
                <input type="text" id="tableSearch" placeholder="Search registrations..." style="padding: 8px 15px 8px 35px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.8rem; outline: none; width: 250px; transition: all 0.2s;" onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Total: {{ $attendees->total() }}</div>
        </div>
    </div>
    <div class="table-responsive" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: var(--corporate-red); color: white;">
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Attendee</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Email</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Event</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Reg. Date</th>
                    <th style="padding: 12px 25px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Status & Time</th>
                    <th style="padding: 12px 25px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Ticket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $reg)
                    <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px 25px; font-weight: 700; color: #1e293b; font-size: 0.9rem;">{{ $reg->attendee->full_name }}</td>
                        <td style="padding: 14px 25px; color: #64748b; font-size: 0.85rem;">{{ $reg->attendee->email }}</td>
                        <td style="padding: 14px 25px; color: #475569; font-weight: 600; font-size: 0.85rem;">{{ Str::limit($reg->event->title, 30) }}</td>
                        <td style="padding: 14px 25px; color: #64748b; font-size: 0.85rem;">{{ $reg->created_at->format('M d, Y') }}</td>
                        <td style="padding: 14px 25px; text-align: center;">
                            @if($reg->status === 'Checked-Out')
                                <span style="color: #475569; font-weight: 800; background: #e2e8f0; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-door-closed"></i> Checked Out
                                </span>
                                @if($reg->checked_out_at)
                                <div style="font-size: 0.65rem; color: #64748b; margin-top: 4px; font-weight: 700;">{{ $reg->checked_out_at->format('h:i A') }}</div>
                                @endif
                            @elseif($reg->attended)
                                <span style="color: #059669; font-weight: 800; background: #ECFDF5; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-check-double"></i> Checked In
                                </span>
                                @if($reg->checked_in_at)
                                <div style="font-size: 0.65rem; color: #059669; margin-top: 4px; font-weight: 700;">{{ $reg->checked_in_at->format('h:i A') }}</div>
                                @endif
                            @else
                                <span style="color: #64748b; font-weight: 800; background: #f1f5f9; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-clock"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td style="padding: 14px 25px; text-align: right;">
                            <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; text-decoration: none; border: 1px solid rgba(148,0,0,0.15); transition: all 0.3s; margin-left: auto;" title="View Ticket" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='#FFF5F5'; this.style.color='var(--corporate-red)';">
                                <i class="fa-solid fa-ticket" style="font-size: 0.85rem;"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($attendees->hasPages())
        <div style="padding: 15px 25px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $attendees->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
