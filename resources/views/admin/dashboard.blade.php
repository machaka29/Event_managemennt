@extends('layouts.admin')

@section('title', 'Admin Dashboard - EventReg')

@section('content')
    <!-- Dashboard Header - COMPACT -->
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); padding-bottom: 12px; flex-wrap: wrap; gap: 15px;" class="dashboard-header">
        <div style="display: flex; align-items: center; gap: 1rem;">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-soft-red);">
            @else
                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: bold; border: 2px solid white;">
                    {{ strtoupper(auth()->user()->name[0]) }}
                </div>
            @endif
            <div>
                <h1 style="margin: 0; color: #333; font-size: 1.3rem; font-weight: 800; text-transform: uppercase;">Admin Overview</h1>
                <p style="color: var(--corporate-red); margin: 0; font-weight: 700; font-size: 0.8rem;">Session: {{ auth()->user()->name }}</p>
            </div>
        </div>
        <div style="font-size: 0.8rem; color: #666; background: #fafafa; padding: 8px 12px; border-radius: 6px; border: 1px solid #eee;">
            <i class="fa-solid fa-calendar-check" style="color: var(--corporate-red);"></i> {{ now()->format('d M, Y') }}
        </div>
    </div>

    <!-- 1. STATISTICS CARDS - COMPACT -->
    <div class="stats-grid" style="gap: 1.25rem;">
        <!-- Total Events -->
        <div class="card" style="padding: 18px; border-left: 4px solid var(--corporate-red);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: flex; justify-content: space-between;">
                Events <i class="fa-solid fa-calendar" style="color: var(--corporate-red); opacity: 0.5;"></i>
            </div>
            <div style="font-size: 1.75rem; font-weight: 900; color: #1e293b;">{{ number_format($totalEvents) }}</div>
            <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 5px;">{{ $upcomingEventsCount }} Scheduled</div>
        </div>

        <!-- Active Events -->
        <div class="card" style="padding: 18px; border-left: 4px solid var(--corporate-red);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: flex; justify-content: space-between;">
                Active <i class="fa-solid fa-bolt" style="color: var(--corporate-red); opacity: 0.5;"></i>
            </div>
            <div style="font-size: 1.75rem; font-weight: 900; color: #1e293b;">{{ $activeEventsCount }}</div>
            <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 5px;">{{ $ongoingEventsCount }} Today</div>
        </div>

        <!-- Total Registrations -->
        <div class="card" style="padding: 18px; border-left: 4px solid var(--corporate-red);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: flex; justify-content: space-between;">
                Members <i class="fa-solid fa-users" style="color: var(--corporate-red); opacity: 0.5;"></i>
            </div>
            <div style="font-size: 1.75rem; font-weight: 900; color: #1e293b;">{{ number_format($totalRegistrations) }}</div>
            <div style="font-size: 0.7rem; color: #059669; margin-top: 5px; font-weight: 700;">+{{ $registrationsThisMonth }} this month</div>
        </div>

        <!-- Organizers -->
        <div class="card" style="padding: 18px; border-left: 4px solid var(--corporate-red);">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: flex; justify-content: space-between;">
                Staff <i class="fa-solid fa-user-tie" style="color: var(--corporate-red); opacity: 0.5;"></i>
            </div>
            <div style="font-size: 1.75rem; font-weight: 900; color: #1e293b;">{{ $totalOrganizers }}</div>
            <div style="font-size: 0.7rem; color: #64748b; margin-top: 5px;">Active Organizers</div>
        </div>

        <!-- Pending Approvals -->
        <a href="{{ route('admin.events.pending') }}" class="card" style="padding: 18px; border-left: 4px solid #f59e0b; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#fffbeb';" onmouseout="this.style.background='white';">
            <div style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; display: flex; justify-content: space-between;">
                Approvals <i class="fa-solid fa-clock" style="color: #f59e0b; opacity: 0.8;"></i>
            </div>
            <div style="font-size: 1.75rem; font-weight: 900; color: #1e293b;">{{ $systemStats['pending_approvals'] }}</div>
            <div style="font-size: 0.7rem; color: #f59e0b; margin-top: 5px; font-weight: 700;">Awaiting Review</div>
        </a>
    </div>

    <!-- QUICK ACTIONS - COMPACT -->
    <div style="margin-bottom: 2.5rem; background: #fafafa; padding: 20px; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; gap: 20px; border: 1px solid #e2e8f0; border-left: 4px solid var(--corporate-red);">
        <div style="flex: 1;">
            <h3 style="margin: 0; font-size: 1rem; color: #1e293b; text-transform: uppercase; font-weight: 800;">Command Center</h3>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.organizers.create') }}" class="btn btn-primary" style="height: 40px; padding: 0 20px; font-size: 0.8rem;">
                <i class="fa-solid fa-plus-circle"></i> NEW ORGANIZER
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <!-- RECENT EVENTS -->
        <div class="card" style="padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #1e293b; font-size: 1rem; font-weight: 800; text-transform: uppercase;">Recent Events</h3>
                <a href="{{ route('admin.events.index') }}" style="color: var(--corporate-red); text-decoration: none; font-size: 0.85rem; font-weight: bold;">View All <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--corporate-red); color: white;">
                            <th style="padding: 12px 10px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Event</th>
                            <th style="padding: 12px 10px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Date</th>
                            <th style="padding: 12px 10px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEvents as $event)
                            <tr style="border-bottom: 1px solid #f8fafc;">
                                <td style="padding: 15px 10px; font-weight: 600; color: #1e293b;">{{ $event->title }}</td>
                                <td style="padding: 15px 10px; font-size: 0.85rem; color: #64748b;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                <td style="padding: 15px 10px;">
                                    @if(\Carbon\Carbon::parse($event->date)->isToday())
                                        <span style="color: #059669; font-size: 0.75rem; font-weight: bold; background: #ecfdf5; padding: 4px 10px; border-radius: 20px;">Ongoing</span>
                                    @elseif(\Carbon\Carbon::parse($event->date)->isFuture())
                                        <span style="color: var(--corporate-red); font-size: 0.75rem; font-weight: bold; background: var(--accent-soft-red); padding: 4px 10px; border-radius: 20px;">Upcoming</span>
                                    @else
                                        <span style="color: #64748b; font-size: 0.75rem; background: #f1f5f9; padding: 4px 10px; border-radius: 20px;">Past</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RECENT REGISTRATIONS -->
        <div class="card" style="padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; flex-direction: column;">
            <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 1rem; font-weight: 800; text-transform: uppercase;">Recent Signups</h3>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($recentRegistrations as $reg)
                    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent-soft-red); color: var(--corporate-red); display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ $reg->attendee->full_name[0] }}
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.85rem; color: #1e293b;">{{ $reg->attendee->full_name }}</p>
                            <p style="margin: 0; font-size: 0.75rem; color: #64748b;">{{ $reg->event->title }}</p>
                        </div>
                        <div style="font-size: 0.7rem; color: #94a3b8;">{{ $reg->created_at->diffForHumans() }}</div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.attendees.index') }}" style="display: block; text-align: center; margin-top: 20px; color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.85rem;">View All Members</a>
        </div>
    </div>

    <!-- SYSTEM IDENTITY SUMMARY -->
    <div class="card" style="padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 3rem; display: flex; align-items: center; justify-content: space-between; gap: 30px; flex-wrap: wrap; flex-direction: row; height: auto;">
        <div style="display: flex; align-items: center; gap: 20px; flex: 1; min-width: 250px;">
            <div style="width: 80px; height: 80px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e2e8f0; flex-shrink: 0; padding: 10px;">
                @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
                @if($systemLogo)
                    <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                    <i class="fa-solid fa-calendar-check" style="font-size: 2rem; color: var(--corporate-red); opacity: 0.5;"></i>
                @endif
            </div>
            <div>
                <h3 style="margin: 0; color: #1e293b; font-size: 1.1rem; font-weight: 800; text-transform: uppercase;">{{ \App\Models\SystemSetting::get('system_name', 'EmCa Techonologies') }}</h3>
                <p style="margin: 5px 0 0; font-size: 0.85rem; color: #64748b;">Global Branding & Identity</p>
            </div>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline" style="min-width: 200px; gap: 8px;">
            <i class="fa-solid fa-gears"></i> MANAGE BRANDING
        </a>
    </div>

@endsection
