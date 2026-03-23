@extends('layouts.app')

@section('title', 'Find & Register for Amazing Events - EmCa Technologies')

@section('content')
<!-- HERO SECTION -->
<div style="background: var(--header-gradient); padding: 80px 20px; text-align: center; border-bottom: 2px solid #eee;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="font-weight: bold; font-size: 3rem; color: #333; margin-bottom: 1.5rem; letter-spacing: -1px; line-height: 1.2; text-transform: uppercase;">
            Effortless Event <br><span style="color: var(--corporate-red);">Attendance Management</span>
        </h1>
        <p style="font-size: 1.2rem; color: #666; margin-bottom: 2.5rem; max-width: 750px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            Access and confirm your presence for all organized events with ease.<br>
            <span style="font-weight: bold;">Secure Verification</span> – Using your unique Access ID for instant check-in.
        </p>
        
        <!-- Search Form -->
        <div style="max-width: 700px; margin: 0 auto; background: white; padding: 10px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <form action="{{ route('home') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="Search events..." value="{{ request('search') }}" 
                    style="flex: 2; min-width: 200px; padding: 12px 20px; border: 1px solid #eee; border-radius: 8px; outline: none; font-size: 1rem;">
                <button type="submit" style="background: var(--corporate-red); color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;" onmouseover="this.style.opacity='0.9'">
                    <i class="fa-solid fa-magnifying-glass"></i> SEARCH
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 60px 20px;">
    
    <!-- UPCOMING EVENTS SECTION -->
    <div id="events-list" style="padding-bottom: 40px; text-align: center;">
        <div style="display: inline-block; margin-bottom: 4rem;">
            <h2 style="font-size: 2.2rem; color: #333; margin: 0; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                {{ request('search') ? 'Search Results' : 'Upcoming Events' }}
            </h2>
            @if(request('search'))
                <p style="color: var(--corporate-red); margin-top: 10px; font-size: 1.1rem; font-weight: 600;">Showing results for "{{ request('search') }}"</p>
            @else
                <p style="color: #666; margin-top: 10px; font-size: 1.1rem;">Stay updated with scheduled events and confirm your attendance.</p>
            @endif
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin: 15px auto 0;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
            @forelse($events as $event)
                <div class="card" style="background: #FFFFFF; border: 1px solid #eee; border-radius: 12px; padding: 0; overflow: hidden; transition: all 0.3s ease; text-align: left;"
                     onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.05)';" 
                     onmouseout="this.style.borderColor='#eee'; this.style.transform='translateY(0)'; this.style.boxShadow='none';" >
                    
                    <!-- Event Image -->
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
                        <h3 style="font-size: 1.25rem; color: #333; margin-bottom: 1rem; font-weight: bold; min-height: 3rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $event->title }}
                        </h3>
                        
                        <div style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem; display: grid; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-calendar-day" style="color: var(--corporate-red); width: 14px;"></i>
                                {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-location-dot" style="color: var(--corporate-red); width: 14px;"></i>
                                {{ $event->location }}
                            </div>
                        </div>

                        <a href="{{ route('events.public.show', $event->id) }}" style="display: block; width: 100%; text-align: center; padding: 12px 0; border: 1.5px solid var(--corporate-red); color: var(--corporate-red); border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px;"
                           onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';"
                           onmouseout="this.style.background='transparent'; this.style.color='var(--corporate-red)';">
                            Register & View Details
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; padding: 80px 20px; background: #fafafa; border-radius: 12px; border: 1px dashed #ddd; color: #999;">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 1.5rem; display: block;"></i>
                    <p style="font-size: 1.1rem;">No results found matching your criteria.</p>
                    <a href="{{ route('home') }}" style="color: var(--corporate-red); margin-top: 10px; display: inline-block; font-weight: bold;">Browse All Events</a>
                </div>
            @endforelse
        </div>

        @if($events instanceof \Illuminate\Pagination\LengthAwarePaginator && $events->hasMorePages())
            <div style="margin-top: 60px;">
                <a href="{{ $events->nextPageUrl() }}" style="color: var(--corporate-red); font-weight: bold; text-decoration: none; font-size: 1rem; border: 1px solid var(--corporate-red); padding: 12px 30px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.background='var(--accent-soft-red)'">
                    Load More Events &nbsp; <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- HOW IT WORKS SECTION -->
    <div style="padding: 100px 0 60px; text-align: center; border-top: 1px solid #eee;">
        <div style="display: inline-block; margin-bottom: 4rem;">
            <h2 style="font-size: 2.2rem; color: #333; margin: 0; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">How the System Works</h2>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin: 15px auto 0;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 30px;">
            <div style="background: white; border: 1px solid #eee; border-radius: 15px; padding: 40px 30px; transition: 0.3s;" onmouseover="this.style.borderColor='var(--corporate-red)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1rem; opacity: 0.15;">01</div>
                <h3 style="font-size: 1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Acquire Access ID</h3>
                <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">Contact your Administrator to receive your unique verified Access ID.</p>
            </div>
            <div style="background: white; border: 1px solid #eee; border-radius: 15px; padding: 40px 30px; transition: 0.3s;" onmouseover="this.style.borderColor='var(--corporate-red)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1rem; opacity: 0.15;">02</div>
                <h3 style="font-size: 1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Browse Events</h3>
                <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">Review scheduled events and identify the ones you wish to attend.</p>
            </div>
            <div style="background: white; border: 1px solid #eee; border-radius: 15px; padding: 40px 30px; transition: 0.3s;" onmouseover="this.style.borderColor='var(--corporate-red)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1rem; opacity: 0.15;">03</div>
                <h3 style="font-size: 1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Confirm Attendance</h3>
                <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">Submit your Access ID on the portal to formally register your participation.</p>
            </div>
            <div style="background: white; border: 1px solid #eee; border-radius: 15px; padding: 40px 30px; transition: 0.3s;" onmouseover="this.style.borderColor='var(--corporate-red)';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1rem; opacity: 0.15;">04</div>
                <h3 style="font-size: 1rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Verify at Venue</h3>
                <p style="color: #666; font-size: 0.9rem; line-height: 1.6;">Bring your digital ticket QR code for professional verification at the event.</p>
            </div>
        </div>
    </div>
</div>
@endsection
