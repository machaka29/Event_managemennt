@extends('layouts.app')

@section('title', 'Admin Dashboard - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;">
        @if(auth()->user()->profile_image)
            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @else
            <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {{ strtoupper(auth()->user()->name[0]) }}
            </div>
        @endif
        <div>
            <h1 style="margin: 0;">System Administration</h1>
            <p style="color: var(--text-muted); margin: 0;">Overview of all platform activity.</p>
        </div>
    </div>

    <!-- Admin Stats -->
    <div class="grid grid-cols-3" style="margin-bottom: 3rem;">
        <div class="stat-card">
            <h4>Total Organizers</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ \App\Models\User::where('role', 'organizer')->count() }}</p>
        </div>
        <div class="stat-card">
            <h4>Global Events</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ \App\Models\Event::count() }}</p>
        </div>
        <div class="stat-card">
            <h4>Global Registrations</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ \App\Models\Registration::count() }}</p>
        </div>
    </div>

    <!-- System Settings -->
    <div class="card" style="margin-bottom: 3rem; border-top: 4px solid var(--corporate-red);">
        <h3 style="margin-bottom: 1.5rem;">System Branding</h3>
        <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data" style="display: flex; align-items: flex-end; gap: 2rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 0; flex: 1;">
                <label for="system_logo">Update Company Logo (Circular)</label>
                <input type="file" name="system_logo" id="system_logo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Logo</button>
        </form>
    </div>

    <div class="grid grid-cols-1" style="gap: 2rem;">
        <!-- All Events -->
        <div class="card" style="max-width: 100%;">
            <h3 style="margin-bottom: 1.5rem;">All Events</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                        <th style="padding: 1rem;">Event</th>
                        <th style="padding: 1rem;">Organizer</th>
                        <th style="padding: 1rem;">Date</th>
                        <th style="padding: 1rem;">Reg Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Event::latest()->get() as $event)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem; font-weight: bold;">{{ $event->title }}</td>
                            <td style="padding: 1rem;">{{ $event->organizer->name }}</td>
                            <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                            <td style="padding: 1rem;">{{ $event->registrations()->count() }}</td>
                            <td style="padding: 1rem; text-align: right;">
                                <a href="{{ route('events.show', $event) }}" style="color: var(--corporate-red); text-decoration: none;">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- All Organizers -->
        <div class="card" style="max-width: 100%;">
            <h3 style="margin-bottom: 1.5rem;">Organizers</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                        <th style="padding: 1rem;">Name</th>
                        <th style="padding: 1rem;">Email</th>
                        <th style="padding: 1rem;">Events Hosted</th>
                        <th style="padding: 1rem;">Joined At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\User::where('role', 'organizer')->latest()->get() as $user)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem; font-weight: bold;">{{ $user->name }}</td>
                            <td style="padding: 1rem;">{{ $user->email }}</td>
                            <td style="padding: 1rem;">{{ $user->events()->count() }}</td>
                            <td style="padding: 1rem;">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
