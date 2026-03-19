@extends('layouts.app')

@section('title', 'My Profile - EventPro')

@section('content')
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
</div>

<script>
    document.getElementById('editToggle').addEventListener('click', function() {
        const section = document.getElementById('editSection');
        if (section.style.display === 'none') {
            section.style.display = 'block';
            this.style.transform = 'rotate(45deg)';
            section.scrollIntoView({ behavior: 'smooth' });
        } else {
            section.style.display = 'none';
            this.style.transform = 'rotate(0deg)';
        }
    });

    document.querySelectorAll('.closeEdit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editSection').style.display = 'none';
            document.getElementById('editToggle').style.transform = 'rotate(0deg)';
        });
    });

    // Auto-open if there are errors
    @if($errors->any())
        document.getElementById('editSection').style.display = 'block';
        document.getElementById('editToggle').style.transform = 'rotate(45deg)';
    @endif
</script>
@endsection
