@extends('layouts.admin')

@section('title', 'Admin Dashboard - EventReg')

@section('content')
    <!-- Dashboard Header -->
    <div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); padding-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 65px; height: 65px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent-soft-red); box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            @else
                <div style="width: 65px; height: 65px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    {{ strtoupper(auth()->user()->name[0]) }}
                </div>
            @endif
            <div>
                <h1 style="margin: 0; color: #333; font-size: 1.8rem; font-weight: 800;">ADMIN DASHBOARD</h1>
                <p style="color: var(--corporate-red); margin: 0; font-weight: 600; font-size: 0.9rem;">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </div>
        <div style="text-align: right; font-size: 0.9rem; color: #666; background: white; padding: 10px 15px; border-radius: 8px; border: 1px solid #eee;">
            <i class="fa-solid fa-calendar-day" style="color: var(--corporate-red);"></i> {{ now()->format('D, M d, Y') }}
        </div>
    </div>

    <!-- 1. STATISTICS CARDS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 3rem;">
        <!-- Total Events -->
        <div style="background: white; border-left: 5px solid var(--corporate-red); border-radius: 10px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="color: #666; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 12px; display: flex; justify-content: space-between;">
                TOTAL EVENTS <i class="fa-solid fa-calendar-check" style="color: var(--corporate-red);"></i>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #333;">{{ number_format($totalEvents) }}</div>
            <div style="font-size: 0.85rem; color: var(--corporate-red); margin-top: 8px; font-weight: 600;">{{ $upcomingEventsCount }} upcoming</div>
        </div>

        <!-- Total Registrations -->
        <div style="background: white; border-left: 5px solid var(--corporate-red); border-radius: 10px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="color: #666; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 12px; display: flex; justify-content: space-between;">
                REGISTRATIONS <i class="fa-solid fa-users" style="color: var(--corporate-red);"></i>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #333;">{{ number_format($totalRegistrations) }}</div>
            <div style="font-size: 0.85rem; color: var(--corporate-red); margin-top: 8px; font-weight: 600;">+{{ $registrationsThisMonth }} this month</div>
        </div>

        <!-- Active Organizers -->
        <div style="background: white; border-left: 5px solid var(--corporate-red); border-radius: 10px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="color: #666; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 12px; display: flex; justify-content: space-between;">
                ORGANIZERS <i class="fa-solid fa-user-tie" style="color: var(--corporate-red);"></i>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #333;">{{ $totalOrganizers }}</div>
            <div style="font-size: 0.85rem; color: var(--corporate-red); margin-top: 8px; font-weight: 600;">{{ $pendingOrganizers }} pending</div>
        </div>

        <!-- Capacity Used -->
        <div style="background: white; border-left: 5px solid var(--corporate-red); border-radius: 10px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="color: #666; font-size: 0.85rem; font-weight: bold; text-transform: uppercase; margin-bottom: 12px; display: flex; justify-content: space-between;">
                ACTIVE EVENTS <i class="fa-solid fa-bolt" style="color: var(--corporate-red);"></i>
            </div>
            <div style="font-size: 32px; font-weight: 900; color: #333;">{{ $activeEventsCount }}</div>
            <div style="font-size: 0.85rem; color: #666; margin-top: 8px; font-weight: 600;">{{ $ongoingEventsCount }} ongoing</div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div style="margin-bottom: 3rem; background: var(--corporate-red); padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(148,0,0,0.15); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 20px;">
        <div style="flex: 1; min-width: 300px;">
            <h3 style="margin: 0; font-size: 1.25rem; color: white; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">Quick Actions</h3>
            <p style="margin: 8px 0 0; font-size: 0.9rem; color: #aaa;">Common administrative controls at your fingertips.</p>
        </div>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="{{ route('admin.organizers.create') }}" class="btn" style="background: var(--corporate-red); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(148, 0, 0, 0.3);">
                <i class="fa-solid fa-user-plus"></i> ADD ORGANIZER
            </a>
            <a href="{{ route('admin.attendees.create') }}" class="btn" style="background: white; color: #333; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);">
                <i class="fa-solid fa-person-circle-plus"></i> REGISTER MEMBER
            </a>
            <a href="{{ route('admin.sms.create') }}" class="btn" style="background: #666; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; transition: 0.3s;" onmouseover="this.style.background='#333'">
                <i class="fa-solid fa-comment-sms"></i> SEND SMS
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 3rem;">
        <!-- RECENT EVENTS -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 800; text-transform: uppercase;">Recent Events</h3>
                <a href="{{ route('admin.events.index') }}" style="color: var(--corporate-red); text-decoration: none; font-size: 0.85rem; font-weight: bold;">View All <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid #f4f4f4;">
                            <th style="padding: 12px 10px; color: #666; font-size: 0.8rem; text-transform: uppercase;">Event</th>
                            <th style="padding: 12px 10px; color: #666; font-size: 0.8rem; text-transform: uppercase;">Date</th>
                            <th style="padding: 12px 10px; color: #666; font-size: 0.8rem; text-transform: uppercase;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEvents as $event)
                            <tr style="border-bottom: 1px solid #f9f9f9;">
                                <td style="padding: 15px 10px; font-weight: 600; color: #333;">{{ $event->title }}</td>
                                <td style="padding: 15px 10px; font-size: 0.9rem; color: #666;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                <td style="padding: 15px 10px;">
                                    @if(\Carbon\Carbon::parse($event->date)->isToday())
                                        <span style="color: var(--corporate-red); font-size: 0.8rem; font-weight: bold; background: var(--accent-soft-red); padding: 4px 8px; border-radius: 4px;">Ongoing</span>
                                    @elseif(\Carbon\Carbon::parse($event->date)->isFuture())
                                        <span style="color: var(--corporate-red); font-size: 0.8rem; font-weight: bold; background: var(--accent-soft-red); padding: 4px 8px; border-radius: 4px;">Upcoming</span>
                                    @else
                                        <span style="color: #999; font-size: 0.8rem; background: #f3f4f6; padding: 4px 8px; border-radius: 4px;">Past</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RECENT REGISTRATIONS -->
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3 style="margin: 0 0 20px; color: #333; font-size: 1.1rem; font-weight: 800; text-transform: uppercase;">Recent Signups</h3>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($recentRegistrations as $reg)
                    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 12px; border-bottom: 1px solid #f4f4f4;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent-soft-red); color: var(--corporate-red); display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ $reg->attendee->full_name[0] }}
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.9rem; color: #333;">{{ $reg->attendee->full_name }}</p>
                            <p style="margin: 0; font-size: 0.75rem; color: #999;">{{ $reg->event->title }}</p>
                        </div>
                        <div style="font-size: 0.7rem; color: #bbb;">{{ $reg->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.attendees.index') }}" style="display: block; text-align: center; margin-top: 20px; color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.85rem;">View All Members</a>
        </div>
    </div>

    <!-- SYSTEM BRANDING -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 3rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 800; text-transform: uppercase;">System Branding</h3>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline" style="font-size: 0.85rem; border: 1px solid #ddd; padding: 8px 15px;">Advanced Settings</a>
        </div>
        <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr auto; align-items: flex-end; gap: 2rem;">
            @csrf
            <div>
                <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #666; font-size: 0.9rem;">Current System Name</label>
                <div style="padding: 12px; background: #f8f8f8; border-radius: 8px; border: 1px solid #eee; font-weight: bold; color: #333;">
                    {{ \App\Models\SystemSetting::get('system_name', 'EmCa Technologies') }}
                </div>
            </div>
            <div>
                <label for="system_logo" style="display: block; margin-bottom: 10px; font-weight: 600; color: #666; font-size: 0.9rem;">Update Logo</label>
                <input type="file" name="system_logo" id="system_logo" class="form-control" style="background: #fff; padding: 10px; height: auto;" required>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">Upload & Apply</button>
        </form>
    </div>

    <!-- REGISTRATIONS CHART SKELETON -->
    <div style="background: white; border: 1px solid var(--corporate-red); border-radius: 12px; padding: 40px; color: #333; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 30px; color: #333; font-size: 1.1rem; text-transform: uppercase; font-weight: 800; border-left: 4px solid var(--corporate-red); padding-left: 15px;">Monthly Activity Overview</h3>
        <div style="display: flex; align-items: flex-end; justify-content: space-around; height: 180px; padding-top: 20px;">
            @foreach($registrationsByWeek as $index => $count)
                @php $height = $totalRegistrations > 0 ? ($count / $totalRegistrations) * 180 : 5; @endphp
                <div style="text-align: center; flex: 1; display: flex; flex-direction: column; align-items: center; gap: 15px;">
                    <div style="background: var(--header-gradient); width: 45px; height: {{ max($height, 5) }}px; border-radius: 6px 6px 0 0; position: relative; transition: all 0.3s;" onmouseover="this.style.filter='brightness(1.2)'" onmouseout="this.style.filter='none'">
                        <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: bold; color: var(--corporate-red); font-size: 0.8rem;">{{ $count }}</span>
                    </div>
                    <div style="font-size: 0.75rem; color: #777; font-weight: bold;">WEEK {{ $index + 1 }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
