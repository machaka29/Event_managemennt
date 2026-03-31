@extends('layouts.admin')

@section('title', 'Register New Member - EmCa Techonologies')

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

<div class="card" style="max-width: 850px; margin: 0 auto; border-top: 5px solid var(--corporate-red); padding: 40px;">
    <form action="{{ route('admin.attendees.store') }}" method="POST">
        @csrf

        <div class="responsive-grid" style="margin-bottom: 30px; gap: 20px;">
            <div class="form-group">
                <label for="full_name" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.8rem;">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="form-control" required value="{{ old('full_name') }}" placeholder=""
                    style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                @error('full_name') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 5px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.8rem;">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" placeholder="member@example.com"
                    style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                @error('email') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 5px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="responsive-grid" style="margin-bottom: 30px; gap: 20px;">
            <div class="form-group">
                <label for="phone_number" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.8rem;">Phone Number</label>
                <div style="display: flex; align-items: stretch; border: 2px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #f8fafc; transition: all 0.2s;" onfocusin="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onfocusout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                    <span style="background: #e2e8f0; padding: 15px 18px; color: #64748b; font-weight: 800; display: flex; align-items: center; border-right: 2px solid #e2e8f0;">+255</span>
                    <input type="tel" name="phone_number" id="phone_number" class="form-control" required value="{{ old('phone_number') }}" placeholder="712345678"
                        maxlength="9" pattern="[0-9]{9}" title="Please enter exactly 9 digits"
                        style="flex: 1; border: none; padding: 15px 18px; font-size: 1rem; outline: none; background: transparent;">
                </div>
                @error('phone') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 5px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="organization" style="display: block; font-weight: 800; margin-bottom: 10px; color: #1e293b; text-transform: uppercase; font-size: 0.8rem;">Organization</label>
                <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization') }}" placeholder="e.g. Moshi Branch"
                    style="width: 100%; padding: 15px 18px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; outline: none; transition: all 0.2s; background: #f8fafc;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                @error('organization') <p style="color: #991b1b; font-size: 0.85rem; margin-top: 5px; font-weight: 600;">{{ $message }}</p> @enderror
            </div>
        </div>

        <div style="background: #fdf2f2; border-left: 4px solid var(--corporate-red); padding: 20px; border-radius: 8px; margin-bottom: 35px;">
            <p style="margin: 0; color: #991b1b; font-size: 0.9rem; font-weight: 600;">
                <i class="fa-solid fa-circle-info" style="margin-right: 8px;"></i>
                A unique <strong>Member Access ID</strong> will be generated automatically upon entry.
            </p>
        </div>

        <div style="border-top: 1px solid #f1f5f9; padding-top: 35px; display: flex; justify-content: flex-end; gap: 15px; flex-wrap: wrap;">
            <button type="reset" class="btn btn-outline" style="min-width: 150px;">RESET FORM</button>
            <button type="submit" class="btn btn-primary" style="min-width: 220px; gap: 10px; font-size: 1rem; box-shadow: 0 10px 15px -3px rgba(148,0,0,0.3);">
                <i class="fa-solid fa-user-plus"></i> REGISTER MEMBER
            </button>
        </div>
    </form>
</div>
@endsection
