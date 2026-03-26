@extends('layouts.organizer')

@section('title', 'Manage Your Events - EmCa Techonologies')

@section('content')
<!-- SECTION: PREMIUM HEADER -->
<div style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);" class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="flex: 1; min-width: 250px;">
            <h1 style="font-size: 1.8rem; color: #333; margin: 0; font-weight: 800; letter-spacing: -0.5px; text-transform: none;">
                All Events
            </h1>
            <div style="width: 50px; height: 4px; background: var(--corporate-red); margin-top: 10px; border-radius: 2px;"></div>
            <p style="font-size: 1rem; color: #666; margin-top: 12px; font-weight: 500;">Manage all your event listings and organize attendees.</p>
        </div>
        <div style="flex: 1; min-width: 200px; text-align: right;" class="header-actions">
            <a href="{{ route('events.create') }}" class="btn btn-primary" style="width: auto; min-width: 200px;">
                <i class="fa-solid fa-plus-circle"></i> CREATE NEW EVENT
            </a>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .page-header { padding: 15px !important; }
        .page-header h1 { font-size: 1.4rem !important; }
        .header-actions { text-align: left !important; width: 100%; }
        .header-actions .btn { width: 100% !important; }
        
        .col-status { width: 40px !important; padding: 10px 2px !important; }
        .col-stats { width: 45px !important; padding: 10px 2px !important; }
        .status-badge { padding: 5px !important; width: 30px; height: 30px; justify-content: center; }
        .hide-mobile { display: none !important; }
        .stat-value { font-size: 0.9rem !important; }
        .stat-label { font-size: 0.55rem !important; }
    }
</style>

@if(session('success'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<!-- SECTION: EVENTS LISTING -->
<div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
    <div style="padding: 20px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa; flex-wrap: wrap; gap: 10px;">
        <h2 style="margin: 0; font-size: 1.15rem; color: #333; font-weight: 700;">Active & Past Events</h2>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
                <input type="text" id="tableSearch" placeholder="Search events..." style="padding: 8px 15px 8px 35px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.8rem; outline: none; width: 250px; transition: all 0.2s;" onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            <div style="font-size: 0.85rem; color: #888; font-weight: 600;">Total: {{ $events->total() }}</div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--corporate-red); color: white;">
                    <th style="padding: 15px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Event Details</th>
                    <th style="padding: 15px 25px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-status">Status</th>
                    <th style="padding: 15px 25px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-stats">Reg.</th>
                    <th style="padding: 15px 25px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-stats">Cap.</th>
                    <th style="padding: 15px 25px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-action">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                        <td style="padding: 20px 25px;">
                            <div style="font-weight: 700; color: #1a1a1a; font-size: 1.1rem; margin-bottom: 5px;">{{ $event->title }}</div>
                            <div style="color: #666; font-size: 0.85rem; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <span><i class="fa-solid fa-calendar-day" style="width: 16px; color: #999;"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                <span><i class="fa-solid fa-location-dot" style="width: 16px; color: #999;"></i> {{ $event->location }}</span>
                            </div>
                        </td>
                        <td style="padding: 20px 25px; text-align: center;" class="col-status">
                            @if($event->status === 'approved')
                                <span style="background: var(--accent-soft-red); color: var(--corporate-red); padding: 5px 12px; border-radius: 30px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid var(--corporate-red);" class="status-badge">
                                    <i class="fa-solid fa-circle-check"></i> <span class="hide-mobile">ACTIVE</span>
                                </span>
                            @else
                                <span style="background: #fafafa; color: #666; padding: 5px 12px; border-radius: 30px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #eee;" class="status-badge">
                                    <i class="fa-solid fa-clock"></i> <span class="hide-mobile">PENDING</span>
                                </span>
                            @endif
                        </td>
                        <td style="padding: 20px 25px; text-align: center;" class="col-stats">
                            <div style="font-size: 1.2rem; font-weight: 800; color: #333;" class="stat-value">{{ $event->registrations_count }}</div>
                            <div style="font-size: 0.65rem; color: #999; margin-top: 4px; text-transform: uppercase; font-weight: bold;" class="stat-label">Reg</div>
                        </td>
                        <td style="padding: 20px 25px; text-align: center;" class="col-stats">
                            <div style="font-size: 1.2rem; font-weight: 800; color: #666;" class="stat-value">{{ $event->capacity }}</div>
                            <div style="font-size: 0.65rem; color: #999; margin-top: 4px; text-transform: uppercase; font-weight: bold;" class="stat-label">Cap</div>
                        </td>
                        <td style="padding: 20px 25px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('events.show', $event->id) }}" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; color: var(--corporate-red); border-radius: 8px; text-decoration: none; border: 1px solid #eee; transition: all 0.3s;" title="View Detail">
                                    <i class="fa-solid fa-eye" style="font-size: 0.9rem;"></i>
                                </a>
                                <a href="{{ route('events.edit', $event->id) }}" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; color: #333; border-radius: 8px; text-decoration: none; border: 1px solid #eee; transition: all 0.3s;" title="Edit Event">
                                    <i class="fa-solid fa-pencil" style="font-size: 0.9rem;"></i>
                                </a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Wait! Are you sure you want to delete this event? This action cannot be undone.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="width: 36px; height: 36px; border: none; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" title="Delete">
                                        <i class="fa-solid fa-trash-can" style="font-size: 0.9rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 80px; text-align: center; color: #bbb;">
                            <div style="font-size: 3rem; margin-bottom: 20px; opacity: 0.2;"><i class="fa-solid fa-calendar-minus"></i></div>
                            <div style="font-size: 1.1rem; font-weight: 600;">No events found in your account.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($events->hasPages())
        <div style="padding: 25px 35px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $events->links() }}
        </div>
    @endif
</div>

<div style="margin-top: 40px; text-align: center; color: #999; font-size: 0.9rem;">
    <p>Event Management Workspace powered by <span style="color: var(--corporate-red); font-weight: bold;">EmCa Techonologies</span></p>
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
