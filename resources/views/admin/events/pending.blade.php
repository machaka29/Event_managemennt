@extends('layouts.admin')

@section('title', 'Pending Approvals - Admin Panel')

@section('content')
<div style="background: white; padding: 20px 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="font-size: 1.3rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase;">Pending Approvals</h1>
            <div style="width: 40px; height: 3px; background: var(--corporate-red); margin-top: 8px; border-radius: 2px;"></div>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 8px; font-weight: 600;">Review and approve new event submissions from organizers.</p>
        </div>
        <div style="font-size: 0.75rem; font-weight: 800; color: #f59e0b; background: #fffbeb; padding: 6px 14px; border-radius: 6px; border: 1px solid #fde68a;">
            <i class="fa-solid fa-clock"></i> AWAITING REVIEW
        </div>
    </div>
</div>

@if(session('success'))
    <div style="background: #FFF5F5; border-left: 4px solid var(--corporate-red); color: var(--corporate-red); padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 700;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div style="background: white; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 15px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
        <h2 style="margin: 0; font-size: 0.85rem; color: #475569; font-weight: 700;">Pending Events Queue</h2>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
                <input type="text" id="tableSearch" placeholder="Quick search..." 
                    style="padding: 8px 12px 8px 32px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.8rem; outline: none; width: 220px; transition: all 0.3s;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px var(--accent-soft-red)';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Total: {{ $events->total() }}</div>
        </div>
    </div>
    <div class="table-responsive" style="overflow-x: auto;">
        <table id="mainTable" style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: var(--corporate-red); color: white;">
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Event Details</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Organizer</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Location</th>
                    <th style="padding: 12px 25px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px 25px;">
                            <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem; margin-bottom: 4px;">{{ $event->title }}</div>
                            <div style="color: #94a3b8; font-size: 0.8rem; display: flex; align-items: center; gap: 12px;">
                                <span><i class="fa-solid fa-calendar-day" style="width: 14px; color: #cbd5e1;"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                <span><i class="fa-solid fa-clock" style="width: 14px; color: #cbd5e1;"></i> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                            </div>
                        </td>
                        <td style="padding: 14px 25px; color: #64748b; font-size: 0.85rem; font-weight: 600;">{{ $event->organizer->name }}</td>
                        <td style="padding: 14px 25px; color: #64748b; font-size: 0.85rem;">
                            <i class="fa-solid fa-location-dot" style="color: #cbd5e1; margin-right: 4px;"></i>{{ $event->location }}
                        </td>
                        <td style="padding: 14px 25px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <form action="{{ route('admin.events.approve', $event->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="height: 36px; padding: 0 16px; font-size: 0.75rem; font-weight: 800; background: var(--corporate-red); color: white; border: none; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: all 0.3s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                                        <i class="fa-solid fa-check"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.events.reject', $event->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="height: 36px; padding: 0 16px; font-size: 0.75rem; font-weight: 800; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: all 0.3s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                                        <i class="fa-solid fa-xmark"></i> Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 60px; text-align: center; color: #cbd5e1;">
                            <div style="font-size: 2.5rem; margin-bottom: 15px; opacity: 0.3;"><i class="fa-solid fa-circle-check"></i></div>
                            <div style="font-size: 0.95rem; font-weight: 600; color: #94a3b8;">All caught up! No events pending approval.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
        <div style="padding: 15px 25px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $events->links() }}
        </div>
    @endif
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
