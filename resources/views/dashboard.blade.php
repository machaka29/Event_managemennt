@isset(auth()->user()->role)
    @if(auth()->user()->role === 'admin')
        <script>window.location = "{{ route('admin.dashboard') }}";</script>
    @endif
@endisset

@extends('layouts.organizer')

@section('title', 'Organizer Dashboard - EmCa Techonologies')

@section('content')
<style>
    @media (max-width: 768px) {
        .hide-mobile { display: none !important; }
        .stats-grid { grid-template-columns: 1fr 1fr !important; gap: 10px !important; }
        .stats-grid .card { padding: 15px !important; }
        .stats-grid .card div { font-size: 1.5rem !important; }
    }
    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }
</style>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            @else
                <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; border: 3px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    {{ strtoupper(auth()->user()->name[0]) }}
                </div>
            @endif
            <div>
                <h1 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #1e293b;">Organizer Panel</h1>
                <p style="color: #64748b; margin: 4px 0 0; font-size: 0.9rem;">Welcome back, {{ auth()->user()->name }}</p>
            </div>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-primary" style="min-width: 180px;">
            <i class="fa-solid fa-plus-circle"></i> NEW EVENT
        </a>
    </div>

<!-- SECTION 3: STATISTICS CARDS -->
<div class="stats-grid">
    <!-- Card 1: Upcoming Events -->
    <div class="card" style="border-left: 4px solid var(--corporate-red);">
        <p style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.5px;">Upcoming Events</p>
        <div style="font-size: 2rem; font-weight: 800; color: #1e293b; line-height: 1;">{{ $upcomingEventsCount }}</div>
        <p style="color: var(--corporate-red); font-size: 0.8rem; margin: 10px 0 0; font-weight: 600;">{{ $myEventsCount }} active</p>
    </div>

    <!-- Card 2: Total Attendees -->
    <div class="card" style="border-left: 4px solid var(--corporate-red);">
        <p style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.5px;">Total Attendees</p>
        <div style="font-size: 2rem; font-weight: 800; color: #1e293b; line-height: 1;">{{ $totalAttendees }}</div>
        <p style="color: #059669; font-size: 0.8rem; margin: 10px 0 0; font-weight: 600;">+{{ $newAttendeesThisMonth }} this month</p>
    </div>

    <!-- Card 3: Tickets Issued -->
    <div class="card" style="border-left: 4px solid var(--corporate-red);">
        <p style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.5px;">Tickets Issued</p>
        <div style="font-size: 2rem; font-weight: 800; color: #1e293b; line-height: 1;">{{ $ticketsIssued }}</div>
        <p style="color: #64748b; font-size: 0.8rem; margin: 10px 0 0; font-weight: 600;">Verified entries</p>
    </div>

    <!-- Card 4: Attendance -->
    <div class="card" style="border-left: 4px solid #059669;">
        <p style="color: #64748b; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.5px;">Checked In</p>
        <div style="font-size: 2rem; font-weight: 800; color: #1e293b; line-height: 1;">{{ $totalAttendance }}</div>
        <p style="color: #059669; font-size: 0.8rem; margin: 10px 0 0; font-weight: 600;">{{ $totalAttendees > 0 ? round(($totalAttendance / $totalAttendees) * 100, 1) : 0 }}% rate</p>
    </div>

</div>

