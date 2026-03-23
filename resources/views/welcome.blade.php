@extends('layouts.app')

@section('title', 'Find & Register for Amazing Events - EmCa Technologies')

@section('content')
<div class="page-header" style="text-align: center; padding: 5rem 1rem;">
    <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem;">Find Your Next Event</h1>
    <p style="font-size: 1.1rem; color: var(--text-muted); max-width: 800px; margin: 0 auto 2.5rem; line-height: 1.8; font-family: 'Century Gothic', sans-serif;">
        Welcome to the modern event registration and management system developed by <strong>EmCa TECHONOLOGY</strong>. 
        Here you can discover a wide range of upcoming events, choose the ones that interest you, and register 
        quickly to receive your digital tickets. Start by searching for your desired event below using its title or location.
    </p>
    
    <!-- Search Form -->
    <div class="card" style="max-width: 800px; margin: 0 auto; padding: 1.5rem;">
        <form action="{{ route('home') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <input type="text" name="search" class="form-control" placeholder="Search events by title or location..." value="{{ request('search') }}" style="flex: 2; min-width: 250px;">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="flex: 1; min-width: 150px;">
            <button type="submit" class="btn btn-primary" style="flex: 0.5; min-width: 100px; font-family: 'Century Gothic', sans-serif;">Search</button>
