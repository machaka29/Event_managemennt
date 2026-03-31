@extends('layouts.admin')

@section('title', 'Edit Event - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; border-bottom: 2px solid var(--corporate-red); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="color: var(--corporate-red); font-size: 1.8rem; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Edit Event</h1>
        <p style="color: #666; margin-top: 5px;">Update an existing event's details.</p>
    </div>
    <a href="{{ route('admin.events.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-arrow-left"></i> BACK TO LIST
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; border-top: 4px solid var(--corporate-red); padding: 40px;">
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="title">Event Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $event->title) }}" required>
            @error('title') <p class="text-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="category_id">Event Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $event->description) }}</textarea>
            @error('description') <p class="text-error">{{ $message }}</p> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
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
            <div class="form-group">
                <label for="location">City / Region</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $event->location) }}" required>
                @error('location') <p class="text-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="venue">Venue Name</label>
                <input type="text" name="venue" id="venue" class="form-control" value="{{ old('venue', $event->venue) }}">
                @error('venue') <p class="text-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" name="capacity" id="capacity" class="form-control" value="{{ old('capacity', $event->capacity) }}" required min="1">
                @error('capacity') <p class="text-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="target_audience">Target Audience</label>
                <input type="text" name="target_audience" id="target_audience" class="form-control" value="{{ old('target_audience', $event->target_audience) }}">
                @error('target_audience') <p class="text-error">{{ $message }}</p> @enderror
            </div>
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
            <div class="form-group" style="padding: 20px; background: #fff5f5; border-radius: 8px; border: 1px solid #f9dcdc;">
                <label for="gate_password" style="color: var(--corporate-red); font-weight: 800; font-size: 0.85rem; text-transform: uppercase;">Gate Security Password</label>
                <div style="position: relative; margin-top: 10px;">
                    <input type="password" name="gate_password" id="gate_password" class="form-control" value="{{ old('gate_password', $event->gate_password) }}" required placeholder="PIN or Password for gate security">
                    <button type="button" onclick="toggleGatePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #666;">
                        <i class="fa-solid fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                <p style="margin-top: 8px; font-size: 0.75rem; color: #64748b; font-weight: 600;">
                    <i class="fa-solid fa-shield-halved"></i> Walinzi mlangoni watatumia nenosiri hili ili kuruhusu Check-In/Out.
                </p>
                @error('gate_password') <p class="text-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <script>
            function toggleGatePassword() {
                const passInput = document.getElementById('gate_password');
                const toggleIcon = document.getElementById('toggleIcon');
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passInput.type = 'password';
                    toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>

        <div style="border-top: 1px solid #eee; padding-top: 30px; display: flex; justify-content: flex-end; gap: 15px;">
            <a href="{{ route('admin.events.index') }}" class="btn" style="background: #f5f5f5; color: #666; border: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; text-decoration: none;">CANCEL</a>
            <button type="submit" class="btn btn-primary" style="padding: 12px 40px; border-radius: 6px; font-weight: bold; border: none; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-save"></i> UPDATE EVENT
            </button>
        </div>
    </form>
</div>
@endsection
