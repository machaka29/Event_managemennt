@extends('layouts.organizer')

@section('title', 'Add New Member - EmCa Technologies')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <!-- HEADER -->
    <div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <h1 style="font-size: 2.22rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px;">Register New Member</h1>
        <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
        <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">Add a member manually to generate their unique Event Access ID.</p>
    </div>

    <!-- FORM CARD -->
    <div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden;">
        <div style="padding: 35px; background: #fafafa; border-bottom: 1px solid #eee;">
            <h2 style="margin: 0; font-size: 1.2rem; color: #333; font-weight: 700;">Member Registration Form</h2>
        </div>

        <form action="{{ route('organizer.attendees.store') }}" method="POST" style="padding: 40px;">
            @csrf
            
            <div class="responsive-grid" style="margin-bottom: 40px; gap: 30px;">
                <!-- Full Name -->
                <div>
                    <label for="full_name" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Full Name <span style="color: var(--corporate-red);">*</span></label>
                    <input type="text" name="full_name" id="full_name" required placeholder="Enter full name"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                    @error('full_name') <p style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Email Address <span style="color: var(--corporate-red);">*</span></label>
                    <input type="email" name="email" id="email" required placeholder="email@example.com"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                    @error('email') <p style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Phone Number</label>
                    <input type="text" name="phone" id="phone" placeholder="+255..."
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                </div>

                <!-- Organization/Branch -->
                <div>
                    <label for="organization" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase;">Branch / Organization</label>
                    <input type="text" name="organization" id="organization" placeholder="e.g. Moshi Branch"
                        style="width: 100%; padding: 14px 20px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#ddd'">
                </div>
            </div>

            <div style="background: #FFF5F5; padding: 25px; border-radius: 12px; margin-bottom: 40px; border: 1px dashed var(--corporate-red); color: var(--corporate-red); font-size: 0.95rem; line-height: 1.6;">
                <i class="fa-solid fa-circle-info" style="margin-right: 8px;"></i>
                <strong>Note:</strong> A unique <strong>Access ID</strong> will be automatically generated for this member upon submission. This ID will serve as their login key to view events.
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 15px;">
                <a href="{{ route('organizer.attendees.index') }}" style="padding: 14px 30px; border-radius: 10px; text-decoration: none; color: #666; font-weight: 700; border: 1px solid #ddd; transition: all 0.3s;" onmouseover="this.style.background='#eee';">CANCEL</a>
                <button type="submit" style="background: var(--corporate-red); color: white; padding: 14px 40px; border: none; border-radius: 10px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(148, 0, 0, 0.2);"
                    onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"
                >REGISTER MEMBER</button>
            </div>
        </form>
    </div>
</div>
@endsection
