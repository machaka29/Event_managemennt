@extends('layouts.admin')

@section('title', 'Register New Member - EmCa Technologies')

@section('content')
<div style="margin-bottom: 2rem; border-bottom: 2px solid var(--corporate-red); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1 style="color: var(--corporate-red); font-size: 1.8rem; margin: 0; text-transform: uppercase; letter-spacing: 1px;">Register New Member</h1>
        <p style="color: #666; margin-top: 5px;">Manually register a new member and generate their Access ID.</p>
    </div>
    <a href="{{ route('admin.attendees.list') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-arrow-left"></i> BACK TO LIST
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; border-top: 4px solid var(--corporate-red); padding: 40px;">
    <form action="{{ route('admin.attendees.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="form-control" required value="{{ old('full_name') }}" placeholder="e.g. John Doe">
                @error('full_name') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" placeholder="member@example.com">
                @error('email') <p class="text-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. +255 712 345 678">
                @error('phone') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="organization">Organization / Branch</label>
                <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization') }}" placeholder="e.g. Moshi Branch">
                @error('organization') <p class="text-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="background: #FFF5F5; border-left: 4px solid var(--corporate-red); padding: 15px 20px; border-radius: 4px; margin-bottom: 30px;">
            <p style="margin: 0; color: #333; font-size: 0.9rem;">
                <i class="fa-solid fa-circle-info" style="color: var(--corporate-red); margin-right: 8px;"></i>
                <strong>Note:</strong> A unique <strong>Member Access ID</strong> will be automatically generated once you save this record.
            </p>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 30px; display: flex; justify-content: flex-end; gap: 15px;">
            <button type="reset" class="btn" style="background: #f5f5f5; color: #666; border: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; cursor: pointer;">RESET FORM</button>
            <button type="submit" class="btn btn-primary" style="padding: 12px 40px; border-radius: 6px; font-weight: bold; border: none;">REGISTER MEMBER</button>
        </div>
    </form>
</div>
@endsection
