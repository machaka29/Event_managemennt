@isset(auth()->user()->role)
    @if(auth()->user()->role === 'admin')
        <script>window.location = "{{ route('admin.dashboard') }}";</script>
    @endif
@endisset

@extends('layouts.organizer')

@section('title', 'Organizer Dashboard - EmCa Technologies')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @else
                <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: 'Century Gothic', sans-serif;">
                    {{ strtoupper(auth()->user()->name[0]) }}
                </div>
            @endif
            <div>
                <h1 style="margin: 0;">Dashboard</h1>
                <p style="color: var(--text-muted); margin: 0;">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-primary">+ Create New Event</a>
<!-- SECTION 2: WELCOME HEADER -->
<div style="margin-bottom: 40px;">
    <h1 style="font-size: 2rem; color: #333; margin: 0; font-weight: bold; position: relative; display: inline-block;">
        Organizer Dashboard
        <div style="width: 100px; height: 3px; background: var(--corporate-red); margin-top: 8px;"></div>
    </h1>
    <p style="font-size: 1.1rem; color: #666; margin-top: 15px;">Welcome, {{ auth()->user()->name }}! Here's your event overview</p>
</div>

<!-- SECTION 3: STATISTICS CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 50px;">
    <!-- Card 1: Upcoming Events -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <p style="color: #666; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; margin: 0 0 10px;">Upcoming Events</p>
        <div style="font-size: 2rem; font-weight: bold; color: var(--corporate-red); line-height: 1;">{{ $upcomingEventsCount }}</div>
        <p style="color: #666; font-size: 0.85rem; margin: 10px 0 0;">{{ $myEventsCount }} upcoming</p>
    </div>

    <!-- Card 2: Total Attendees -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <p style="color: #666; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; margin: 0 0 10px;">Total Attendees</p>
        <div style="font-size: 2rem; font-weight: bold; color: var(--corporate-red); line-height: 1;">{{ $totalAttendees }}</div>
        <p style="color: #666; font-size: 0.85rem; margin: 10px 0 0;">+{{ $newAttendeesThisMonth }} this month</p>
    </div>

    <!-- Card 3: Tickets Issued -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <p style="color: #666; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; margin: 0 0 10px;">Tickets Issued</p>
        <div style="font-size: 2rem; font-weight: bold; color: var(--corporate-red); line-height: 1;">{{ $ticketsIssued }}</div>
        <p style="color: #666; font-size: 0.85rem; margin: 10px 0 0;">+{{ $ticketsIssued }} total</p>
    </div>

    <!-- Card 4: Event Views -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <p style="color: #666; font-size: 0.9rem; font-weight: bold; text-transform: uppercase; margin: 0 0 10px;">Event Views</p>
        <div style="font-size: 2rem; font-weight: bold; color: var(--corporate-red); line-height: 1;">{{ $eventViews }}</div>
        <p style="color: #666; font-size: 0.85rem; margin: 10px 0 0;">{{ $viewsGrowth }}</p>
    </div>
</div>

<!-- SECTION 4: MY EVENTS TABLE WITH TABS -->
<div style="margin-bottom: 50px;">
    <div style="margin-bottom: 25px; position: relative; display: inline-block;">
        <h2 style="font-size: 1.5rem; color: #333; margin: 0; font-weight: bold; text-transform: uppercase;">My Events</h2>
        <div style="width: 80px; height: 3px; background: var(--corporate-red); margin-top: 5px;"></div>
    </div>

    <!-- Tabs -->
    <div style="display: flex; gap: 40px; border-bottom: 1px solid #ddd; margin-bottom: 20px; font-family: 'Century Gothic', sans-serif;">
        <div id="tab-upcoming" onclick="switchTab('upcoming')" style="padding: 10px 0; color: var(--corporate-red); font-weight: bold; border-bottom: 3px solid var(--corporate-red); cursor: pointer;">Upcoming ({{ $upcomingEvents->count() }})</div>
        <div id="tab-past" onclick="switchTab('past')" style="padding: 10px 0; color: #666; cursor: pointer;">Past ({{ $pastEvents->count() }})</div>
        <div id="tab-drafts" onclick="switchTab('drafts')" style="padding: 10px 0; color: #666; cursor: pointer;">Drafts ({{ $draftEvents->count() }})</div>
    </div>

    <!-- Tables Container -->
    <div class="card" style="padding: 0; border: 1px solid var(--corporate-red); overflow: hidden;">
        <!-- UPCOMING TABLE -->
        <div id="table-upcoming" style="display: block;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--header-gradient); text-align: left; border-bottom: 1px solid var(--corporate-red);">
                    <tr>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Event Name</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Date</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Location</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Capacity</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingEvents as $event)
                        <tr style="border-bottom: 1px dotted #eee;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px 20px; font-weight: bold; color: #333;">{{ $event->title }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ $event->location }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ $event->registrations_count }}/{{ $event->capacity }}</td>
                            <td style="padding: 15px 20px;"><span style="color: var(--corporate-red); font-weight: bold;">🟢 Upcoming</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="padding: 40px; text-align: center; color: #999;">No upcoming events found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAST TABLE -->
        <div id="table-past" style="display: none;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--header-gradient); text-align: left; border-bottom: 1px solid var(--corporate-red);">
                    <tr>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Event Name</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Date</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Location</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Capacity</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastEvents as $event)
                        <tr style="border-bottom: 1px dotted #eee;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px 20px; font-weight: bold; color: #333;">{{ $event->title }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ $event->location }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ $event->registrations_count }}/{{ $event->capacity }}</td>
                            <td style="padding: 15px 20px;"><span style="color: #666; font-weight: bold;">🔴 Past</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="padding: 40px; text-align: center; color: #999;">No past events found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- DRAFTS TABLE -->
        <div id="table-drafts" style="display: none;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--header-gradient); text-align: left; border-bottom: 1px solid var(--corporate-red);">
                    <tr>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Event Name</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Date</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Location</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Capacity</th>
                        <th style="padding: 15px 20px; color: var(--corporate-red); font-weight: bold;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($draftEvents as $event)
                        <tr style="border-bottom: 1px dotted #eee;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px 20px; font-weight: bold; color: #333;">{{ $event->title }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ $event->location }}</td>
                            <td style="padding: 15px 20px; color: #666;">{{ $event->registrations_count }}/{{ $event->capacity }}</td>
                            <td style="padding: 15px 20px;"><span style="color: #999; font-weight: bold;">⚪ Draft</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="padding: 40px; text-align: center; color: #999;">No draft events found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 20px; text-align: right;">
        <a href="{{ route('organizer.events.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold;">View All Events →</a>
    </div>
