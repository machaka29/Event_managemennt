@extends('layouts.organizer')

@section('title', 'Edit Event - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('dashboard') }}" style="color: var(--corporate-red); text-decoration: none;">&larr; Back to Dashboard</a>
        <h1 style="margin-top: 1rem;">Edit Event: {{ $event->title }}</h1>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; border-top: 4px solid var(--corporate-red);">
        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                @error('title') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $event->description) }}</textarea>
                @error('description') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="date">Event Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $event->date) }}" required>
                    @error('date') <p class="text-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="time">Event Time</label>
                    <input type="time" name="time" id="time" class="form-control" value="{{ old('time', \Carbon\Carbon::parse($event->time)->format('H:i')) }}" required>
                    @error('time') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" required placeholder="e.g. Moshi, Kilimanjaro" list="tanzania-locations">
                    <datalist id="tanzania-locations">
                        <option value="Arusha">
                        <option value="Dar es Salaam">
                        <option value="Dodoma">
                        <option value="Geita">
                        <option value="Iringa">
                        <option value="Kagera">
                        <option value="Katavi">
                        <option value="Kigoma">
                        <option value="Kilimanjaro">
                        <option value="Lindi">
                        <option value="Manyara">
                        <option value="Mara">
                        <option value="Mbeya">
                        <option value="Morogoro">
                        <option value="Mtwara">
                        <option value="Mwanza">
                        <option value="Njombe">
                        <option value="Pemba North">
                        <option value="Pemba South">
                        <option value="Pwani">
                        <option value="Rukwa">
                        <option value="Ruvuma">
                        <option value="Shinyanga">
                        <option value="Simiyu">
                        <option value="Singida">
                        <option value="Songwe">
                        <option value="Tabora">
                        <option value="Tanga">
                        <option value="Zanzibar North">
                        <option value="Zanzibar South and Central">
                        <option value="Zanzibar West">
                        <option value="Moshi">
                        <option value="Kahama">
                        <option value="Songea">
                        <option value="Musoma">
                        <option value="Korogwe">
                        <option value="Kibaha">
                        <option value="Bariadi">
                        <option value="Mpanda">
                    </datalist>
                    @error('location') <p class="text-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity (Max Attendees)</label>
                    <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $event->capacity) }}" required min="1">
                    @error('capacity') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2">
                <div class="form-group">
                    <label for="reg_start_date">Registration Opens</label>
                    <input type="date" name="reg_start_date" id="reg_start_date" class="form-control" value="{{ old('reg_start_date', $event->reg_start_date) }}" required>
                    @error('reg_start_date') <p class="text-error">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="reg_end_date">Registration Closes</label>
                    <input type="date" name="reg_end_date" id="reg_end_date" class="form-control" value="{{ old('reg_end_date', $event->reg_end_date) }}" required>
                    @error('reg_end_date') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image">Event Image (Leave blank to keep current)</label>
                @if($event->image_path)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="Current Image" style="max-height: 100px; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control">
                @error('image') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Update Event</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="flex: 1; text-align: center;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
