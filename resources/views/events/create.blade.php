@extends('layouts.app')

@section('title', 'Create Event - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('dashboard') }}" style="color: var(--corporate-red); text-decoration: none;">&larr; Back to Dashboard</a>
        <h1 style="margin-top: 1rem;">Create New Event</h1>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; border-top: 4px solid var(--corporate-red);">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="date">Event Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
                    @error('date') <p class="text-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="time">Event Time</label>
                    <input type="time" name="time" id="time" class="form-control" value="{{ old('time') }}" required>
                    @error('time') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required placeholder="Venue name or city">
                    @error('location') <p class="text-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity (Max Attendees)</label>
                    <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity') }}" required min="1">
                    @error('capacity') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="reg_start_date">Registration Opens</label>
                    <input type="date" name="reg_start_date" id="reg_start_date" class="form-control" value="{{ old('reg_start_date') }}" required>
                    @error('reg_start_date') <p class="text-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="reg_end_date">Registration Closes</label>
                    <input type="date" name="reg_end_date" id="reg_end_date" class="form-control" value="{{ old('reg_end_date') }}" required>
                    @error('reg_end_date') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image">Event Image (Optional)</label>
                <input type="file" name="image" id="image" class="form-control">
                @error('image') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Create Event</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="flex: 1; text-align: center;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