</div>

<!-- SECTION 5: QUICK ACTIONS + EVENT INSIGHTS -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 50px;">
    <!-- Quick Actions -->
    <div style="background: white; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="font-size: 1.1rem; color: #333; margin: 0 0 20px; font-weight: bold; text-transform: uppercase;">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="{{ route('events.create') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: 500;">• Create New Event</a>
            <a href="{{ route('organizer.registrations.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: 500;">• View Attendee Reports</a>
            <a href="{{ route('profile.show') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: 500;">• Manage Panel Settings</a>
        </div>
    </div>

    <!-- Event Insights -->
    <div style="background: white; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="font-size: 1.1rem; color: #333; margin: 0 0 20px; font-weight: bold; text-transform: uppercase;">Event Insights</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #666;">• Total Registered:</span>
                <span style="font-weight: bold; color: var(--corporate-red);">{{ $totalAttendees }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #666;">• Unique Page Views:</span>
                <span style="font-weight: bold; color: var(--corporate-red);">{{ $eventViews }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #666;">• Total Tickets Issued:</span>
                <span style="font-weight: bold; color: var(--corporate-red);">{{ $ticketsIssued }}</span>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 6: TIPS SECTION -->
<div>
    <h3 style="font-size: 1.1rem; color: #333; margin: 0 0 15px; font-weight: bold; text-transform: uppercase; position: relative; display: inline-block;">
        Tips
        <div style="width: 40px; height: 3px; background: var(--corporate-red); margin-top: 5px;"></div>
    </h3>
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <p style="font-weight: bold; margin: 0 0 15px; color: #333;">Tips to increase your event visibility</p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div style="color: #666; font-size: 0.95rem;">• Add eye-catching event images</div>
            <div style="color: #666; font-size: 0.95rem;">• Promote on social media</div>
            <div style="color: #666; font-size: 0.95rem;">• Share early bird discounts</div>
            <div style="color: #666; font-size: 0.95rem;">• Send reminders to attendees</div>
        </div>
    </div>
    
    <div style="margin-top: 3rem;">
        <a href="javascript:history.back()" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back
        </a>
    </div>
</div>

<script>
    function switchTab(tab) {
        // Reset all tabs
        document.getElementById('tab-upcoming').style.color = '#666';
        document.getElementById('tab-upcoming').style.borderBottom = 'none';
        document.getElementById('tab-upcoming').style.fontWeight = 'normal';
        
        document.getElementById('tab-past').style.color = '#666';
        document.getElementById('tab-past').style.borderBottom = 'none';
        document.getElementById('tab-past').style.fontWeight = 'normal';
        
        document.getElementById('tab-drafts').style.color = '#666';
        document.getElementById('tab-drafts').style.borderBottom = 'none';
        document.getElementById('tab-drafts').style.fontWeight = 'normal';

        // Hide all tables
        document.getElementById('table-upcoming').style.display = 'none';
        document.getElementById('table-past').style.display = 'none';
        document.getElementById('table-drafts').style.display = 'none';

        // Set active tab
        const activeTab = document.getElementById('tab-' + tab);
        activeTab.style.color = 'var(--corporate-red)';
        activeTab.style.borderBottom = '3px solid var(--corporate-red)';
        activeTab.style.fontWeight = 'bold';

        // Show active table
        document.getElementById('table-' + tab).style.display = 'block';
    }
</script>
@endsection

