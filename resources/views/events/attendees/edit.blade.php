@php
    $isAdmin = auth()->user()->role === 'admin';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.organizer';
    $updateRoute = $isAdmin ? 'admin.attendees.update' : 'organizer.attendees.update';
    $indexRoute = $isAdmin ? 'admin.attendees.list' : 'organizer.attendees.index';
@endphp

@extends($layout)

@section('title', 'Edit Member - EmCa Techonologies')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- HEADER -->
    <div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <h1 style="font-size: 2.22rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px;">Edit Member Details</h1>
        <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
        <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">Update information for member: <strong>{{ $attendee->full_name }}</strong></p>
    </div>

    <!-- FORM CARD -->
    <div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 35px; background: #fafafa; border-bottom: 1px solid #eee;">
            <h2 style="margin: 0; font-size: 1.2rem; color: #333; font-weight: 700;">Member Information</h2>
        </div>

        <form action="{{ route($updateRoute, $attendee->id) }}" method="POST" style="padding: 40px;">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
                <!-- Full Name -->
                <div>
                    <label for="full_name" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Full Name <span style="color: var(--corporate-red);">*</span></label>
                    <input type="text" name="full_name" id="full_name" required value="{{ old('full_name', $attendee->full_name) }}"
                        pattern="^[a-zA-Z\s.-]+$" title="Name should only contain letters, spaces, dots or hyphens"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                    @error('full_name') <p style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Email Address <span style="color: var(--corporate-red);">*</span></label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $attendee->email) }}"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                    @error('email') <p style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $attendee->phone) }}" placeholder="+2557XXXXXXXX" 
                        pattern="^\+255[0-9]{9}$" title="Phone number should be +255 followed by 9 digits"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                    @error('phone') <p style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Organization/Branch -->
                <div>
                    <label for="organization" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Branch / Organization</label>
                    <input type="text" name="organization" id="organization" value="{{ old('organization', $attendee->organization) }}"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                </div>
            </div>

            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #eee; color: #666; font-size: 0.95rem; line-height: 1.6;">
                <i class="fa-solid fa-id-card" style="margin-right: 8px;"></i>
                <strong>Access ID:</strong> <code style="background: #eee; padding: 2px 6px; border-radius: 4px; color: var(--corporate-red);">{{ $attendee->access_code }}</code> (Cannot be changed)
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 15px;">
                <a href="{{ route($indexRoute) }}" style="padding: 14px 30px; border-radius: 10px; text-decoration: none; color: #666; font-weight: 700; border: 1px solid #ddd; transition: all 0.3s;" onmouseover="this.style.background='#eee';">CANCEL</a>
                <button type="submit" style="background: var(--corporate-red); color: white; padding: 14px 40px; border: none; border-radius: 10px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(148, 0, 0, 0.2); display: flex; align-items: center; gap: 10px;"
                    onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"
                >
                    <i class="fa-solid fa-floppy-disk"></i> UPDATE MEMBER
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