<!-- HERO SECTION -->
<div style="background: var(--header-gradient); padding: 120px 20px; text-align: center; border-bottom: none; font-family: 'Century Gothic', sans-serif;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="font-weight: bold; font-size: 3rem; color: #333333; margin-bottom: 1.5rem; letter-spacing: -1px; line-height: 1.2; text-transform: uppercase;">
            Effortless Event <br><span style="color: var(--corporate-red);">Attendance Management</span>
        </h1>
        <p style="font-size: 1.2rem; color: #666666; margin-bottom: 3.5rem; max-width: 750px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            Access and confirm your presence for all organized events with ease.<br>
            <span style="font-weight: bold;">Secure Verification</span> – Using your unique Access ID for instant check-in.
        </p>
        <a href="#events-list" class="btn" style="padding: 18px 60px; font-size: 1rem; border-radius: 5px; background-color: var(--corporate-red); color: white; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(148, 0, 0, 0.2); letter-spacing: 1px;">
            EXPLORE UPCOMING EVENTS
        </a>
    </div>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    

    <!-- UPCOMING EVENTS SECTION -->
    <div id="events-list" style="padding-bottom: 80px; text-align: center;">
        <div style="display: inline-block; margin-bottom: 3.5rem;">
            <h2 style="font-size: 2.2rem; color: #333333; margin: 0; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">Upcoming Events</h2>
            <p style="color: #666; margin-top: 10px; font-size: 1.1rem;">Stay updated with scheduled events and confirm your attendance.</p>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin: 15px auto 0;"></div>
        </div>

    <div style="margin-top: 4rem; text-align: center; margin-bottom: 2rem;">
        <h2 style="font-size: 2.25rem;">EVENT AVAILABLE</h2>
        <div style="width: 80px; height: 4px; background: var(--corporate-red); margin: 1rem auto;"></div>
    </div>

    <div class="grid grid-cols-3">
        @forelse($events as $event)
            <div class="card animate-fade-in delay-{{ ($loop->index % 9) + 1 }}">
                <div style="height: 150px; background: var(--accent-soft-red); border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; overflow: hidden;">
                    @if($event->image_path)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="color: var(--corporate-red); font-weight: bold;">{{ $event->title[0] }}</span>
                    @endif
                </div>
                <h4 class="card-title">{{ $event->title }}</h4>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                    {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }} • {{ $event->location }}
                </p>
                <p style="margin-bottom: 1.5rem; font-size: 0.9rem; height: 3rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    {{ $event->description }}
                </p>
                
                @php
                    $isFull = $event->registrations()->count() >= $event->capacity;
                    $now = now()->toDateString();
                    $isOpen = $now >= $event->reg_start_date && $now <= $event->reg_end_date;
                @endphp
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
            @forelse($events as $event)
                <div class="card" style="background: #FFFFFF; border: 1px solid var(--corporate-red); border-radius: 12px; padding: 0; overflow: hidden; transition: all 0.3s ease; text-align: left;"
                     onmouseover="this.style.background='var(--accent-soft-red)'; this.style.transform='translateY(-5px)';" 
                     onmouseout="this.style.background='#FFFFFF'; this.style.transform='translateY(0)';" >
                    
                    <!-- Event Icon/Image -->
                    <div style="height: 180px; background: var(--accent-soft-red); display: flex; align-items: center; justify-content: center; font-size: 4rem; color: var(--corporate-red); position: relative;">
                         @if($event->image_path)
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                           <i class="fa-solid {{ $event->category->icon ?? 'fa-calendar-star' }}"></i>
                        @endif
                        <div style="position: absolute; top: 15px; right: 15px; background: var(--corporate-red); color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">
                            {{ $event->category->name ?? 'Event' }}
                        </div>
                    </div>

                    <div style="padding: 25px;">
                        <h3 style="font-size: 1.4rem; color: #333333; margin-bottom: 1.2rem; font-weight: bold; min-height: 3.4rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $event->title }}
                        </h3>
                        
                        <div style="color: #666666; font-size: 0.95rem; margin-bottom: 2rem; display: grid; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-calendar-day" style="color: var(--corporate-red); width: 16px;"></i>
                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-clock" style="color: var(--corporate-red); width: 16px;"></i>
                                {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-location-dot" style="color: var(--corporate-red); width: 16px;"></i>
                                {{ $event->location }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px; font-weight: bold; color: var(--corporate-red);">
                                <i class="fa-solid fa-users" style="color: var(--corporate-red); width: 16px;"></i>
                                {{ $event->registrations()->count() }}/{{ $event->capacity }} SPOTS FILLED
                            </div>
                        </div>

                        <a href="{{ route('events.public.show', $event->id) }}" style="display: block; width: 100%; text-align: center; padding: 12px 0; border: 1px solid var(--corporate-red); color: var(--corporate-red); border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 0.9rem; transition: all 0.3s; text-transform: uppercase; letter-spacing: 1px;"
                           onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';"
                           onmouseout="this.style.background='transparent'; this.style.color='var(--corporate-red)';">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; padding: 100px 20px; background: #F9F9F9; border-radius: 12px; border: 1px dashed #CCC; color: #888;">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 1.5rem; display: block;"></i>
                    <p style="font-size: 1.2rem;">No events found matching your search criteria.</p>
                    <a href="{{ route('home') }}" style="color: var(--corporate-red); margin-top: 15px; display: inline-block;">View all events</a>
                </div>
            @endforelse
        </div>

        @if($events->hasMorePages())
            <div style="margin-top: 60px;">
                <a href="{{ $events->nextPageUrl() }}" style="color: var(--corporate-red); font-weight: bold; text-decoration: none; font-size: 1.1rem; border-bottom: 2px solid var(--corporate-red); padding-bottom: 5px;">
                    Load More Events &nbsp; <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- HOW IT WORKS SECTION -->
    <div style="padding: 100px 0; text-align: center; border-top: 1px solid #F5F5F5;">
        <div style="display: inline-block; margin-bottom: 5rem;">
            <h2 style="font-size: 2.2rem; color: #333333; margin: 0; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">How the System Works</h2>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin: 15px auto 0;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px;">
            <!-- Step 1 -->
            <div style="background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 15px; padding: 45px 30px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(0,0,0,0.02);"
                 onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.transform='translateY(-5px)';" onmouseout="this.style.borderColor='#EEEEEE'; this.style.transform='translateY(0)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem; opacity: 0.2;">01</div>
                <h3 style="font-size: 1.1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">Acquire Access ID</h3>
                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Contact your Branch or Unit Administrator to receive your verified Access ID.</p>
            </div>
            <!-- Step 2 -->
            <div style="background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 15px; padding: 45px 30px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(0,0,0,0.02);"
                 onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.transform='translateY(-5px)';" onmouseout="this.style.borderColor='#EEEEEE'; this.style.transform='translateY(0)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem; opacity: 0.2;">02</div>
                <h3 style="font-size: 1.1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">Browse Events</h3>
                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Review the scheduled upcoming events and identify the ones you are eligible to attend.</p>
            </div>
            <!-- Step 3 -->
            <div style="background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 15px; padding: 45px 30px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(0,0,0,0.02);"
                 onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.transform='translateY(-5px)';" onmouseout="this.style.borderColor='#EEEEEE'; this.style.transform='translateY(0)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem; opacity: 0.2;">03</div>
                <h3 style="font-size: 1.1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">Confirm Attendance</h3>
                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Submit your Access ID on the event portal to formally register your participation.</p>
            </div>
            <!-- Step 4 -->
            <div style="background: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 15px; padding: 45px 30px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(0,0,0,0.02);"
                 onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.transform='translateY(-5px)';" onmouseout="this.style.borderColor='#EEEEEE'; this.style.transform='translateY(0)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem; opacity: 0.2;">04</div>
                <h3 style="font-size: 1.1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px;">Verify at Venue</h3>
                <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">Bring your digital ticket QR code for a quick and professional verification process at the venue.</p>
            </div>
        </div>
    </div>
</div>
@endsection
