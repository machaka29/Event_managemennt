@extends('layouts.app')

@section('title', 'Find & Register for Amazing Events - EmCa Techonologies')

@section('content')
<!-- HERO SECTION -->
<div style="background: var(--hero-gradient); padding: 60px 0; border-bottom: 4px solid var(--corporate-red); position: relative;">
    <div class="container" style="text-align: center;">
        <h1 style="color: white; font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; letter-spacing: -1px; line-height: 1.1; text-transform: uppercase; margin-bottom: 1rem;">
            Event Attendance <br><span style="color: rgba(255,255,255,0.75);">Management Portal</span>
        </h1>
        <p style="color: rgba(255,255,255,0.9); margin-bottom: 2.5rem; max-width: 650px; margin-left: auto; margin-right: auto; font-size: 1.1rem; font-weight: 500;">
            Secure and reliable verification for all global events.
        </p>
        
        <!-- Search Form - Compact -->
        <div style="max-width: 500px; margin: 0 auto; background: white; padding: 5px; border-radius: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <form id="searchForm" action="{{ route('home') }}" method="GET" style="display: flex; width: 100%; align-items: center;" onsubmit="return false;">
                <input type="text" id="searchInput" name="search" placeholder="Search for events..." value="{{ request('search') }}" 
                    style="flex: 1; border: none; padding: 12px 20px; outline: none; font-size: 1rem; background: transparent; color: #1e293b; font-family: inherit;">
                
                <button type="button" id="searchBtn" class="btn btn-primary" style="height: 44px; padding: 0 25px; border-radius: 40px;">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container" style="padding: var(--section-gap) var(--container-padding);">
    
    <!-- UPCOMING EVENTS SECTION -->
    <div id="events-list" style="text-align: center;">
        <div style="margin-bottom: 3.5rem;">
            <h2 id="searchTitle" style="font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #1e293b;">
                {{ request('search') ? 'Search Results' : 'Upcoming Events' }}
            </h2>
            <p id="searchSubtitle" style="color: #64748b; margin-top: 8px;">{{ request('search') ? 'Found for "' . request('search') . '"' : 'Stay updated with scheduled events.' }}</p>
            <div style="width: 40px; height: 4px; background: var(--corporate-red); margin: 15px auto 0; border-radius: 2px;"></div>
        </div>

        <div class="event-grid" id="eventGrid">
            @forelse($events as $event)
                <div class="card" style="padding: 0; overflow: hidden; text-align: left;">
                    <!-- Event Image -->
                    <div style="height: 200px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                         @if($event->image_path)
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                           <i class="fa-solid {{ $event->category->icon ?? 'fa-calendar-day' }}" style="font-size: 3.5rem; color: #cbd5e1;"></i>
                        @endif
                        <div style="position: absolute; top: 15px; right: 15px; background: var(--corporate-red); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            {{ $event->category->name ?? 'Event' }}
                        </div>
                    </div>

                    <div style="padding: 25px; flex: 1; display: flex; flex-direction: column;">
                        <h3 style="font-size: 1.15rem; color: #1e293b; margin-bottom: 1rem; font-weight: 800; line-height: 1.3;">
                            {{ $event->title }}
                        </h3>
                        
                        <div style="color: #64748b; font-size: 0.85rem; margin-bottom: 2rem; display: grid; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-calendar" style="color: var(--corporate-red); width: 14px;"></i>
                                {{ \Carbon\Carbon::parse($event->date)->format('D, M d, Y') }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-location-dot" style="color: var(--corporate-red); width: 14px;"></i>
                                {{ $event->location }}
                            </div>
                        </div>

                        <a href="{{ route('events.public.show', $event->id) }}" class="btn btn-outline" style="width: 100%; margin-top: auto;">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; color: #94a3b8;">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>No results found matching your criteria.</p>
                    <a href="{{ route('home') }}" style="color: var(--corporate-red); font-weight: bold; margin-top: 10px; display: inline-block;">Browse All Events</a>
                </div>
            @endforelse
        </div>

        </div>

        <div id="loadMoreContainer" style="margin-top: 50px; display: {{ ($events instanceof \Illuminate\Pagination\LengthAwarePaginator && $events->hasMorePages()) ? 'block' : 'none' }};">
            <button id="loadMoreBtn" data-url="{{ $events instanceof \Illuminate\Pagination\LengthAwarePaginator ? $events->nextPageUrl() : '' }}" class="btn btn-primary" style="padding-left: 40px; padding-right: 40px;">
                Load More Events &nbsp; <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- AJAX Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            const eventGrid = document.getElementById('eventGrid');
            const loadMoreContainer = document.getElementById('loadMoreContainer');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const searchTitle = document.getElementById('searchTitle');
            const searchSubtitle = document.getElementById('searchSubtitle');
            
            let searchTimeout = null;
            let currentQuery = searchInput.value;

            function fetchEvents(query, url = null, append = false) {
                const targetUrl = url || `/api/events/search?search=${encodeURIComponent(query)}`;
                
                if (!append) {
                    eventGrid.style.opacity = '0.5';
                } else {
                    const originalText = loadMoreBtn.innerHTML;
                    loadMoreBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Loading...';
                    loadMoreBtn.disabled = true;
                }

                fetch(targetUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (append) {
                        eventGrid.innerHTML += data.html;
                    } else {
                        eventGrid.innerHTML = data.html || `
                            <div style="grid-column: 1 / -1; padding: 60px 20px; text-align: center; color: #94a3b8;">
                                <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <p>No results found matching your criteria.</p>
                            </div>`;
                        
                        if (query.trim() !== '') {
                            searchTitle.innerText = 'Search Results';
                            searchSubtitle.innerText = 'Found for "' + query + '"';
                        } else {
                            searchTitle.innerText = 'Upcoming Events';
                            searchSubtitle.innerText = 'Stay updated with scheduled events.';
                        }
                    }
                    
                    eventGrid.style.opacity = '1';

                    if (data.hasMorePages) {
                        loadMoreContainer.style.display = 'block';
                        loadMoreBtn.setAttribute('data-url', data.nextPageUrl + '&search=' + encodeURIComponent(query));
                    } else {
                        loadMoreContainer.style.display = 'none';
                    }

                    if (append) {
                        loadMoreBtn.innerHTML = 'Load More Events &nbsp; <i class="fa-solid fa-chevron-right"></i>';
                        loadMoreBtn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error('Failed to load events', err);
                    eventGrid.style.opacity = '1';
                    if (append) {
                        loadMoreBtn.innerHTML = 'Load More Events &nbsp; <i class="fa-solid fa-chevron-right"></i>';
                        loadMoreBtn.disabled = false;
                    }
                });
            }

            searchInput.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                currentQuery = e.target.value;
                searchTimeout = setTimeout(() => {
                    fetchEvents(currentQuery);
                }, 400); // 400ms delay for auto-search
            });

            searchBtn.addEventListener('click', function() {
                fetchEvents(searchInput.value);
            });

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const nextUrl = this.getAttribute('data-url');
                    fetchEvents(currentQuery, nextUrl, true);
                });
            }
        });
    </script>

    <!-- HOW IT WORKS SECTION -->
    <div style="padding: var(--section-gap) 0 40px; text-align: center; border-top: 1px solid #e2e8f0; margin-top: var(--section-gap);">
        <div style="margin-bottom: 4rem;">
            <h2 style="font-weight: 800; text-transform: uppercase; color: #1e293b;">How It Works</h2>
            <div style="width: 40px; height: 4px; background: var(--corporate-red); margin: 15px auto 0; border-radius: 2px;"></div>
        </div>

        <div class="stats-grid">
            <div class="card" style="padding: 35px 25px; border: 1px solid #e2e8f0;">
                <div style="font-size: 2.2rem; font-weight: 900; color: var(--corporate-red); margin-bottom: 0.5rem; opacity: 0.1;">01</div>
                <h3 style="font-size: 0.9rem; color: #1e293b; font-weight: 800; margin-bottom: 1rem; text-transform: uppercase;">Discover</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6;">Browse through our curated list of upcoming events and select the ones you love.</p>
            </div>
            <div class="card" style="padding: 35px 25px; border: 1px solid #e2e8f0;">
                <div style="font-size: 2.2rem; font-weight: 900; color: var(--corporate-red); margin-bottom: 0.5rem; opacity: 0.1;">02</div>
                <h3 style="font-size: 0.9rem; color: #1e293b; font-weight: 800; margin-bottom: 1rem; text-transform: uppercase;">Register</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6;">Quickly sign up on the event page by providing your basic contact information.</p>
            </div>
            <div class="card" style="padding: 35px 25px; border: 1px solid #e2e8f0;">
                <div style="font-size: 2.2rem; font-weight: 900; color: var(--corporate-red); margin-bottom: 0.5rem; opacity: 0.1;">03</div>
                <h3 style="font-size: 0.9rem; color: #1e293b; font-weight: 800; margin-bottom: 1rem; text-transform: uppercase;">Receive Ticket</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6;">Instantly grab your digital ticket with a unique QR code after confirming.</p>
            </div>
            <div class="card" style="padding: 35px 25px; border: 1px solid #e2e8f0;">
                <div style="font-size: 2.2rem; font-weight: 900; color: var(--corporate-red); margin-bottom: 0.5rem; opacity: 0.1;">04</div>
                <h3 style="font-size: 0.9rem; color: #1e293b; font-weight: 800; margin-bottom: 1rem; text-transform: uppercase;">Check In</h3>
                <p style="color: #64748b; font-size: 0.85rem; line-height: 1.6;">Show your digital ticket QR code at the event venue for fast and easy entry.</p>
            </div>
        </div>
    </div>
</div>
@endsection
