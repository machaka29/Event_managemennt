@extends('layouts.admin')

@section('title', $event->title . ' - Admin Panel')

@section('content')
<style>
    .manage-event-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: flex-start;
    }
    @media (max-width: 992px) {
        .manage-event-container {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .event-header {
            padding: 15px !important;
        }
        .event-header > div {
            width: 100%;
        }
    }
</style>
<div style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <h1 style="margin: 0; font-size: 1.6rem; font-weight: 800; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px;">{{ $event->title }}</h1>
            <div style="width: 50px; height: 4px; background: var(--corporate-red); margin-top: 10px; border-radius: 2px;"></div>
            <p style="color: #64748b; margin-top: 12px; font-size: 0.9rem; font-weight: 600;">
                <i class="fa-solid fa-user-tie" style="color: var(--corporate-red); margin-right: 8px;"></i> Organized by: <span style="color: #1e293b;">{{ $event->organizer->name }}</span>
            </p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-outline" style="border: 2px solid #e2e8f0; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.3s; background: white;" onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.color='var(--corporate-red)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#475569';">
                <i class="fa-solid fa-pencil"></i> EDIT EVENT
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 8px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.3s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
                <i class="fa-solid fa-arrow-left"></i> BACK TO LIST
            </a>
        </div>
    </div>
</div>

<div class="manage-event-container">
    <!-- LEFT COLUMN: EVENT INFO & ATTENDEES -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        <!-- EVENT OVERVIEW -->
        <div class="card" style="padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; background: white;">
            <h3 style="margin: 0 0 20px; font-size: 1.1rem; color: #1e293b; font-weight: 800; text-transform: uppercase; border-bottom: 2px solid #f8fafc; padding-bottom: 12px;">Event Overview</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #f1f5f9;">
                    <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase;">Date & Time</div>
                    <div style="font-weight: 700; color: #1e293b; margin-top: 5px;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
                </div>
                <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #f1f5f9;">
                    <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 800; text-transform: uppercase;">Location</div>
                    <div style="font-weight: 700; color: #1e293b; margin-top: 5px;">{{ $event->location }}</div>
                </div>
            </div>
            <h4 style="font-size: 0.9rem; font-weight: 800; color: #475569; margin-bottom: 10px;">Description</h4>
            <p style="white-space: pre-wrap; color: #64748b; line-height: 1.6; font-size: 0.95rem;">{{ $event->description }}</p>
        </div>

        <!-- ATTENDEE LIST -->
        <div class="card" style="padding: 0; border-radius: 12px; border: 1px solid #e2e8f0; background: white; overflow: hidden;">
            <div style="padding: 20px 30px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Attendee Registry</h3>
                <div style="font-size: 0.8rem; font-weight: 700; color: var(--corporate-red); background: var(--accent-soft-red); padding: 5px 12px; border-radius: 20px;">
                    {{ $event->registrations->count() }} Registered
                </div>
            </div>

            @if($event->registrations->count() > 0)
                <div class="table-responsive" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8fafc; color: #64748b; border-bottom: 1px solid #f1f5f9;">
                                <th style="padding: 15px 30px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Member</th>
                                <th style="padding: 15px 30px; text-align: left; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Ticket ID</th>
                                <th style="padding: 15px 30px; text-align: center; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Status</th>
                                <th style="padding: 15px 30px; text-align: right; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->registrations as $reg)
                                <tr style="border-bottom: 1px solid #f8f9fa;">
                                    <td style="padding: 15px 30px;">
                                        <div style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">{{ $reg->attendee->full_name }}</div>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">{{ $reg->attendee->email }}</div>
                                    </td>
                                    <td style="padding: 15px 30px;">
                                        <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; color: var(--corporate-red); font-weight: bold; font-size: 0.85rem;">{{ $reg->ticket_id }}</code>
                                    </td>
                                    <td style="padding: 15px 30px; text-align: center;">
                                        @if($reg->status === 'Checked-Out')
                                            <span style="background: #e2e8f0; color: #475569; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-door-closed"></i> Checked Out
                                            </span>
                                            @if($reg->checked_out_at)
                                                <div style="font-size: 0.65rem; color: #94a3b8; margin-top: 4px; font-weight: 700;">{{ $reg->checked_out_at->format('h:i A') }}</div>
                                            @endif
                                        @elseif($reg->attended)
                                            <span style="background: #ecfdf5; color: #059669; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-check-double"></i> Checked In
                                            </span>
                                            @if($reg->checked_in_at)
                                                <div style="font-size: 0.65rem; color: #059669; margin-top: 4px; font-weight: 700;">{{ $reg->checked_in_at->format('h:i A') }}</div>
                                            @endif
                                        @else
                                            <span style="background: #f1f5f9; color: #64748b; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px 30px; text-align: right;">
                                        <a href="{{ route('admin.attendees.edit', $reg->attendee->id) }}" style="color: #64748b; text-decoration: none; font-size: 0.85rem; font-weight: bold;" onmouseover="this.style.color='var(--corporate-red)'" onmouseout="this.style.color='#64748b'">Manage</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 60px 30px; text-align: center;">
                    <i class="fa-solid fa-users-slash" style="font-size: 3rem; color: #f1f5f9; margin-bottom: 15px;"></i>
                    <p style="color: #94a3b8; font-weight: 600;">No members have registered for this event yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- RIGHT COLUMN: STATS & ACTIONS -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        <!-- CAPACITY STATS -->
        <div class="card" style="padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; background: white; text-align: center;">
            <h3 style="margin: 0 0 20px; font-size: 0.9rem; color: #475569; font-weight: 800; text-transform: uppercase;">Capacity Utilization</h3>
            <div style="font-size: 2.5rem; font-weight: 900; color: #1e293b; margin-bottom: 5px;">{{ $event->registrations->count() }}</div>
            <div style="color: #94a3b8; font-weight: 700; font-size: 0.85rem; margin-bottom: 20px;">Out of {{ $event->capacity }} Slots</div>
            
            <div style="width: 100%; height: 10px; background: #f1f5f9; border-radius: 5px; overflow: hidden; margin-bottom: 10px;">
                <div style="width: {{ min(($event->registrations->count() / $event->capacity) * 100, 100) }}%; height: 100%; background: var(--corporate-red); transition: width 1s ease-in-out;"></div>
            </div>
            <div style="font-size: 0.8rem; font-weight: 800; color: var(--corporate-red);">{{ round(min(($event->registrations->count() / $event->capacity) * 100, 100), 1) }}% FILLED</div>
        </div>

        <!-- PUBLIC LINK -->
        <div class="card" style="padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; background: #fdfdfd;">
            <h4 style="margin: 0 0 15px; font-size: 0.85rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Registration Link</h4>
            <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                <input type="text" id="publicLink" value="{{ route('events.public.show', $event->id) }}" readonly 
                    style="flex: 1; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.75rem; background: #fff; cursor: default;">
                <button onclick="copyToClipboard()" style="padding: 10px 15px; background: #1e293b; color: white; border: none; border-radius: 6px; cursor: pointer; transition: all 0.2s;">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>
            <p style="margin: 0; font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Share this link publicly for automated member self-registration.</p>
        </div>

        <script>
            function copyToClipboard() {
                var copyText = document.getElementById("publicLink");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);
                alert("Public link copied to clipboard!");
            }
        </script>
    </div>
</div>
@endsection
