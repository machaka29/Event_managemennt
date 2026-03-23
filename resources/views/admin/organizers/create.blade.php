@extends('layouts.admin')

@section('title', 'Add New Organizer - EmCa Technologies')

@section('content')
<div style="margin-bottom: 2rem; border-bottom: 2px solid var(--corporate-red); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="color: var(--corporate-red); font-size: 1.8rem; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Add New Organizer</h1>
        <p style="color: #666; margin-top: 5px;">Create a new organizer account to manage events.</p>
    </div>
    <a href="{{ route('admin.organizers.index') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-arrow-left"></i> BACK TO LIST
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; border-top: 4px solid var(--corporate-red); padding: 40px;">
    <form action="{{ route('admin.organizers.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}" placeholder="e.g. John Doe">
                @error('name') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" placeholder="organizer@example.com">
                @error('email') <p class="text-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="margin-bottom: 40px;">
            <div class="form-group" style="max-width: 370px;">
                <label for="password">Initial Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Minimum 8 characters">
                    <i class="fa-solid fa-lock" style="position: absolute; right: 15px; top: 50%; translate: 0 -50%; color: #ccc;"></i>
                </div>
                <p style="font-size: 0.75rem; color: #888; margin-top: 8px;">The organizer will use this password for their first login.</p>
                @error('password') <p class="text-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 30px; display: flex; justify-content: flex-end; gap: 15px;">
            <button type="reset" class="btn" style="background: #f5f5f5; color: #666; border: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; cursor: pointer;">RESET FORM</button>
            <button type="submit" class="btn btn-primary" style="padding: 12px 40px; border-radius: 6px; font-weight: bold; border: none; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-user-plus"></i> CREATE ACCOUNT
            </button>
        </div>
    </form>
</div>
@endsection
