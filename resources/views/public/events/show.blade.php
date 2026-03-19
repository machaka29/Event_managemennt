@extends('layouts.app')

@section('title', 'Register for ' . $event->title . ' - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div class="grid grid-cols-3" style="align-items: flex-start; gap: 3rem;">
        <!-- Left: Event Details -->
        <div style="grid-column: span 2;">
            <div class="card" style="max-width: 100%; border-top: 4px solid var(--corporate-red);">
                <h1 style="margin-bottom: 0.5rem;">{{ $event->title }}</h1>
                <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                </p>
                
                <div style="margin-bottom: 2rem; display: flex; gap: 2rem; flex-wrap: wrap;">
                    <div class="stat-card" style="flex: 1; min-width: 150px;">
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Location</p>
                        <p style="font-weight: bold;">{{ $event->location }}</p>
                    </div>
                    <div class="stat-card" style="flex: 1; min-width: 150px;">
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Available Seats</p>
                        <p style="font-weight: bold;">{{ $event->capacity - $event->registrations()->count() }} / {{ $event->capacity }}</p>
                    </div>
                </div>

                <h3>About this Event</h3>
                <div style="margin-top: 1rem; white-space: pre-wrap; line-height: 1.8;">
                    {{ $event->description }}
                </div>

                @if($event->image_path)
                    <div style="margin-top: 2rem;">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; border-radius: 8px;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Registration Form -->
        <div class="card" style="max-width: 100%; position: sticky; top: 2rem;">
            <h3 style="margin-bottom: 0.5rem; text-align: center;">Enter your credentials to register</h3>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9rem;">Fill in the details below to secure your spot.</p>
            
            @if(session('error'))
                <div style="background: #FED7D7; color: #C53030; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('events.public.register', $event->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" required value="{{ old('full_name') }}">
                    @error('full_name') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                    @error('email') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" required value="{{ old('phone') }}">
                    @error('phone') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="organization">Organization (Optional)</label>
                    <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization') }}">
                    @error('organization') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-family: 'Century Gothic', sans-serif;">Confirm Registration</button>
                    <p style="text-align: center; font-size: 0.75rem; color: var(--text-muted); margin-top: 1rem; font-family: 'Century Gothic', sans-serif;">
                        By registering, you agree to receive event-related notifications.
                    </p>
                </div>
            </form>
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
