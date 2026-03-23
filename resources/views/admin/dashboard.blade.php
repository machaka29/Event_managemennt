@extends('layouts.admin')

@section('title', 'Admin Dashboard - EventReg')

@section('content')
    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1.5rem;">
        @if(auth()->user()->profile_image)
            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @else
            <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: 'Century Gothic', sans-serif;">
                {{ strtoupper(auth()->user()->name[0]) }}
            </div>
        @endif
        <div>
            <h1 style="margin: 0;">System Administration</h1>
            <p style="color: var(--text-muted); margin: 0;">Overview of all platform activity.</p>
        </div>
<div style="margin-bottom: 2rem; border-bottom: 2px solid var(--corporate-red); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="color: var(--corporate-red); font-size: 1.8rem; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Admin Dashboard</h1>
    </div>
    <div style="font-size: 0.9rem; color: #666;">
        <i class="fa-solid fa-clock-rotate-left"></i> Last updated: {{ now()->format('h:i A') }}
    </div>
</div>

<!-- 1. STATISTICS CARDS (4) -->
<div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px;">
    <!-- Total Events -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(148,0,0,0.05);">
        <div style="color: #333; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">Total Events</div>
        <div style="font-size: 28px; font-weight: bold; color: var(--corporate-red);">{{ number_format($totalEvents) }}</div>
        <div style="font-size: 0.8rem; color: #666; margin-top: 5px;">{{ $upcomingEventsCount }} upcoming</div>
    </div>

    <!-- System Settings -->
    <div class="card" style="margin-bottom: 3rem; border-top: 4px solid var(--corporate-red);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="margin: 0;">System Branding & Settings</h3>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline">Text Settings</a>
        </div>
        <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data" style="display: flex; align-items: flex-end; gap: 2rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 0; flex: 1;">
                <label for="system_logo">Update Company Logo (Circular)</label>
                <input type="file" name="system_logo" id="system_logo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Logo</button>
        </form>
    <!-- Total Registrations -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(148,0,0,0.05);">
        <div style="color: #333; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">Total Registrations</div>
        <div style="font-size: 28px; font-weight: bold; color: var(--corporate-red);">{{ number_format($totalRegistrations) }}</div>
        <div style="font-size: 0.8rem; color: #666; margin-top: 5px;">+{{ $registrationsThisMonth }} this month</div>
    </div>

    <!-- Active Events -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(148,0,0,0.05);">
        <div style="color: #333; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">Active Events</div>
        <div style="font-size: 28px; font-weight: bold; color: var(--corporate-red);">{{ $activeEventsCount }}</div>
        <div style="font-size: 0.8rem; color: #666; margin-top: 5px;">{{ $ongoingEventsCount }} ongoing</div>
    </div>

    <!-- Total Organizers -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(148,0,0,0.05);">
        <div style="color: #333; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">Total Organizers</div>
        <div style="font-size: 28px; font-weight: bold; color: var(--corporate-red);">{{ $totalOrganizers }}</div>
        <div style="font-size: 0.8rem; color: #666; margin-top: 5px;">{{ $pendingOrganizers }} pending approval</div>
    </div>
</div>

<!-- QUICK ACTIONS SECTION -->
<div style="margin-bottom: 40px; background: #fafafa; padding: 25px; border-radius: 12px; border: 1px dashed var(--corporate-red); display: flex; align-items: center; justify-content: space-between; gap: 20px;">
    <div>
        <h3 style="margin: 0; font-size: 1rem; color: #333; text-transform: uppercase; font-weight: 800;">Quick Actions</h3>
        <p style="margin: 5px 0 0; font-size: 0.85rem; color: #666;">Perform common administrative tasks instantly.</p>
    </div>
    <div style="display: flex; gap: 15px;">
        <a href="{{ route('admin.organizers.create') }}" class="btn" style="background: var(--corporate-red); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(148, 0, 0, 0.2); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" >
            <i class="fa-solid fa-user-plus"></i> ADD NEW ORGANIZER
        </a>
        <a href="{{ route('admin.attendees.create') }}" class="btn" style="background: #1a1a1a; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" >
            <i class="fa-solid fa-person-circle-plus"></i> REGISTER NEW MEMBER
        </a>
    </div>
</div>

<!-- 2. RECENT EVENTS TABLE -->
<div style="margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="margin: 0; color: #333; font-size: 1.1rem; text-transform: uppercase; border-bottom: 2px solid var(--corporate-red);">Recent Events</h3>
        <a href="{{ route('admin.events.index') }}" style="color: var(--corporate-red); text-decoration: none; font-size: 0.9rem; font-weight: bold;">View All <i class="fa-solid fa-arrow-right-long"></i></a>
    </div>
    <div style="border: 1px solid var(--corporate-red); border-radius: 4px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--header-gradient); text-align: left;">
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Event Name</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Date</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Location</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Capacity</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentEvents as $event)
                    <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                        <td style="padding: 12px 15px; font-weight: bold;">{{ $event->title }}</td>
                        <td style="padding: 12px 15px;">{{ \Carbon\Carbon::parse($event->date)->format('M d, y') }}</td>
                        <td style="padding: 12px 15px;">{{ \Illuminate\Support\Str::limit($event->location, 15) }}</td>
                        <td style="padding: 12px 15px;">{{ $event->registrations_count }}/{{ $event->capacity }}</td>
                        <td style="padding: 12px 15px;">
                            @if(\Carbon\Carbon::parse($event->date)->isToday())
                                <span style="color: #f59e0b; font-weight: bold;">Ongoing</span>
                            @elseif(\Carbon\Carbon::parse($event->date)->isFuture())
                                <span style="color: #10b981; font-weight: bold;">Upcoming</span>
                            @else
                                <span style="color: #666;">Passed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 3. RECENT REGISTRATIONS TABLE -->
