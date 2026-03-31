@extends('layouts.organizer')

@section('title', 'Manage Your Events - EmCa Techonologies')

@section('content')
<!-- SECTION: PREMIUM HEADER -->
<div class="dashboard-header-premium animate-up">
    <div class="header-main-row">
        <div class="header-text">
            <h1 class="page-title">Event Operations Hub</h1>
            <p class="page-subtitle">Strategize, monitor, and manage your full portfolio of events.</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('events.create') }}" class="btn-create-premium">
                <i class="fa-solid fa-plus"></i> CREATE EVENT
            </a>
        </div>
    </div>
    
    <div class="header-stats-row mt-4">
        <div class="h-stat-card">
            <div class="h-stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="h-stat-data">
                <div class="h-stat-num">{{ $events->total() }}</div>
                <div class="h-stat-label">Total Events</div>
            </div>
        </div>
        <div class="h-stat-card">
            <div class="h-stat-icon" style="color: #16a34a; background: #f0fdf4;"><i class="fa-solid fa-users"></i></div>
            <div class="h-stat-data">
                <div class="h-stat-num">{{ $events->sum('registrations_count') }}</div>
                <div class="h-stat-label">Total Registrations</div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-header-premium { background: white; border-bottom: 4px solid var(--corporate-red); border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .header-main-row { display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; }
    .page-title { font-size: 2rem; font-weight: 900; color: #0f172a; margin: 0; letter-spacing: -0.025em; }
    .page-subtitle { color: #64748b; font-size: 1rem; margin-top: 8px; font-weight: 500; }
    
    .btn-create-premium { background: var(--corporate-red); color: white; border-radius: 12px; padding: 14px 28px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(148,0,0,0.25); }
    .btn-create-premium:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(148,0,0,0.3); color: white; }

    .header-stats-row { display: flex; gap: 24px; flex-wrap: wrap; }
    .h-stat-card { display: flex; align-items: center; gap: 16px; background: #f8fafc; padding: 12px 20px; border-radius: 12px; border: 1px solid #f1f5f9; min-width: 220px; }
    .h-stat-icon { width: 44px; height: 44px; border-radius: 10px; background: var(--accent-soft-red); color: var(--corporate-red); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .h-stat-num { font-size: 1.25rem; font-weight: 900; color: #0f172a; }
    .h-stat-label { font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    .premium-table-card { background: white; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05); overflow: hidden; }
    .table-header-strip { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; background: #fafbfc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    
    .search-input-wrapper { position: relative; width: 300px; }
    .search-input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .search-input-wrapper input { width: 100%; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 15px 10px 42px; font-size: 0.9rem; outline: none; transition: 0.2s; }
    .search-input-wrapper input:focus { border-color: var(--corporate-red); box-shadow: 0 0 0 4px var(--accent-soft-red); }

    .premium-table { width: 100%; border-collapse: collapse; }
    .premium-table th { padding: 18px 24px; background: var(--corporate-red); text-align: left; font-size: 0.75rem; font-weight: 800; color: white; text-transform: uppercase; letter-spacing: 1.5px; border-bottom: none; }
    .premium-table td { padding: 20px 24px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; transition: 0.2s; }
    .premium-table tr:hover td { background-color: #fcfcfc; }

    .event-info-cell h3 { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; }
    .event-meta-info { display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #64748b; }
    .event-meta-info span { display: flex; align-items: center; gap: 6px; }
    .event-meta-info i { color: #cbd5e1; }

    .status-pill { padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid transparent; }
    .status-pill.active { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
    .status-pill.pending { background: #fefce8; color: #a16207; border-color: #fef08a; }

    .reg-counter { text-align: center; }
    .count-main { font-size: 1.25rem; font-weight: 900; color: #0f172a; display: block; }
    .count-sub { font-size: 0.7rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; }

    .table-action-btns { display: flex; gap: 8px; justify-content: flex-end; }
    .action-btn-circle { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; color: #64748b; text-decoration: none; transition: 0.2s; background: white; }
    .action-btn-circle:hover { border-color: var(--corporate-red); color: var(--corporate-red); transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .btn-delete:hover { border-color: #ef4444; color: #ef4444; background: #fef2f2; }

    .animate-up { animation: fadeInUp 0.5s ease-out both; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }

    @media (max-width: 768px) {
        .dashboard-header-premium { padding: 1.25rem; }
        .page-title { font-size: 1.5rem; }
        .header-stats-row { gap: 12px; }
        .h-stat-card { min-width: 100%; }
        .search-input-wrapper { width: 100%; order: 2; }
        .premium-table th:nth-child(3), .premium-table td:nth-child(3),
        .premium-table th:nth-child(4), .premium-table td:nth-child(4) { display: none; }
    }
</style>

@if(session('success'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<!-- SECTION: EVENTS LISTING -->
<div class="premium-table-card animate-up" style="animation-delay: 0.2s;">
    <div class="table-header-strip">
        <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #0f172a;">Active & Past Experiences</h2>
        <div class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="tableSearch" placeholder="Filter by event name or location...">
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Event Blueprint</th>
                    <th>Status</th>
                    <th style="text-align: center;">Engagement</th>
                    <th style="text-align: center;">Capacity</th>
                    <th style="text-align: right;">Operations</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td class="event-info-cell">
                            <h3>{{ $event->title }}</h3>
                            <div class="event-meta-info">
                                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                <span><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                                <span><i class="fa-solid fa-location-dot"></i> {{ \Illuminate\Support\Str::limit($event->location, 30) }}</span>
                            </div>
                        </td>
                        <td>
                            @if($event->status === 'approved')
                                <span class="status-pill active" style="font-weight: 900; background: #ecfdf5; color: #059669; border: 1.5px solid #d1fae5; border-radius: 30px; padding: 6px 14px; gap: 8px; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.05);">
                                    <span style="width: 6px; height: 6px; background: #059669; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span> ACTIVE
                                </span>
                            @else
                                <span class="status-pill pending">
                                    <i class="fa-solid fa-clock"></i> PENDING
                                </span>
                            @endif
                        </td>
                        <td class="reg-counter">
                            <span class="count-main">{{ $event->registrations_count }}</span>
                            <span class="count-sub">Registered</span>
                        </td>
                        <td class="reg-counter">
                            <span class="count-main">{{ $event->capacity }}</span>
                            <span class="count-sub">Total Slots</span>
                        </td>
                        <td>
                            <div class="table-action-btns">
                                <a href="{{ route('events.show', $event->id) }}" class="action-btn-circle" title="View Attendees" style="background: var(--accent-soft-red); color: var(--corporate-red); border-color: var(--corporate-red);">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('events.edit', $event->id) }}" class="action-btn-circle" title="Edit Event" style="background: #f8fafc;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('WARNING: You are about to delete an entire event. This will revoke all registration access. Proceed?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn-circle btn-delete" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 100px 20px; text-align: center;">
                            <div style="font-size: 3.5rem; color: #f1f5f9; margin-bottom: 20px;"><i class="fa-solid fa-calendar-xmark"></i></div>
                            <h4 style="color: #64748b; font-weight: 700;">No Event History Found</h4>
                            <p style="color: #94a3b8; font-size: 0.9rem;">Start by creating your first experience today.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($events->hasPages())
        <div style="padding: 20px 24px; border-top: 1px solid #f1f5f9; background: #fafbfc;">
            {{ $events->links() }}
        </div>
    @endif
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
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr:not(.empty-row)');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
