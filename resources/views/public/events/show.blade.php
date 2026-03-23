@extends('layouts.app')

@section('title', 'Register for ' . $event->title . ' - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <!-- Top Navigation -->
    <div style="margin-bottom: 2rem;">
        @php
            $backUrl = route('home');
            $backText = 'Back to Events';
            if(auth()->check()) {
                if(auth()->user()->role === 'admin') {
                    $backUrl = route('admin.dashboard');
                    $backText = 'Back to Dashboard';
                } elseif(auth()->user()->role === 'organizer') {
                    $backUrl = route('dashboard');
                    $backText = 'Back to Dashboard';
                }
            }
        @endphp
        <a href="{{ $backUrl }}" class="btn-back" style="display: inline-flex; align-items: center; gap: 8px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: 0.3s; padding: 5px 0;"
           onmouseover="this.style.color='var(--corporate-red)';" onmouseout="this.style.color='#666';">
            <i class="fa-solid fa-chevron-left"></i> {{ $backText }}
        </a>
    </div>

    <div class="grid grid-cols-3" style="align-items: flex-start; gap: 3rem;">
        <!-- Left: Event Details -->
        <div style="grid-column: span 2;">
            <div class="card" style="max-width: 100%; border-top: 4px solid var(--corporate-red);">
                <h1 style="margin-bottom: 0.5rem;">{{ $event->title }}</h1>
                <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                </p>
                
                <div style="margin-bottom: 2rem; display: flex; gap: 2rem; flex-wrap: wrap;">
                    <div class="stat-card" style="flex: 1; min-width: 150px;">
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Location</p>
                        <p style="font-weight: bold;">{{ $event->location }}</p>
                    </div>
                    <div class="stat-card" style="flex: 1; min-width: 150px;">
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.2rem;">Available Seats</p>
                        <p style="font-weight: bold;">{{ $event->capacity - $event->registrations()->count() }} / {{ $event->capacity }}</p>
                    </div>
                </div>

                <h3>About this Event</h3>
                <div style="margin-top: 1rem; white-space: pre-wrap; line-height: 1.8;">
                    {{ $event->description }}
                </div>

                @if($event->image_path)
                    <div style="margin-top: 2rem;">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; border-radius: 8px;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Member Confirmation -->
        <div class="card" style="max-width: 100%; position: sticky; top: 2rem; border-top: 4px solid var(--corporate-red); text-align: center; padding: 40px 30px;">
            @if(session('member_access_id'))
                <div style="width: 60px; height: 60px; background: #FFF5F5; color: var(--corporate-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 20px;">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                
                <h3 style="margin-bottom: 10px;">ID Verified</h3>
                <p style="color: #666; margin-bottom: 30px; font-size: 0.95rem;">
                    Welcome back! You are logged in with Member ID: <br>
                    <strong style="color: var(--corporate-red); font-family: monospace;">{{ session('member_access_id') }}</strong>
                </p>
                
                @if(session('error'))
                    <div style="background: #FED7D7; color: #C53030; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('events.public.register', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" style="width: 100%; padding: 18px; background: var(--corporate-red); color: white; border: none; border-radius: 8px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(148, 0, 0, 0.2);"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"
                    >
                        CONFIRM ATTENDANCE
                    </button>
                </form>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <form action="{{ route('member.logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #999; cursor: pointer; font-size: 0.85rem; text-decoration: underline;">
                            Not you? Switch Member ID
                        </button>
                    </form>
                </div>
            @else
                <div style="width: 60px; height: 60px; background: #FFF5F5; color: var(--corporate-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 20px;">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                
                <h3 style="margin-bottom: 10px;">Register for Event</h3>
                <p style="color: #666; margin-bottom: 30px; font-size: 0.95rem;">
                    Please enter your <strong>Member ID</strong> to confirm your attendance.
                </p>

                @if(session('error'))
                    <div style="background: #FED7D7; color: #C53030; padding: 0.75rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('events.public.register', $event->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <input type="text" name="access_code" placeholder="e.g. EM-1234-XYZ" required 
                            style="width: 100%; padding: 15px; border: 2px solid #eee; border-radius: 8px; text-align: center; font-family: monospace; font-weight: bold; font-size: 1.1rem; outline: none; transition: 0.3s;"
                            onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    </div>
                    <button type="submit" class="btn" style="width: 100%; padding: 18px; background: var(--corporate-red); color: white; border: none; border-radius: 8px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(148, 0, 0, 0.2);"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"
                    >
                        VERIFY & REGISTER
                    </button>
                    
                    <p style="margin-top: 20px; font-size: 0.8rem; color: #999;">
                        Don't have an ID? Please contact the organizer.
                    </p>
                </form>
            @endif
        </div>
    </div>

    </div>
</div>
@endsection
