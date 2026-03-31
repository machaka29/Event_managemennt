@extends('layouts.admin')

@section('title', 'Search Results - Admin Panel')

@section('content')
<div style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <h1 style="margin: 0; font-size: 1.4rem; font-weight: 800; color: #1e293b; text-transform: uppercase;">Search Results for: <span style="color: var(--corporate-red);">"{{ $query }}"</span></h1>
    <div style="width: 50px; height: 4px; background: var(--corporate-red); margin-top: 10px; border-radius: 2px;"></div>
</div>

<div style="display: flex; flex-direction: column; gap: 40px;">

    @php $hasResults = ($events->count() > 0 || $organizers->count() > 0 || $attendees->count() > 0); @endphp

    @if(!$hasResults)
        <div style="background: white; padding: 80px 30px; border-radius: 12px; border: 1px solid #e2e8f0; text-align: center; color: #64748b; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <i class="fa-solid fa-magnifying-glass-minus" style="font-size: 3.5rem; color: #f1f5f9; margin-bottom: 20px;"></i>
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #1e293b;">No matches found for "{{ $query }}"</h2>
            <p style="margin-top: 10px; color: #94a3b8; font-weight: 600;">Try searching for a specific name, event, or use keywords like "events" or "members".</p>
            <a href="{{ route('admin.dashboard') }}" style="display: inline-block; margin-top: 25px; padding: 12px 30px; background: var(--corporate-red); color: white; text-decoration: none; border-radius: 8px; font-weight: 800; font-size: 0.85rem; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">BACK TO DASHBOARD</a>
        </div>
    @endif

    <!-- EVENTS RESULTS -->
    @if($events->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 25px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <h3 style="margin: 0; font-size: 1rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Matching Events ({{ $events->count() }})</h3>
                <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
            </div>

            @foreach($events as $event)
                <div class="event-search-card" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column;">
                    <!-- Card Header -->
                    <div style="padding: 20px 30px; background: #fafafa; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <div>
                            <h4 style="margin: 0; font-size: 1.25rem; font-weight: 900; color: #1e293b;">{{ $event->title }}</h4>
                            <p style="margin: 5px 0 0; font-size: 0.8rem; color: #64748b; font-weight: 600;">
                                <i class="fa-solid fa-user-tie" style="color: var(--corporate-red); margin-right: 5px;"></i> Organized by: <span style="color: #1e293b;">{{ $event->organizer->name }}</span>
                            </p>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.events.show', $event->id) }}" style="background: var(--corporate-red); color: white; padding: 8px 16px; border-radius: 8px; font-weight: 800; text-decoration: none; font-size: 0.75rem; text-transform: uppercase; transition: all 0.3s; box-shadow: 0 4px 10px rgba(148,0,0,0.15);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                <i class="fa-solid fa-gears"></i> Manage Event
                            </a>
                            <a href="{{ route('admin.events.edit', $event->id) }}" style="background: white; color: #475569; padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 800; text-decoration: none; font-size: 0.75rem; text-transform: uppercase; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                                <i class="fa-solid fa-pencil"></i> Edit
                            </a>
                        </div>
                    </div>

                    <!-- Card Body Grid -->
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; padding: 30px;" class="event-search-grid">
                        <!-- Left: Info & Attendees -->
                        <div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                                <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #f1f5f9;">
                                    <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 800; text-transform: uppercase;">Date & Location</div>
                                    <div style="font-weight: 700; color: #1e293b; margin-top: 4px; font-size: 0.85rem;">
                                        <i class="fa-solid fa-calendar-day" style="color: var(--corporate-red); margin-right: 5px;"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}<br>
                                        <i class="fa-solid fa-location-dot" style="color: var(--corporate-red); margin-right: 5px; margin-top: 5px;"></i> {{ $event->location }}
                                    </div>
                                </div>
                                <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #f1f5f9;">
                                    <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 800; text-transform: uppercase;">Capacity Usage</div>
                                    <div style="font-weight: 900; color: #1e293b; margin-top: 4px; font-size: 1.1rem;">{{ $event->registrations->count() }} / {{ $event->capacity }}</div>
                                    <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; margin-top: 8px;">
                                        <div style="width: {{ min(($event->registrations->count() / $event->capacity) * 100, 100) }}%; height: 100%; background: var(--corporate-red);"></div>
                                    </div>
                                </div>
                            </div>

                            <h5 style="margin: 0 0 12px; font-size: 0.8rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Attendee Registry Snapshot</h5>
                            @if($event->registrations->count() > 0)
                                <div style="border: 1px solid #f1f5f9; border-radius: 10px; overflow: hidden;">
                                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                                        <thead>
                                            <tr style="background: #f8fafc; color: #64748b; border-bottom: 1px solid #f1f5f9;">
                                                <th style="padding: 10px 15px; text-align: left; font-weight: 800;">Member</th>
                                                <th style="padding: 10px 15px; text-align: center; font-weight: 800;">Ticket</th>
                                                <th style="padding: 10px 15px; text-align: right; font-weight: 800;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($event->registrations->take(5) as $reg)
                                                <tr style="border-bottom: 1px solid #f8fafc;">
                                                    <td style="padding: 10px 15px;">
                                                        <span style="font-weight: 700; color: #1e293b;">{{ $reg->attendee->full_name }}</span>
                                                    </td>
                                                    <td style="padding: 10px 15px; text-align: center;">
                                                        <code style="color: var(--corporate-red); font-weight: 800;">{{ $reg->ticket_id }}</code>
                                                    </td>
                                                    <td style="padding: 10px 15px; text-align: right;">
                                                        @if($reg->attended)
                                                            <span style="color: #059669; font-weight: 800; font-size: 0.7rem;">CHECKED-IN</span>
                                                        @else
                                                            <span style="color: #94a3b8; font-weight: 800; font-size: 0.7rem;">PENDING</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($event->registrations->count() > 5)
                                        <div style="padding: 10px; text-align: center; background: #fafafa; font-size: 0.75rem;">
                                            <a href="{{ route('admin.events.show', $event->id) }}" style="color: #64748b; font-weight: 800; text-decoration: none;">+ View all {{ $event->registrations->count() }} registrations</a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div style="padding: 20px; text-align: center; background: #f8fafc; border-radius: 10px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">No registrations yet.</div>
                            @endif
                        </div>

                        <!-- Right: Description & Share -->
                        <div style="background: #FFF5F5; padding: 25px; border-radius: 12px; border: 1px solid #f9dcdc;">
                            <h5 style="margin: 0 0 10px; font-size: 0.8rem; color: var(--corporate-red); font-weight: 800; text-transform: uppercase;">Registration Details</h5>
                            <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 20px;">{{ \Illuminate\Support\Str::limit($event->description, 120) }}</p>
                            
                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <div style="display: flex; gap: 8px;">
                                    <input type="text" id="link-{{ $event->id }}" value="{{ route('events.public.show', $event->slug) }}" readonly 
                                        style="flex: 1; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.7rem; background: #fff;">
                                    <button onclick="copyEventLink('{{ $event->id }}')" id="copy-btn-{{ $event->id }}" style="padding: 8px 12px; background: #1e293b; color: white; border: none; border-radius: 6px; cursor: pointer; transition: 0.2s;">
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                </div>
                                <a href="https://wa.me/?text={{ urlencode('Register for ' . $event->title . ': ' . route('events.public.show', $event->slug)) }}" 
                                   target="_blank"
                                   style="background: #25D366; color: white; padding: 10px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 800; font-size: 0.8rem; transition: 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i> Share on WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- ORGANIZERS RESULTS -->
    @if($organizers->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <h3 style="margin: 0; font-size: 1rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Matching Organizers ({{ $organizers->count() }})</h3>
                <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
            </div>
            
            <div class="card" style="padding: 0; border-radius: 12px; border: 1px solid #e2e8f0; background: white; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; color: #64748b; border-bottom: 2px solid #f1f5f9;">
                                <th style="padding: 15px 25px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Name & Email</th>
                                <th style="padding: 15px 25px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Organization</th>
                                <th style="padding: 15px 25px; text-align: right; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organizers as $org)
                                <tr style="border-bottom: 1px solid #f8f9fa;">
                                    <td style="padding: 15px 25px;">
                                        <div style="font-weight: 700; color: #1e293b;">{{ $org->name }}</div>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">{{ $org->email }}</div>
                                    </td>
                                    <td style="padding: 15px 25px; font-weight: 600; color: #475569;">{{ $org->organization }}</td>
                                    <td style="padding: 15px 25px; text-align: right;">
                                        <a href="{{ route('admin.organizers.edit', $org->id) }}" style="color: var(--corporate-red); font-weight: 800; text-decoration: none; font-size: 0.85rem;">Edit Profile</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- ATTENDEES RESULTS -->
    @if($attendees->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <h3 style="margin: 0; font-size: 1rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Matching Members ({{ $attendees->count() }})</h3>
                <div style="flex: 1; height: 1px; background: #e2e8f0;"></div>
            </div>

            <div class="card" style="padding: 0; border-radius: 12px; border: 1px solid #e2e8f0; background: white; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; color: #64748b; border-bottom: 2px solid #f1f5f9;">
                                <th style="padding: 15px 25px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Member Details</th>
                                <th style="padding: 15px 25px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Organization</th>
                                <th style="padding: 15px 25px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Contact</th>
                                <th style="padding: 15px 25px; text-align: right; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendees as $att)
                                <tr style="border-bottom: 1px solid #f8f9fa;">
                                    <td style="padding: 15px 25px;">
                                        <div style="font-weight: 700; color: #1e293b;">{{ $att->full_name }}</div>
                                        <div style="font-size: 0.7rem; color: var(--corporate-red); font-weight: 800;">CODE: {{ $att->access_code }}</div>
                                    </td>
                                    <td style="padding: 15px 25px; font-weight: 600; color: #475569;">{{ $att->organization }}</td>
                                    <td style="padding: 15px 25px;">
                                        <div style="font-size: 0.85rem; color: #1e293b;">{{ $att->phone }}</div>
                                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $att->email }}</div>
                                    </td>
                                    <td style="padding: 15px 25px; text-align: right;">
                                        <a href="{{ route('admin.attendees.edit', $att->id) }}" style="color: var(--corporate-red); font-weight: 800; text-decoration: none; font-size: 0.85rem;">Manage Member</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>

<style>
    @media (max-width: 992px) {
        .event-search-grid { grid-template-columns: 1fr !important; gap: 20px !important; padding: 20px !important; }
    }
</style>

<script>
    function copyEventLink(id) {
        const copyText = document.getElementById("link-" + id);
        const btn = document.getElementById("copy-btn-" + id);
        const originalHtml = btn.innerHTML;
        
        navigator.clipboard.writeText(copyText.value).then(() => {
            btn.innerHTML = '<i class="fa-solid fa-check"></i>';
            btn.style.background = '#059669';
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.style.background = '#1e293b';
            }, 2000);
        });
    }
</script>
@endsection
