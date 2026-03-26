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
                
                <div class="stats-grid" style="margin-bottom: 2.5rem; gap: 15px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    <div class="card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; text-transform: uppercase; font-weight: 800;">Location</p>
                        <p style="font-weight: 700; color: #1e293b;">{{ $event->location }}</p>
                    </div>
                    @if($event->venue)
                    <div class="card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; text-transform: uppercase; font-weight: 800;">Venue</p>
                        <p style="font-weight: 700; color: #1e293b;">{{ $event->venue }}</p>
                    </div>
                    @endif
                    <div class="card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; text-transform: uppercase; font-weight: 800;">Available Seats</p>
                        <p style="font-weight: 700; color: #1e293b;">{{ $event->capacity - $event->registrations()->count() }} / {{ $event->capacity }}</p>
                    </div>
                    @if($event->target_audience)
                    <div class="card" style="padding: 15px; background: #f8fafc; border: 1px solid #e2e8f0; margin-bottom: 0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 5px; text-transform: uppercase; font-weight: 800;">Target Audience</p>
                        <p style="font-weight: 700; color: #1e293b;">{{ $event->target_audience }}</p>
                    </div>
                    @endif
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
        <div class="card" style="border-top: 4px solid var(--corporate-red); text-align: left; padding: 40px 30px; position: sticky; top: 100px;">
            <div style="text-align: center; margin-bottom: 25px;">
                <div style="width: 64px; height: 64px; background: var(--accent-soft-red); color: var(--corporate-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin: 0 auto 15px; border: 2px solid #fecaca;">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <h3 style="margin-bottom: 5px; font-weight: 800; color: #1e293b;">REGISTER NOW</h3>
                <p style="color: #64748b; font-size: 0.95rem;">Secure your spot at this event.</p>
            </div>

            @if(session('error'))
                <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem; font-weight: 600; border: 1px solid #fecaca;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('events.public.register', $event->id) }}" method="POST">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 5px;">Full Name *</label>
                    <input type="text" name="full_name" placeholder="John Doe" required 
                        pattern="^[a-zA-Z\s.-]+$" title="Name should only contain letters, spaces, dots or hyphens"
                        style="width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: 0.2s;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 5px;">Email Address *</label>
                    <input type="email" name="email" placeholder="john@example.com" required 
                        style="width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: 0.2s;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 5px;">Phone Number *</label>
                    <input type="tel" name="phone" placeholder="+255712345678" required 
                        pattern="^\+255[0-9]{9}$" title="Phone number should be +255 followed by 9 digits"
                        style="width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: 0.2s;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    <p style="font-size: 0.7rem; color: #64748b; margin-top: 5px;">Use format: +255XXXXXXXXX</p>
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 5px;">Organization / Company (Optional)</label>
                    <input type="text" name="organization" placeholder="Your Company Ltd" 
                        style="width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 1rem; outline: none; transition: 0.2s;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; font-size: 1.05rem; letter-spacing: 0.5px; box-shadow: 0 10px 15px -3px rgba(148,0,0,0.3);">
                    COMPLETE REGISTRATION
                </button>
            </form>
        </div>
    </div>

    </div>
</div>
@endsection
