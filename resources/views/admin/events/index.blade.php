@extends('layouts.admin')

@section('title', 'All Events - Admin Panel')

@section('content')
<div style="background: white; padding: 20px 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="font-size: 1.3rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase;">Global Events</h1>
            <div style="width: 40px; height: 3px; background: var(--corporate-red); margin-top: 8px; border-radius: 2px;"></div>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 8px; font-weight: 600;">View and manage all events created across the platform.</p>
        </div>
        <div style="font-size: 0.75rem; font-weight: 800; color: var(--corporate-red); background: var(--accent-soft-red); padding: 6px 14px; border-radius: 6px; border: 1px solid rgba(148,0,0,0.1);">
            <i class="fa-solid fa-earth-africa"></i> SYSTEM WIDE
        </div>
    </div>
</div>

<div style="background: white; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 15px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
        <h2 style="margin: 0; font-size: 0.85rem; color: #475569; font-weight: 700;">Active & Past Events</h2>
        <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Total: {{ $events->total() }}</div>
    </div>
    <div class="table-responsive" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="background: var(--corporate-red); color: white;">
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Event Details</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Organizer</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Location</th>
                    <th style="padding: 12px 25px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Registrations</th>
                    <th style="padding: 12px 25px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
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
                        <td style="padding: 14px 25px; text-align: center;">
                            <div style="font-size: 1rem; font-weight: 800; color: #1e293b;">{{ $event->registrations()->count() }}</div>
                            <div style="font-size: 0.65rem; color: #94a3b8; margin-top: 2px; text-transform: uppercase; font-weight: 700;">of {{ $event->capacity }}</div>
                        </td>
                        <td style="padding: 14px 25px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('events.public.show', $event->id) }}" target="_blank" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; color: var(--corporate-red); border-radius: 8px; text-decoration: none; border: 1px solid #eee; transition: all 0.3s;" title="View Event" onmouseover="this.style.background='var(--accent-soft-red)'; this.style.borderColor='var(--corporate-red)';" onmouseout="this.style.background='#f9f9f9'; this.style.borderColor='#eee';">
                                    <i class="fa-solid fa-eye" style="font-size: 0.85rem;"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event->id) }}" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; color: #475569; border-radius: 8px; text-decoration: none; border: 1px solid #eee; transition: all 0.3s;" title="Edit Event" onmouseover="this.style.background='#f1f5f9'; this.style.color='var(--corporate-red)'; this.style.borderColor='var(--corporate-red)';" onmouseout="this.style.background='#f9f9f9'; this.style.color='#475569'; this.style.borderColor='#eee';">
                                    <i class="fa-solid fa-pencil" style="font-size: 0.85rem;"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="width: 36px; height: 36px; border: none; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" title="Delete Event" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='#FFF5F5'; this.style.color='var(--corporate-red)';">
                                        <i class="fa-solid fa-trash-can" style="font-size: 0.85rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
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