<!-- SECTION 4: MY MANAGED EVENTS (SEQUENTIAL SECTIONS) -->
<div style="margin-bottom: 100px;">
    <!-- UPCOMING EVENTS -->
    <div style="margin-bottom: 60px;">
        <div style="margin-bottom: 25px;">
            <h2 style="font-size: 1.1rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Upcoming Events ({{ $upcomingEvents->count() }})</h2>
            <div style="width: 40px; height: 4px; background: var(--corporate-red); margin-top: 8px; border-radius: 2px;"></div>
        </div>
        <div class="card" style="padding: 0; border: 1px solid #e2e8f0; overflow: hidden;">
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--corporate-red); color: white;">
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; text-align: left;">Event Name</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; text-align: left;" class="hide-mobile">Date</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; text-align: left;" class="hide-mobile">Location</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; text-align: center;">Reg</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingEvents as $event)
                            <tr style="border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                <td style="padding: 18px 20px; font-weight: 700; color: #1e293b;">{{ $event->title }}</td>
                                <td style="padding: 18px 20px; color: #475569; font-size: 0.85rem;" class="hide-mobile">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                <td style="padding: 18px 20px; color: #475569; font-size: 0.85rem;" class="hide-mobile">{{ $event->location }}</td>
                                <td style="padding: 18px 20px; color: #475569; font-size: 0.85rem; text-align: center;">{{ $event->registrations_count }}/{{ $event->capacity }}</td>
                                <td style="padding: 18px 20px; text-align: center;">
                                    <span style="color: #059669; font-weight: 900; font-size: 0.65rem; background: #ecfdf5; border: 1.5px solid #d1fae5; padding: 4px 12px; border-radius: 30px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.05); white-space: nowrap;">
                                        <span style="width: 6px; height: 6px; background: #059669; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite;"></span> ACTIVE
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding: 50px; text-align: center; color: #94a3b8;">No upcoming events found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PAST EVENTS -->
    <div style="margin-bottom: 60px;">
        <div style="margin-bottom: 25px;">
            <h2 style="font-size: 1.1rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Past Events ({{ $pastEvents->count() }})</h2>
            <div style="width: 40px; height: 4px; background: #64748b; margin-top: 8px; border-radius: 2px;"></div>
        </div>
        <div class="card" style="padding: 0; border: 1px solid #e2e8f0; overflow: hidden; opacity: 0.9;">
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--corporate-red); color: white;">
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Event Name</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Date</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Location</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pastEvents as $event)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 18px 20px; font-weight: 700; color: #1e293b;">{{ $event->title }}</td>
                                <td style="padding: 18px 20px; color: #475569; font-size: 0.9rem;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                <td style="padding: 18px 20px; color: #475569; font-size: 0.9rem;">{{ $event->location }}</td>
                                <td style="padding: 18px 20px;">
                                    <span style="color: #64748b; font-weight: 800; font-size: 0.75rem; background: #f1f5f9; padding: 5px 12px; border-radius: 20px; text-transform: uppercase;">
                                        <i class="fa-solid fa-check-double"></i> Completed
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding: 50px; text-align: center; color: #94a3b8;">No past events found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PENDING APPROVAL EVENTS -->
    @if($draftEvents->count() > 0)
    <div style="margin-bottom: 60px;">
        <div style="margin-bottom: 25px;">
            <h2 style="font-size: 1.1rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Pending Review ({{ $draftEvents->count() }})</h2>
            <div style="width: 40px; height: 4px; background: #92400e; margin-top: 8px; border-radius: 2px;"></div>
        </div>
        <div class="card" style="padding: 0; border: 1px solid #e2e8f0; overflow: hidden;">
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--corporate-red); color: white;">
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Event Name</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                            <th style="padding: 15px 20px; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($draftEvents as $event)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 18px 20px; font-weight: 700; color: #1e293b;">{{ $event->title }}</td>
                                <td style="padding: 18px 20px;">
                                    <span style="color: #92400e; font-weight: 800; font-size: 0.75rem; background: #fef3c7; padding: 5px 12px; border-radius: 20px; text-transform: uppercase;">
                                        <i class="fa-solid fa-clock-rotate-left"></i> PENDING
                                    </span>
                                </td>
                                <td style="padding: 18px 20px;">
                                    <a href="{{ route('events.edit', $event->id) }}" style="color: var(--corporate-red); font-weight: 700; text-decoration: none; font-size: 0.85rem;">Continue Editing</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    
    <div style="margin-top: 25px; text-align: right;">
        <a href="{{ route('organizer.events.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid transparent; transition: 0.3s;" onmouseover="this.style.borderBottomColor='var(--corporate-red)'">View All Events <i class="fa-solid fa-arrow-right-long"></i></a>
    </div>
</div>

