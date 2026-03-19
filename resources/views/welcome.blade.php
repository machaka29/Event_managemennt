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
<div style="background: var(--header-gradient); padding: 100px 20px; text-align: center; border-bottom: none; font-family: 'Century Gothic', sans-serif;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="font-weight: bold; font-size: 3.5rem; color: #333333; margin-bottom: 1.5rem; letter-spacing: -1px; line-height: 1.1;">
            FIND & REGISTER FOR<br><span style="color: var(--corporate-red);">AMAZING EVENTS</span>
        </h1>
        <p style="font-size: 1.25rem; color: #666666; margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            Discover events happening around Tanzania easily.<br>
            <span style="font-weight: bold;">No account needed</span> – Fast & Simple.
        </p>
        <a href="#events-list" class="btn" style="padding: 16px 50px; font-size: 1.1rem; border-radius: 5px; background-color: var(--corporate-red); color: white; text-decoration: none; font-weight: bold; display: inline-block; transition: transform 0.2s;">
            BROWSE EVENTS
        </a>
    </div>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    
    <!-- FIND EVENTS SECTION (Filters) -->
    <div style="background: #FFF5F5; padding: 60px 40px; border-radius: 15px; margin-bottom: 80px; text-align: center; border: 1px solid rgba(148, 0, 0, 0.1);">
        <div style="display: inline-block; margin-bottom: 3rem;">
            <h2 style="font-size: 2.2rem; color: #333333; margin: 0; font-weight: bold; text-transform: uppercase;">Find Events</h2>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin: 15px auto 0;"></div>
        </div>

        <form action="{{ route('home') }}#events-list" method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; text-align: left; margin-bottom: 40px;">
                <!-- Keyword -->
                <div>
                    <label style="display: block; color: var(--corporate-red); font-weight: bold; margin-bottom: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-magnifying-glass"></i> SEARCH BY KEYWORD
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="What are you looking for?" 
                           style="width: 100%; padding: 14px; border: 1px solid var(--corporate-red); border-radius: 6px; font-family: inherit; box-sizing: border-box;">
                </div>
                <!-- Date -->
                <div>
                    <label style="display: block; color: var(--corporate-red); font-weight: bold; margin-bottom: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-calendar-alt"></i> SELECT DATE
                    </label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           style="width: 100%; padding: 14px; border: 1px solid var(--corporate-red); border-radius: 6px; font-family: inherit; box-sizing: border-box;">
                </div>
                <!-- Location -->
                <div>
                    <label style="display: block; color: var(--corporate-red); font-weight: bold; margin-bottom: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-location-dot"></i> ALL LOCATIONS
                    </label>
                    <input type="text" name="location" value="{{ request('location') }}" list="tanzania-locations" placeholder="e.g. Moshi, Kilimanjaro" 
                           style="width: 100%; padding: 14px; border: 1px solid var(--corporate-red); border-radius: 6px; font-family: inherit; box-sizing: border-box;">
                    <datalist id="tanzania-locations">
                        <option value="Arusha">
                        <option value="Dar es Salaam">
                        <option value="Dodoma">
                        <option value="Geita">
                        <option value="Iringa">
                        <option value="Kagera">
                        <option value="Katavi">
                        <option value="Kigoma">
                        <option value="Kilimanjaro">
                        <option value="Lindi">
                        <option value="Manyara">
                        <option value="Mara">
                        <option value="Mbeya">
                        <option value="Morogoro">
                        <option value="Mtwara">
                        <option value="Mwanza">
                        <option value="Njombe">
                        <option value="Pemba North">
                        <option value="Pemba South">
                        <option value="Pwani">
                        <option value="Rukwa">
                        <option value="Ruvuma">
                        <option value="Shinyanga">
                        <option value="Simiyu">
                        <option value="Singida">
                        <option value="Songwe">
                        <option value="Tabora">
                        <option value="Tanga">
                        <option value="Zanzibar North">
                        <option value="Zanzibar South and Central">
                        <option value="Zanzibar West">
                        <option value="Moshi">
                        <option value="Kahama">
                        <option value="Songea">
                        <option value="Musoma">
                        <option value="Korogwe">
                        <option value="Kibaha">
                        <option value="Bariadi">
                        <option value="Mpanda">
                    </datalist>
                </div>
                <!-- Sort -->
                <div>
                    <label style="display: block; color: var(--corporate-red); font-weight: bold; margin-bottom: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-sort"></i> SORT BY
                    </label>
                    <select name="sort" style="width: 100%; padding: 14px; border: 1px solid var(--corporate-red); border-radius: 6px; font-family: inherit; background: white; box-sizing: border-box;">
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent First</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Upcoming Soonest</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn" style="padding: 16px 80px; font-size: 1.1rem; border-radius: 5px; background-color: var(--corporate-red); color: white; border: none; font-weight: bold; cursor: pointer; transition: background 0.3s;" 
                    onmouseover="this.style.background='#7a0000'" onmouseout="this.style.background='var(--corporate-red)'">
                APPLY FILTERS
            </button>
            @if(request()->anyFilled(['search', 'date', 'location', 'sort']))
                <div style="margin-top: 15px;">
                    <a href="{{ route('home') }}" style="color: #666; font-size: 0.9rem; text-decoration: underline;">Clear all filters</a>
                </div>
            @endif
        </form>
    </div>

    <!-- AVAILABLE EVENTS SECTION -->
    <div id="events-list" style="padding-bottom: 80px; text-align: center;">
        <div style="display: inline-block; margin-bottom: 3.5rem;">
            <h2 style="font-size: 2.2rem; color: #333333; margin: 0; font-weight: bold; text-transform: uppercase;">Available Events</h2>
            <p style="color: #666; margin-top: 10px; font-size: 1.1rem;">Explore events open for registration and join today!</p>
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
    <div style="padding: 80px 0; text-align: center; border-top: 1px solid #EEE;">
        <div style="display: inline-block; margin-bottom: 4rem;">
            <h2 style="font-size: 2.2rem; color: #333333; margin: 0; font-weight: bold; text-transform: uppercase;">How It Works</h2>
            <div style="width: 80px; height: 4px; background: var(--corporate-red); margin: 15px auto 0;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px;">
            <!-- Step 1 -->
            <div style="background: #FFFFFF; border: 1px solid var(--corporate-red); border-radius: 15px; padding: 40px 25px; transition: all 0.3s ease;"
                 onmouseover="this.style.background='var(--accent-soft-red)';" onmouseout="this.style.background='#FFFFFF';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem;">1</div>
                <h3 style="font-size: 1.2rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Register</h3>
                <p style="color: #666; font-size: 1rem; line-height: 1.5;">Fill out the quick registration form with your details.</p>
            </div>
            <!-- Step 2 -->
            <div style="background: #FFFFFF; border: 1px solid var(--corporate-red); border-radius: 15px; padding: 40px 25px; transition: all 0.3s ease;"
                 onmouseover="this.style.background='var(--accent-soft-red)';" onmouseout="this.style.background='#FFFFFF';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem;">2</div>
                <h3 style="font-size: 1.2rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Choose Event</h3>
                <p style="color: #666; font-size: 1rem; line-height: 1.5;">Pick amazing events to join from our global list.</p>
            </div>
            <!-- Step 3 -->
            <div style="background: #FFFFFF; border: 1px solid var(--corporate-red); border-radius: 15px; padding: 40px 25px; transition: all 0.3s ease;"
                 onmouseover="this.style.background='var(--accent-soft-red)';" onmouseout="this.style.background='#FFFFFF';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem;">3</div>
                <h3 style="font-size: 1.2rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Get Ticket</h3>
                <p style="color: #666; font-size: 1rem; line-height: 1.5;">Receive your instant digital ticket with a unique QR Code.</p>
            </div>
            <!-- Step 4 -->
            <div style="background: #FFFFFF; border: 1px solid var(--corporate-red); border-radius: 15px; padding: 40px 25px; transition: all 0.3s ease;"
                 onmouseover="this.style.background='var(--accent-soft-red)';" onmouseout="this.style.background='#FFFFFF';">
                <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red); margin-bottom: 1.5rem;">4</div>
                <h3 style="font-size: 1.2rem; color: #333; font-weight: bold; margin-bottom: 1rem; text-transform: uppercase;">Attend</h3>
                <p style="color: #666; font-size: 1rem; line-height: 1.5;">Show your QR Code at the entry and enjoy the event!</p>
            </div>
        </div>
    </div>
</div>
@endsection