<div style="margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="margin: 0; color: #333; font-size: 1.1rem; text-transform: uppercase; border-bottom: 2px solid var(--corporate-red);">Recent Registrations</h3>
        <a href="{{ route('admin.attendees.index') }}" style="color: var(--corporate-red); text-decoration: none; font-size: 0.9rem; font-weight: bold;">View All <i class="fa-solid fa-arrow-right-long"></i></a>
    </div>
    <div style="border: 1px solid var(--corporate-red); border-radius: 4px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--header-gradient); text-align: left;">
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Attendee</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Event</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Date</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem;">Status</th>
                    <th style="padding: 12px 15px; color: var(--corporate-red); font-size: 0.9rem; text-align: right;">Act</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRegistrations as $reg)
                    <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                        <td style="padding: 12px 15px; font-weight: bold;">{{ $reg->attendee->full_name }}</td>
                        <td style="padding: 12px 15px;">{{ \Illuminate\Support\Str::limit($reg->event->title, 20) }}</td>
                        <td style="padding: 12px 15px;">{{ $reg->created_at->format('M d, y') }}</td>
                        <td style="padding: 12px 15px;">
                            <span style="background: #FFF5F5; color: var(--corporate-red); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">
                                {{ $reg->attended ? 'Attended' : 'Confirmed' }}
                            </span>
                        </td>
                        <td style="padding: 12px 15px; text-align: right;">
                            <a href="{{ route('events.public.ticket', $reg->ticket_id) }}" target="_blank" style="color: var(--corporate-red);"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
    <!-- 4. QUICK ACTIONS -->
    <div style="background: white; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="margin: 0 0 1.5rem; font-size: 1rem; color: #333; text-transform: uppercase; font-weight: bold;">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="{{ route('events.create') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.95rem;">• Create Event</a>
            <a href="{{ route('admin.reports.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.95rem;">• View Reports</a>
            <a href="{{ route('admin.organizers.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.95rem;">• Manage Organizers</a>
            <a href="{{ route('admin.settings.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.95rem;">• System Settings</a>
        </div>
    </div>

    <!-- 5. SYSTEM STATISTICS -->
    <div style="background: white; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="margin: 0 0 1.5rem; font-size: 1rem; color: #333; text-transform: uppercase; font-weight: bold;">System Statistics</h3>
        <div class="breadcrumb">
            <i class="fa-solid fa-house"></i>
            <span>EmCa Technologies</span>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span style="color: var(--corporate-red);">Admin Dashboard</span>
        </div>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #666;">• Total Attendees:</span>
                <span style="font-weight: bold; color: var(--corporate-red);">{{ number_format($systemStats['total_attendees']) }}</span>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <span style="color: #666;">• Events This Month:</span>
                <span style="font-weight: bold; color: var(--corporate-red);">{{ $systemStats['events_this_month'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #666;">• Active Organizers:</span>
                <span style="font-weight: bold; color: var(--corporate-red);">{{ $systemStats['active_organizers'] }}</span>
            </div>
        </div>
    </div>

    <div style="margin-top: 3rem;">
        <a href="javascript:history.back()" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back
        </a>
    </div>
</div>

<!-- 6. REGISTRATIONS THIS MONTH (CHART) -->
<div style="background: #FFF5F5; border-radius: 8px; padding: 25px; border: 1px solid var(--corporate-red);">
    <h3 style="margin: 0 0 20px; color: #333; font-size: 1.1rem; text-transform: uppercase; border-bottom: 2px solid var(--corporate-red); display: inline-block;">Registrations This Month</h3>
    <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 200px; padding-top: 20px;">
        @foreach($registrationsByWeek as $index => $count)
            <div style="text-align: center; flex: 1;">
                <div style="background: var(--corporate-red); height: {{ $totalRegistrations > 0 ? ($count / $totalRegistrations) * 200 : 0 }}px; width: 60px; margin: 0 auto; border-radius: 5px 5px 0 0; position: relative;">
                    <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: bold; color: var(--corporate-red); font-size: 0.85rem;">{{ $count }}</span>
                </div>
                <div style="margin-top: 10px; font-size: 0.85rem; font-weight: bold; color: #333;">Week {{ $index + 1 }}</div>
            </div>
        @endforeach
    </div>
</div>
@endsection
