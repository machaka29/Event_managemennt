@extends('layouts.app')

@section('title', 'Dashboard - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            @if(auth()->user()->profile_image)
                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @else
                <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    {{ strtoupper(auth()->user()->name[0]) }}
                </div>
            @endif
            <div>
                <h1 style="margin: 0;">Dashboard</h1>
                <p style="color: var(--text-muted); margin: 0;">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-primary">+ Create New Event</a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-3" style="margin-bottom: 3rem;">
        <div class="stat-card">
            <h4 style="margin-bottom: 0.5rem;">Total Events</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ $events->count() }}</p>
        </div>
        <div class="stat-card">
            <h4 style="margin-bottom: 0.5rem;">Total Registrations</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ $events->sum(fn($e) => $e->registrations->count()) }}</p>
        </div>
        <div class="stat-card">
            <h4 style="margin-bottom: 0.5rem;">Ongoing Events</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ $events->filter(fn($e) => \Carbon\Carbon::parse($e->date)->isFuture())->count() }}</p>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="card" style="max-width: 100%; border-color: var(--corporate-red); border-width: 2px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Your Events</h3>
            @if(session('success'))
                <span style="color: green; font-weight: bold;">{{ session('success') }}</span>
            @endif
        </div>
        
        @if($events->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                        <th style="padding: 1rem;">Event Name</th>
                        <th style="padding: 1rem;">Date</th>
                        <th style="padding: 1rem;">Capacity</th>
                        <th style="padding: 1rem;">Registrations</th>
                        <th style="padding: 1rem; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem; font-weight: bold;">{{ $event->title }}</td>
                            <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                            <td style="padding: 1rem;">{{ $event->capacity }}</td>
                            <td style="padding: 1rem;">{{ $event->registrations->count() }}</td>
                            <td style="padding: 1rem; text-align: right;">
                                <a href="{{ route('events.show', $event) }}" style="color: var(--corporate-red); text-decoration: none; margin-left: 1rem;">View</a>
                                <a href="{{ route('events.edit', $event) }}" style="color: var(--text-muted); text-decoration: none; margin-left: 1rem;">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 3rem;">
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">You haven't created any events yet.</p>
                <a href="{{ route('events.create') }}" class="btn btn-outline">Create Your First Event</a>
            </div>
        @endif
    </div>
</div>
@endsection
