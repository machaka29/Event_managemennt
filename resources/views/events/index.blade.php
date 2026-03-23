@extends('layouts.organizer')

@section('title', 'Manage Your Events - EmCa Technologies')

@section('content')
<!-- SECTION: PREMIUM HEADER -->
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.22rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px; text-transform: none;">
                All Events
            </h1>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
            <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">Manage all your event listings, track statuses, and organize attendees.</p>
        </div>
        <div style="text-align: right;">
            <a href="{{ route('events.create') }}" style="display: inline-flex; align-items: center; gap: 10px; background: var(--corporate-red); color: white; padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1rem; box-shadow: 0 4px 15px rgba(148, 0, 0, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(148, 0, 0, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(148, 0, 0, 0.2)';" title="Create New Event">
                <i class="fa-solid fa-plus-circle" style="font-size: 1.2rem;"></i> CREATE NEW EVENT
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<!-- SECTION: EVENTS LISTING -->
<div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
    <div style="padding: 25px 35px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
        <h2 style="margin: 0; font-size: 1.3rem; color: #333; font-weight: 700;">Active & Past Events</h2>
        <div style="font-size: 0.9rem; color: #888;">Total Events: {{ $events->total() }}</div>
    </div>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding: 20px 35px; text-align: left; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Event Details</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Status</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Registration</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Capacity</th>
                <th style="padding: 20px 35px; text-align: right; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Action Hub</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                    <td style="padding: 25px 35px;">
                        <div style="font-weight: 700; color: #1a1a1a; font-size: 1.15rem; margin-bottom: 5px;">{{ $event->title }}</div>
                        <div style="color: #666; font-size: 0.9rem; display: flex; align-items: center; gap: 15px;">
                            <span><i class="fa-solid fa-calendar-day" style="width: 18px; color: #999;"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                            <span><i class="fa-solid fa-location-dot" style="width: 18px; color: #999;"></i> {{ $event->location }}</span>
                        </div>
                    </td>
                    <td style="padding: 25px 35px; text-align: center;">
                        @if($event->status === 'approved')
                            <span style="background: #eafaf1; color: #2ecc71; padding: 6px 15px; border-radius: 30px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #d4efdf;">
                                <i class="fa-solid fa-circle-check"></i> ACTIVE
                            </span>
                        @elseif($event->status === 'rejected')
                            <span style="background: #fdf2f2; color: #e74c3c; padding: 6px 15px; border-radius: 30px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #f9dcdc;">
                                <i class="fa-solid fa-circle-xmark"></i> REJECTED
                            </span>
                        @else
                            <span style="background: #fff9e6; color: #f1c40f; padding: 6px 15px; border-radius: 30px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #fef5d4;">
                                <i class="fa-solid fa-clock"></i> PENDING
                            </span>
                        @endif
                    </td>
                    <td style="padding: 25px 35px; text-align: center;">
                        <div style="font-size: 1.3rem; font-weight: 800; color: #333;">{{ $event->registrations_count }}</div>
                        <div style="font-size: 0.75rem; color: #999; margin-top: 4px; text-transform: uppercase; font-weight: bold;">Tickets Issued</div>
                    </td>
                    <td style="padding: 25px 35px; text-align: center;">
                        <div style="font-size: 1.3rem; font-weight: 800; color: #666;">{{ $event->capacity }}</div>
                        <div style="font-size: 0.75rem; color: #999; margin-top: 4px; text-transform: uppercase; font-weight: bold;">Total Capacity</div>
                    </td>
                    <td style="padding: 25px 35px; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <a href="{{ route('events.show', $event->id) }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #ebf5fb; color: #3498db; border-radius: 8px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#3498db'; this.style.color='white';" onmouseout="this.style.background='#ebf5fb'; this.style.color='#3498db';" title="View Event Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('events.edit', $event->id) }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #fef9e7; color: #f1c40f; border-radius: 8px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#f1c40f'; this.style.color='white';" onmouseout="this.style.background='#fef9e7'; this.style.color='#f1c40f';" title="Edit Event Listing">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Wait! Are you sure you want to delete this event? This action cannot be undone.');">
                                @csrf @method('DELETE')
                                <button type="submit" style="width: 40px; height: 40px; border: none; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='#FFF5F5'; this.style.color='var(--corporate-red)';" title="Permanently Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 80px; text-align: center; color: #bbb;">
                        <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.2;"><i class="fa-solid fa-calendar-minus"></i></div>
                        <div style="font-size: 1.2rem; font-weight: 600;">No events found in your account.</div>
                        <p style="margin-top: 10px;">Start by creating your first global event.</p>
                        <a href="{{ route('events.create') }}" style="display: inline-block; margin-top: 20px; color: var(--corporate-red); font-weight: bold; text-decoration: underline;">Create Now</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($events->hasPages())
        <div style="padding: 25px 35px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $events->links() }}
        </div>
    @endif
</div>

<div style="margin-top: 40px; text-align: center; color: #999; font-size: 0.9rem;">
    <p>Event Management Workspace powered by <span style="color: var(--corporate-red); font-weight: bold;">EmCa Technologies</span></p>
</div>
@endsection