<!-- SECTION 5: QUICK ACTIONS + EVENT INSIGHTS -->
<div class="responsive-grid" style="gap: 30px; margin-bottom: 50px;">
    <!-- Quick Actions -->
    <div class="card" style="padding: 0; overflow: hidden; border-top: 4px solid var(--corporate-red); display: flex; flex-direction: column;">
        <div style="padding: 25px 30px 15px; border-bottom: 1px solid #f1f5f9; background: #fafafa;">
            <h3 style="font-size: 1rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fa-solid fa-bolt" style="color: var(--corporate-red); margin-right: 8px;"></i> Quick Controls
            </h3>
        </div>
        <div style="padding: 20px 30px; display: flex; flex-direction: column; gap: 15px; flex: 1;">
            
            <a href="{{ route('events.create') }}" style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; background: #f8fafc; border-radius: 10px; text-decoration: none; border: 1px solid #f1f5f9; transition: all 0.3s;" onmouseover="this.style.background='var(--accent-soft-red)'; this.style.borderColor='var(--corporate-red)';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#f1f5f9';">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: white; display: flex; justify-content: center; align-items: center; color: var(--corporate-red); box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-calendar-plus" style="font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight: 800; color: #1e293b; font-size: 0.95rem;">Create New Event</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 3px;">Start a new registration listing</div>
                </div>
                <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #cbd5e1; font-size: 0.8rem;"></i>
            </a>

            <a href="{{ route('organizer.registrations.index') }}" style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; background: #f8fafc; border-radius: 10px; text-decoration: none; border: 1px solid #f1f5f9; transition: all 0.3s;" onmouseover="this.style.background='#f1fcf5'; this.style.borderColor='#16a34a';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#f1f5f9';">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: white; display: flex; justify-content: center; align-items: center; color: #16a34a; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-chart-line" style="font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight: 800; color: #1e293b; font-size: 0.95rem;">View Attendee Reports</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 3px;">Analytics & attendance data</div>
                </div>
                <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #cbd5e1; font-size: 0.8rem;"></i>
            </a>

            <a href="{{ route('profile.show') }}" style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; background: #f8fafc; border-radius: 10px; text-decoration: none; border: 1px solid #f1f5f9; transition: all 0.3s;" onmouseover="this.style.background='#eff6ff'; this.style.borderColor='#2563eb';" onmouseout="this.style.background='#f8fafc'; this.style.borderColor='#f1f5f9';">
                <div style="width: 42px; height: 42px; border-radius: 8px; background: white; display: flex; justify-content: center; align-items: center; color: #2563eb; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-user-gear" style="font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight: 800; color: #1e293b; font-size: 0.95rem;">Manage Panel Settings</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 3px;">Update your profile & security</div>
                </div>
                <i class="fa-solid fa-chevron-right" style="margin-left: auto; color: #cbd5e1; font-size: 0.8rem;"></i>
            </a>

        </div>
    </div>

    <!-- Recent Signups -->
    <div class="card" style="padding: 0; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; border-top: 4px solid var(--corporate-red);">
        <div style="padding: 25px 30px 15px; border-bottom: 1px solid #f1f5f9; background: #fafafa;">
            <h3 style="font-size: 1rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase;">
                <i class="fa-solid fa-user-plus" style="color: var(--corporate-red); margin-right: 8px;"></i> Recent Signups
            </h3>
        </div>
        <div style="padding: 20px 30px; display: flex; flex-direction: column; gap: 15px;">
            @forelse($recentRegistrations as $reg)
                <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent-soft-red); color: var(--corporate-red); display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        {{ $reg->attendee->full_name[0] }}
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 700; font-size: 0.9rem; color: #1e293b;">{{ $reg->attendee->full_name }}</p>
                        <p style="margin: 0; font-size: 0.75rem; color: #64748b;">{{ $reg->event->title }}</p>
                    </div>
                    <div style="font-size: 0.7rem; color: #94a3b8;">{{ $reg->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div style="text-align: center; padding: 20px; color: #94a3b8;">
                    No recent registrations found.
                </div>
            @endforelse
            @if($recentRegistrations->count() > 0)
                <a href="{{ route('organizer.attendees.index') }}" style="display: block; text-align: center; color: var(--corporate-red); text-decoration: none; font-weight: bold; font-size: 0.85rem; margin-top: 5px;">View All Members</a>
            @endif
        </div>
    </div>

    <!-- Event Insights -->
    <div class="card" style="padding: 0; overflow: hidden; border-top: 4px solid #1e293b; display: flex; flex-direction: column;">
        <div style="padding: 25px 30px 15px; border-bottom: 1px solid #f1f5f9; background: #fafafa;">
            <h3 style="font-size: 1rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fa-solid fa-chart-pie" style="color: #475569; margin-right: 8px;"></i> Panel Insights
            </h3>
        </div>
        <div style="padding: 25px 30px; display: flex; flex-direction: column; gap: 15px; flex: 1; background: white;">
            
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; gap: 15px;">
                     <div style="width: 32px; height: 32px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-users" style="font-size: 0.9rem;"></i></div>
                     <div style="font-weight: 700; color: #475569; font-size: 0.9rem;">Total Registered</div>
                </div>
                <div style="font-weight: 900; color: #1e293b; font-size: 1.15rem; background: #f8fafc; padding: 4px 12px; border-radius: 20px; border: 1px solid #e2e8f0;">
                    {{ $totalAttendees }}
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div style="display: flex; align-items: center; gap: 15px;">
                     <div style="width: 32px; height: 32px; border-radius: 50%; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-ticket" style="font-size: 0.9rem;"></i></div>
                     <div style="font-weight: 700; color: #475569; font-size: 0.9rem;">Tickets Distributed</div>
                </div>
                <div style="font-weight: 900; color: #1e293b; font-size: 1.15rem; background: #f8fafc; padding: 4px 12px; border-radius: 20px; border: 1px solid #e2e8f0;">
                    {{ $ticketsIssued }}
                </div>
            </div>

        </div>
    </div>
</div>

    </div>


@push('scripts')
<script>
    // Sequential layout applied, tab switching no longer needed.
</script>
@endpush
@endsection
