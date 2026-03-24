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

    <div class="responsive-grid" style="align-items: flex-start; gap: 2.5rem;">
        <!-- Left: Event Details -->
        <div style="display: flex; flex-direction: column;">
            <div class="card" style="border-top: 4px solid var(--corporate-red); padding: 35px;">
                <h1 style="margin-bottom: 0.5rem; font-weight: 800; line-height: 1.2;">{{ $event->title }}</h1>
                <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 2rem;">
                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                </p>
                
                <div class="stats-grid" style="margin-bottom: 2.5rem; gap: 15px;">
                    <div class="card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; text-transform: uppercase; font-weight: 800;">Location</p>
                        <p style="font-weight: 700; color: #1e293b;">{{ $event->location }}</p>
                    </div>
                    <div class="card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; text-transform: uppercase; font-weight: 800;">Available Seats</p>
                        <p style="font-weight: 700; color: #1e293b;">{{ $event->capacity - $event->registrations()->count() }} / {{ $event->capacity }}</p>
                    </div>
                </div>

                <h3 style="margin-bottom: 1.25rem; font-weight: 800; text-transform: uppercase; font-size: 1.1rem; color: #1e293b;">About this Event</h3>
                <div style="color: #475569; white-space: pre-wrap; line-height: 1.8; font-size: 1.05rem;">
                    {{ $event->description }}
                </div>

                @if($event->image_path)
                    <div style="margin-top: 2.5rem; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; display: block;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Member Confirmation -->
        <div class="card" style="border-top: 4px solid var(--corporate-red); text-align: center; padding: 45px 30px; position: sticky; top: 100px;">
            @if(session('member_access_id'))
                <div style="width: 64px; height: 64px; background: #f0fdf4; color: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin: 0 auto 20px; border: 2px solid #bbf7d0;">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                
                <h3 style="margin-bottom: 15px; font-weight: 800; color: #1e293b;">ID VERIFIED</h3>
                <p style="color: #64748b; margin-bottom: 35px; font-size: 0.95rem; line-height: 1.5;">
                    Welcome back! You are logged in as: <br>
                    <strong style="color: var(--corporate-red); font-family: 'Courier New', Courier, monospace; font-size: 1.2rem; display: block; margin-top: 10px;">{{ session('member_access_id') }}</strong>
                </p>
                
                @if(session('error'))
                    <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.85rem; font-weight: 600; border: 1px solid #fecaca;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('events.public.register', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; font-size: 1.1rem; letter-spacing: 0.5px; box-shadow: 0 10px 15px -3px rgba(148,0,0,0.3);">
                        CONFIRM ATTENDANCE
                    </button>
                </form>

                <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                    <form action="{{ route('member.logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.85rem; font-weight: 600; text-decoration: underline; transition: color 0.2s;" onmouseover="this.style.color='var(--corporate-red)'" onmouseout="this.style.color='#94a3b8'">
                            Not you? Switch Member ID
                        </button>
                    </form>
                </div>
            @else
                <div style="width: 64px; height: 64px; background: var(--accent-soft-red); color: var(--corporate-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin: 0 auto 20px; border: 2px solid #fecaca;">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                
                <h3 style="margin-bottom: 15px; font-weight: 800; color: #1e293b;">REGISTER NOW</h3>
                <p style="color: #64748b; margin-bottom: 35px; font-size: 0.95rem; line-height: 1.5;">
                    Please enter your unique <strong>Member ID</strong> to confirm your attendance.
                </p>

                @if(session('error'))
                    <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; font-size: 0.85rem; font-weight: 600; border: 1px solid #fecaca;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('events.public.register', $event->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 25px;">
                        <input type="text" name="access_code" placeholder="ENTER ID (e.g. EmCa-...)" required 
                            style="width: 100%; padding: 18px; border: 2px solid #e2e8f0; border-radius: 10px; text-align: center; font-family: monospace; font-weight: 800; font-size: 1.2rem; outline: none; transition: all 0.2s; background: #f8fafc; color: #1e293b;"
                            onfocus="this.style.borderColor='var(--corporate-red)'; this.style.background='white'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'; this.style.boxShadow='none'">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; font-size: 1.1rem; letter-spacing: 0.5px; box-shadow: 0 10px 15px -3px rgba(148,0,0,0.3);">
                        VERIFY & REGISTER
                    </button>
                    
                    <p style="margin-top: 25px; font-size: 0.8rem; color: #94a3b8; font-weight: 500;">
                        Don't have an ID? Contact the event organizer for assistance.
                    </p>
                </form>
            @endif
        </div>
    </div>

    </div>
</div>
@endsection
