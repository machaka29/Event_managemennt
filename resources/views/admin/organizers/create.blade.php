@extends('layouts.admin')

@section('title', 'Add New Organizer - EmCa TECHONOLOGY')

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

        <div class="responsive-grid" style="margin-bottom: 40px;">
            <div class="form-group">
                <label for="name" style="display: block; font-weight: bold; margin-bottom: 8px; color: #444;">Full Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. John Doe"
                    style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; outline: none; transition: 0.3s; box-sizing: border-box;"
                    onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                @error('name') <p class="text-error" style="color: red; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: #444;">Email Address</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="organizer@example.com"
                    style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; outline: none; transition: 0.3s; box-sizing: border-box;"
                    onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                @error('email') <p class="text-error" style="color: red; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="phone_number" style="display: block; font-weight: bold; margin-bottom: 8px; color: #444;">Phone Number</label>
                <div style="display: flex; align-items: stretch; border: 2px solid #eee; border-radius: 10px; overflow: hidden; transition: border-color 0.3s; box-sizing: border-box;" onfocusin="this.style.borderColor='var(--corporate-red)'" onfocusout="this.style.borderColor='#eee'">
                    <span style="background: #f9f9f9; padding: 14px 20px; border-right: 2px solid #eee; color: #555; font-weight: bold; display: flex; align-items: center;">+255</span>
                    <input type="text" name="phone_number" id="phone_number" required value="{{ old('phone_number') }}" placeholder="712345678" maxlength="9" pattern="\d{9}"
                        style="border: none; padding: 14px 20px; flex: 1; outline: none; font-size: 1rem; box-sizing: border-box;">
                </div>
                @error('phone') <p class="text-error" style="color: red; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="password" style="display: block; font-weight: bold; margin-bottom: 8px; color: #444;">Initial Password</label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" required placeholder="Minimum 8 characters"
                        style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; outline: none; transition: 0.3s; box-sizing: border-box;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    <i class="fa-solid fa-lock" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #ccc;"></i>
                </div>
                <p style="font-size: 0.75rem; color: #888; margin-top: 8px;">Used by the organizer for their first login.</p>
                @error('password') <p class="text-error" style="color: red; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 30px; display: flex; justify-content: flex-end; gap: 15px; flex-wrap: wrap;">
            <button type="reset" class="btn" style="background: #f5f5f5; color: #666; border: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; cursor: pointer; flex: 1; min-width: 150px;">RESET FORM</button>
            <button type="submit" class="btn btn-primary" style="padding: 12px 40px; border-radius: 6px; font-weight: bold; border: none; display: flex; align-items: center; justify-content: center; gap: 10px; flex: 1; min-width: 200px;">
                <i class="fa-solid fa-user-plus"></i> CREATE ACCOUNT
            </button>
        </div>
    </form>
</div>
@endsection
