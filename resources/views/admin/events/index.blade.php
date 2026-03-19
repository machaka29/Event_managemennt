@extends('layouts.admin')

@section('title', 'All Events - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Global Events</h1>
        <p style="color: #666; font-size: 1rem;">View and manage all events created across the platform.</p>
    </div>
</div>

<div class="card" style="max-width: 100%; border: 1px solid var(--corporate-red); border-radius: 8px; overflow: hidden; padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--header-gradient); text-align: left; border-bottom: 2px solid var(--corporate-red);">
                <th style="padding: 15px 20px; color: var(--corporate-red);">Event Title</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Organizer</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Date & Time</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Location</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Registrations</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $event->title }}</td>
                    <td style="padding: 15px 20px;">{{ $event->organizer->name }}</td>
                    <td style="padding: 15px 20px;">
                        {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}<br>
                        <small style="color: #666;">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</small>
                    </td>
                    <td style="padding: 15px 20px;">{{ $event->location }}</td>
                    <td style="padding: 15px 20px;">{{ $event->registrations()->count() }}/{{ $event->capacity }}</td>
                    <td style="padding: 15px 20px; text-align: right;">
                        <a href="{{ route('events.public.show', $event->id) }}" target="_blank" style="color: var(--corporate-red); margin-right: 15px;"><i class="fa-solid fa-eye"></i></a>
                        <a href="#" style="color: #666;"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $events->links() }}
    </div>
</div>
@endsection
