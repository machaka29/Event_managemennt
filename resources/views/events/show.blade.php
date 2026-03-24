@extends('layouts.organizer')

@section('title', $event->title . ' - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="flex: 1; min-width: 250px;">
            <h1 style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #333;">{{ $event->title }}</h1>
            <p style="color: var(--text-muted); margin-top: 5px; font-size: 0.95rem;">
                <i class="fa-solid fa-calendar-day" style="color: var(--corporate-red); margin-right: 5px;"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                <br>
                <i class="fa-solid fa-location-dot" style="color: var(--corporate-red); margin-right: 5px;"></i> {{ $event->location }}
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap; flex: 1; min-width: 200px; justify-content: flex-end;">
            <a href="{{ route('events.edit', $event) }}" class="btn btn-outline" style="flex: 1; text-align: center; min-width: 120px;">Edit Event</a>
            <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?')" style="flex: 1; min-width: 120px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline" style="width: 100%; color: #666; border-color: #ddd;">Delete</button>
            </form>
        </div>
    </div>

    <div class="responsive-grid" style="grid-template-columns: 2fr 1fr; align-items: flex-start; gap: 2rem;">
        <!-- Left: Details -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <div class="card" style="max-width: 100%;">
                <h3 style="margin-bottom: 1rem;">About this Event</h3>
                <p style="white-space: pre-wrap;">{{ $event->description }}</p>
                
                @if($event->image_path)
                    <div style="margin-top: 2rem;">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; border-radius: 8px;">
                    </div>
                @endif
            </div>

            <!-- Attendee List -->
            <div class="card" style="max-width: 100%; border-top: 4px solid var(--corporate-red);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                    <h3 style="margin: 0;">Attendees</h3>
                    <a href="{{ route('events.export', $event) }}" class="btn btn-outline btn-sm" style="font-size: 0.8rem; padding: 8px 15px;">
                        <i class="fa-solid fa-file-export"></i> Export CSV
                    </a>
                </div>

                @if($event->registrations()->count() > 0)
                    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                            <thead>
                                <tr style="background: var(--corporate-red); color: white;">
                                    <th style="padding: 1rem; font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">Name</th>
                                    <th style="padding: 1rem; font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">Ticket ID</th>
                                    <th style="padding: 1rem; font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">Status</th>
                                    <th style="padding: 1rem; text-align: right; font-size: 0.8rem; text-transform: uppercase; font-weight: 800;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->registrations as $reg)
                                    <tr style="border-bottom: 1px solid var(--border-color); transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='white'">
                                        <td style="padding: 1rem;">
                                            <div style="font-weight: bold; color: #333;">{{ $reg->attendee->full_name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $reg->attendee->email }}</div>
                                        </td>
                                        <td style="padding: 1rem;"><code style="background: #f4f4f4; padding: 3px 6px; border-radius: 4px;">{{ $reg->ticket_id }}</code></td>
                                        <td style="padding: 1rem;">
                                            <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold;
                                                background: {{ $reg->status == 'Attended' ? '#e6f4ea' : ($reg->status == 'Absent' ? '#fce8e6' : '#f1f3f4') }};
                                                color: {{ $reg->status == 'Attended' ? '#1e8e3e' : ($reg->status == 'Absent' ? '#d93025' : '#5f6368') }};">
                                                {{ $reg->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem; text-align: right;">
                                            <form action="{{ route('registrations.attendance', $reg) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                @if($reg->status !== 'Attended')
                                                    <input type="hidden" name="status" value="Attended">
                                                    <button type="submit" class="btn btn-outline" style="font-size: 0.7rem; padding: 5px 10px; border-color: #1e8e3e; color: #1e8e3e;">Present</button>
                                                @else
                                                    <input type="hidden" name="status" value="Absent">
                                                    <button type="submit" class="btn btn-outline" style="font-size: 0.7rem; padding: 5px 10px; border-color: #d93025; color: #d93025;">Absent</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="text-align: center; color: var(--text-muted); padding: 2rem;">No registrations yet.</p>
                @endif
            </div>
        </div>

        <!-- Right: Stats & Info -->
        <div class="grid grid-cols-1" style="gap: 1.5rem;">
            <div class="stat-card">
                <h4>Capacity</h4>
                <p style="font-size: 1.5rem; font-weight: bold;">{{ $event->registrations()->count() }} / {{ $event->capacity }}</p>
                <div style="width: 100%; height: 8px; background: white; border-radius: 4px; margin-top: 0.5rem; overflow: hidden;">
                <div style="width: {{ ($event->registrations()->count() / $event->capacity) * 100 }}%; height: 100%; background: var(--corporate-red); font-family: 'Century Gothic', sans-serif;"></div>
                </div>
            </div>

            <div class="card" style="max-width: 100%;">
                <h4 style="margin-bottom: 1rem; color: var(--corporate-red);">Registration Window</h4>
                <p style="font-size: 0.9rem; margin-bottom: 0.5rem;"><strong>Opens:</strong> {{ \Carbon\Carbon::parse($event->reg_start_date)->format('M d, Y') }}</p>
                <p style="font-size: 0.9rem;"><strong>Closes:</strong> {{ \Carbon\Carbon::parse($event->reg_end_date)->format('M d, Y') }}</p>
                
                <div style="margin-top: 1.5rem; padding: 0.5rem; background: var(--accent-soft-red); border-radius: 4px; text-align: center; font-size: 0.8rem;">
                    @php
                        $now = now();
                        $start = \Carbon\Carbon::parse($event->reg_start_date);
                        $end = \Carbon\Carbon::parse($event->reg_end_date);
                    @endphp
                    @if($now->lessThan($start))
                        <span style="color: #E53E3E;">Upcoming</span>
                    @elseif($now->greaterThan($end))
                        <span style="color: grey;">Closed</span>
                    @else
                        <span style="color: #38A169;">Open</span>
                    @endif
                </div>
            </div>

            <div class="card" style="max-width: 100%;">
                <h4 style="margin-bottom: 1rem; color: var(--corporate-red);">Public Link</h4>
                <input type="text" readonly value="{{ route('events.public.show', $event->id) }}" class="form-control" style="font-size: 0.8rem; margin-bottom: 0.5rem;">
                <p style="font-size: 0.75rem; color: var(--text-muted);">Share this link with attendees for registration.</p>
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
@endsection
