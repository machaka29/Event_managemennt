@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.organizer')

@section('title', 'Profile Settings - EmCa Techonologies')

@section('content')
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);" class="profile-header">
    <div>
        <h1 style="font-size: 2.22rem; color: #333; margin: 0; font-weight: 800; letter-spacing: -0.5px; text-transform: none;" class="page-title">
            Profile Settings
        </h1>
        <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
        <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;" class="page-subtitle">Manage your personal information, profile picture, and security settings.</p>
    </div>
</div>

<style>
    @media (max-width: 992px) {
        .profile-grid { grid-template-columns: 1fr !important; gap: 20px !important; }
        .profile-header { padding: 20px !important; margin-bottom: 25px !important; }
        .page-title { font-size: 1.6rem !important; }
        .page-subtitle { font-size: 0.95rem !important; }
        .form-card { padding: 25px !important; }
        .profile-summary-card { padding: 30px !important; }
    }
</style>

@if (session('status'))
    <div style="background: #FFF5F5; border-left: 5px solid var(--corporate-red); color: var(--corporate-red); padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> 
        @if(session('status') === 'profile-updated') Profile updated successfully. @endif
        @if(session('status') === 'password-updated') Password updated successfully. @endif
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; align-items: start;" class="profile-grid">
    
    <!-- Profile Card Summary -->
    <div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);" class="profile-summary-card">
        <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; background: #FFF5F5; border: 4px solid var(--accent-soft-red); box-shadow: 0 4px 15px rgba(148,0,0,0.1);">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; font-weight: 900; color: var(--corporate-red);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <h2 style="margin: 0; font-size: 1.4rem; color: #333; font-weight: 800;">{{ $user->name }}</h2>
        <p style="color: var(--corporate-red); margin: 5px 0 0; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">{{ ucfirst($user->role) }}</p>
        <p style="color: #666; margin: 10px 0 0; font-size: 0.95rem;">{{ $user->email }}</p>
        @if($user->phone)
            <p style="color: #888; margin: 5px 0 0; font-size: 0.95rem;">{{ $user->phone }}</p>
        @endif
        @if($user->organization)
            <p style="color: #333; margin: 10px 0 0; font-size: 0.95rem; font-weight: 700;"><i class="fa-solid fa-briefcase" style="color: var(--corporate-red); margin-right: 5px;"></i> {{ $user->organization }}</p>
        @endif
    </div>

    <!-- Edit Forms -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        
        <!-- Basic Info Form -->
        <div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);" class="form-card">
            <h3 style="margin: 0 0 25px; font-size: 1.3rem; color: #333; font-weight: 800; border-bottom: 2px solid #f5f5f5; padding-bottom: 15px;">Basic Information</h3>
            
            <form action="{{ route('profile.info') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div style="margin-bottom: 25px;">
                    <label for="name" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                        pattern="^[a-zA-Z\s.-]+$" title="Name should only contain letters, spaces, dots or hyphens"
                        style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('name') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="email" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('email') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="phone_number" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Phone Number (Optional)</label>
                    <div style="display: flex; align-items: stretch; border: 2px solid #eee; border-radius: 10px; overflow: hidden; transition: border-color 0.3s;" onfocusin="this.style.borderColor='var(--corporate-red)'" onfocusout="this.style.borderColor='#eee'">
                        <span style="background: #f9f9f9; padding: 14px 20px; border-right: 2px solid #eee; color: #666; font-weight: 700; display: flex; align-items: center;">+255</span>
                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', substr($user->phone ?? '', 4)) }}" placeholder="712345678"
                            maxlength="9" pattern="[0-9]{9}" title="Please enter exactly 9 digits"
                            style="flex: 1; border: none; padding: 14px 20px; font-size: 1rem; outline: none; background: transparent;">
                    </div>
                    @error('phone') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="organization" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Organization Name</label>
                    <input type="text" name="organization" id="organization" value="{{ old('organization', $user->organization) }}" 
                        placeholder="e.g. Acme Corp"
                        style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('organization') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 30px;">
                    <label for="profile_image" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Profile Picture</label>
                    <div style="border: 2px dashed #ccc; border-radius: 10px; padding: 20px; text-align: center; background: #fafafa;">
                        <input type="file" name="profile_image" id="profile_image" style="font-family: inherit; font-size: 0.95rem; color: #666;" accept="image/*">
                    </div>
                    @error('profile_image') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <button type="submit" style="background: var(--corporate-red); color: white; border: none; padding: 14px 30px; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(148,0,0,0.2);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Save Changes</button>
            </form>
        </div>

        <!-- Password Form -->
        <div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);" class="form-card">
            <h3 style="margin: 0 0 25px; font-size: 1.3rem; color: #333; font-weight: 800; border-bottom: 2px solid #f5f5f5; padding-bottom: 15px;">Update Password</h3>
            
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 25px;">
                    <label for="current_password" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Current Password</label>
                    <div class="password-container">
                        <input type="password" name="current_password" id="current_password" required style="width: 100%; padding: 14px 45px 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                        <span class="password-toggle" onclick="togglePassword('current_password', 'toggleCurrentIcon')">
                            <i class="fa-solid fa-eye" id="toggleCurrentIcon"></i>
                        </span>
                    </div>
                    @error('current_password') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="password" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">New Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" required style="width: 100%; padding: 14px 45px 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                        <span class="password-toggle" onclick="togglePassword('password', 'toggleNewIcon')">
                            <i class="fa-solid fa-eye" id="toggleNewIcon"></i>
                        </span>
                    </div>
                    @error('password') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 30px;">
                    <label for="password_confirmation" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Confirm New Password</label>
                    <div class="password-container">
                        <input type="password" name="password_confirmation" id="password_confirmation" required style="width: 100%; padding: 14px 45px 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                        <span class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')">
                            <i class="fa-solid fa-eye" id="toggleConfirmIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" style="background: var(--corporate-red); color: white; border: none; padding: 14px 30px; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(148,0,0,0.2);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Update Password</button>
            </form>
        </div>

    </div>
</div>
@endsection
