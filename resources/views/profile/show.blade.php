@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.organizer')

@section('title', 'Profile Settings - EmCa Technologies')

@section('content')
<<<<<<< HEAD
    <h1 style="text-align: center; margin-bottom: 2rem;">My Profile</h1>
    <div style="text-align: center; margin-bottom: 3rem;">
        <!-- Circular Profile Section -->
        <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 1rem; border-radius: 50%; overflow: visible; background: var(--border-color);">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            @else
                <!-- Google Style Placeholder -->
                <div style="width: 100%; height: 100%; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 4rem; font-weight: bold; border: 4px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: 'Century Gothic', sans-serif;">
                    {{ strtoupper($user->name[0]) }}
                </div>
            @endif

            <!-- Edit Icon (Pencil) -->
            <button id="editToggle" style="position: absolute; bottom: 5px; right: 5px; width: 40px; height: 40px; border-radius: 50%; background: white; border: 1px solid var(--border-color); cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: transform 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--corporate-red)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </button>
        </div>
        <h2 style="margin: 0;">{{ $user->name }}</h2>
        <p style="color: var(--text-muted); margin-bottom: 0.5rem;">{{ ucfirst($user->role) }} • {{ $user->email }}</p>
        <p style="font-size: 0.95rem; color: var(--corporate-red); font-weight: 600;">
            {{ $user->phone }} @if($user->organization) • {{ $user->organization }} @endif
        </p>
    </div>

    <!-- Edit Forms (Hidden by default) -->
    <div id="editSection" style="display: none; transition: all 0.3s ease;">
        <div class="grid grid-cols-2" style="align-items: flex-start; gap: 2rem;">
            <!-- Update Info -->
            <div class="card" style="max-width: 100%; border-top: 4px solid var(--corporate-red);">
                <h3 style="margin-bottom: 1.5rem;">Edit Profile Information</h3>
                
                <form action="{{ route('profile.info') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="profile_image">Upload New Photo</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">
                        @error('profile_image') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                        @error('phone') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="organization">Organization (Optional)</label>
                        <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization', $user->organization) }}">
                        @error('organization') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Update Profile</button>
                        <button type="button" class="btn btn-outline closeEdit" style="flex: 1;">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="card" style="max-width: 100%; border-top: 4px solid var(--corporate-red);">
                <h3 style="margin-bottom: 1.5rem;">Refresh Password</h3>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                        @error('current_password') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password') <p class="text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">Update Password</button>
                        <button type="button" class="btn btn-outline closeEdit" style="flex: 1;">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div style="max-width: 600px; margin: 2rem auto; padding: 1rem; background: #C6F6D5; color: #2F855A; border-radius: 8px; text-align: center;">
            @if(session('status') === 'profile-updated') Changes saved successfully. @endif
            @if(session('status') === 'password-updated') Password updated successfully. @endif
        </div>
    @endif

    <div style="margin-top: 3rem;">
        <a href="javascript:history.back()" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back
        </a>
    </div>
=======
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div>
        <h1 style="font-size: 2.22rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px; text-transform: none;">
            Profile Settings
        </h1>
        <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
        <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">Manage your personal information, profile picture, and security settings.</p>
    </div>
>>>>>>> 6cc1c78 (new changes)
</div>

@if (session('status'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> 
        @if(session('status') === 'profile-updated') Profile updated successfully. @endif
        @if(session('status') === 'password-updated') Password updated successfully. @endif
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; align-items: start;">
    
    <!-- Profile Card Summary -->
    <div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; background: #FFF5F5; border: 4px solid var(--accent-soft-red); box-shadow: 0 4px 15px rgba(148,0,0,0.1);">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; font-weight: 900; color: var(--corporate-red);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <h2 style="margin: 0; font-size: 1.4rem; color: #1a1a1a; font-weight: 800;">{{ $user->name }}</h2>
        <p style="color: var(--corporate-red); margin: 5px 0 0; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">{{ ucfirst($user->role) }}</p>
        <p style="color: #666; margin: 10px 0 0; font-size: 0.95rem;">{{ $user->email }}</p>
        @if($user->phone)
            <p style="color: #888; margin: 5px 0 0; font-size: 0.95rem;">{{ $user->phone }}</p>
        @endif
    </div>

    <!-- Edit Forms -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        
        <!-- Basic Info Form -->
        <div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="margin: 0 0 25px; font-size: 1.3rem; color: #1a1a1a; font-weight: 800; border-bottom: 2px solid #f5f5f5; padding-bottom: 15px;">Basic Information</h3>
            
            <form action="{{ route('profile.info') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div style="margin-bottom: 25px;">
                    <label for="name" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('name') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="email" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('email') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="phone" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Phone Number (Optional)</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '+255') }}" placeholder="+255xxxxxxxxx" style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('phone') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
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
        <div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="margin: 0 0 25px; font-size: 1.3rem; color: #1a1a1a; font-weight: 800; border-bottom: 2px solid #f5f5f5; padding-bottom: 15px;">Update Password</h3>
            
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 25px;">
                    <label for="current_password" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('current_password') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="password" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">New Password</label>
                    <input type="password" name="password" id="password" required style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    @error('password') <p style="color: var(--corporate-red); margin: 5px 0 0; font-size: 0.85rem; font-weight: 600;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 30px;">
                    <label for="password_confirmation" style="display: block; font-weight: 700; color: #333; margin-bottom: 8px;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required style="width: 100%; padding: 14px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                </div>

                <button type="submit" style="background: #1a1a1a; color: white; border: none; padding: 14px 30px; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Update Password</button>
            </form>
        </div>

    </div>
</div>
@endsection
