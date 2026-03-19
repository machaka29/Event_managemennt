@extends('layouts.organizer')

@section('title', 'Analytics & Reports - EmCa Technologies')

@section('content')
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.2rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px;">
                Analytics & Reports
            </h1>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
            <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">Comprehensive performance overview of your events</p>
        </div>
        <div style="text-align: right;">
            <div style="background: #FFF5F5; color: var(--corporate-red); padding: 10px 20px; border-radius: 30px; font-weight: bold; font-size: 0.9rem; display: inline-block;">
                <i class="fa-solid fa-calendar-check" style="margin-right: 8px;"></i> Updated Just Now
            </div>
        </div>
    </div>
</div>

<!-- SECTION 1: TOP LEVEL KPIS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 50px;">
    <!-- Card 1 -->
    <div style="background: white; border: 1px solid #eee; border-left: 5px solid var(--corporate-red); border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px;">
        <div style="background: #FFF5F5; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--corporate-red); font-size: 1.5rem;">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
        <div>
            <p style="color: #888; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin: 0 0 5px; letter-spacing: 1px;">Total Events</p>
            <div style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a;">{{ $totalEvents }}</div>
        </div>
    </div>

    <!-- Card 2 -->
    <div style="background: white; border: 1px solid #eee; border-left: 5px solid var(--corporate-red); border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px;">
        <div style="background: #FFF5F5; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--corporate-red); font-size: 1.5rem;">
            <i class="fa-solid fa-user-plus"></i>
        </div>
        <div>
            <p style="color: #888; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin: 0 0 5px; letter-spacing: 1px;">Registrations</p>
            <div style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a;">{{ $totalRegistrations }}</div>
        </div>
    </div>

    <!-- Card 3 -->
    <div style="background: white; border: 1px solid #eee; border-left: 5px solid var(--corporate-red); border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px;">
        <div style="background: #FFF5F5; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--corporate-red); font-size: 1.5rem;">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
        <div>
            <p style="color: #888; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin: 0 0 5px; letter-spacing: 1px;">Actual Attendance</p>
            <div style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a;">{{ $totalAttended }}</div>
        </div>
    </div>

    <!-- Card 4 -->
    <div style="background: white; border: 1px solid #eee; border-left: 5px solid var(--corporate-red); border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px;">
        <div style="background: #FFF5F5; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--corporate-red); font-size: 1.5rem;">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div>
            <p style="color: #888; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin: 0 0 5px; letter-spacing: 1px;">Success Rate</p>
            <div style="font-size: 1.8rem; font-weight: 800; color: #1a1a1a;">
                {{ $totalRegistrations > 0 ? number_format(($totalAttended / $totalRegistrations) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>
</div>

<!-- SECTION 2: DETAILED BREAKDOWN TABLE -->
<div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
    <div style="padding: 25px 35px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
        <h2 style="margin: 0; font-size: 1.3rem; color: #333; font-weight: 700;">Detailed Performance Breakdown</h2>
        <div style="font-size: 0.9rem; color: #888;">Showing {{ $events->count() }} total entries</div>
    </div>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding: 20px 35px; text-align: left; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Event Details</th>
                <th style="padding: 20px 35px; text-align: left; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Venue & Date</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Registration</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Attendance</th>
                <th style="padding: 20px 35px; text-align: right; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Quick Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                    <td style="padding: 25px 35px;">
                        <div style="font-weight: 700; color: #1a1a1a; font-size: 1.1rem; margin-bottom: 4px;">{{ $event->title }}</div>
                        <div style="color: #888; font-size: 0.85rem;">Event ID: #EV-{{ str_pad($event->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td style="padding: 25px 35px;">
                        <div style="color: #333; font-weight: 600; margin-bottom: 4px;"><i class="fa-solid fa-location-dot" style="width: 20px; color: #999;"></i> {{ $event->location }}</div>
                        <div style="color: #666; font-size: 0.9rem;"><i class="fa-solid fa-calendar" style="width: 20px; color: #999;"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</div>
                    </td>
                    <td style="padding: 25px 35px; text-align: center;">
                        <div style="font-size: 1.2rem; font-weight: 700; color: #333;">{{ $event->registrations_count }} <small style="color: #999; font-weight: normal; font-size: 0.8rem;">/ {{ $event->capacity }}</small></div>
                        <div style="font-size: 0.75rem; color: #888; margin-top: 5px;">{{ max(0, $event->capacity - $event->registrations_count) }} spots left</div>
                    </td>
                    <td style="padding: 25px 35px; text-align: center;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                            <div style="font-size: 1.2rem; font-weight: 800; color: var(--corporate-red);">{{ $event->attended_count }}</div>
                            <div style="background: #FFF5F5; color: var(--corporate-red); padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem;">
                                {{ $event->registrations_count > 0 ? number_format(($event->attended_count / $event->registrations_count) * 100, 1) : 0 }}% Rate
                            </div>
                        </div>
                    </td>
                    <td style="padding: 25px 35px; text-align: right;">
                        <a href="{{ route('events.export', $event->id) }}" style="display: inline-flex; align-items: center; gap: 8px; background: white; color: var(--corporate-red); border: 2px solid var(--corporate-red); padding: 10px 22px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: all 0.3s;" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='var(--corporate-red)';" title="Download Attendee Data">
                            <i class="fa-solid fa-download"></i> EXPORT DATA
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 80px; text-align: center; color: #bbb;">
                        <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.2;"><i class="fa-solid fa-chart-pie"></i></div>
                        <div style="font-size: 1.2rem; font-weight: 600;">No performance data available yet.</div>
                        <p style="margin-top: 10px;">Create and host events to see analytics here.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 40px; text-align: center; color: #999; font-size: 0.9rem;">
    <p>Premium Analytics Engine powered by <span style="color: var(--corporate-red); font-weight: bold;">EmCa Technologies</span></p>
</div>
@endsection
