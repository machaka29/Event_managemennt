@extends('layouts.app')

@section('title', 'Welcome to EventPro')

@section('content')
<div class="page-header" style="text-align: center; padding: 4rem 1rem;">
    <h1 style="font-size: 3rem; margin-bottom: 1rem;">Find Your Next Event</h1>
    <p style="font-size: 1.25rem; color: var(--text-muted); max-width: 600px; margin: 0 auto 2rem;">
        Discover and register for the best events happening around you.
    </p>
    
    <!-- Search Form -->
    <div class="card" style="max-width: 800px; margin: 0 auto; padding: 1.5rem;">
        <form action="{{ route('home') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <input type="text" name="search" class="form-control" placeholder="Search events by title or location..." value="{{ request('search') }}" style="flex: 2; min-width: 250px;">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="flex: 1; min-width: 150px;">
            <button type="submit" class="btn btn-primary" style="flex: 0.5; min-width: 100px;">Search</button>
        </form>
    </div>
</div>

<div class="container" style="padding: 4rem 0;">
    @if(request('search') || request('date'))
        <div style="margin-bottom: 2rem;">
            <h3>Search Results @if(isset($events)) ({{ $events->count() }}) @endif</h3>
            <a href="{{ route('home') }}" style="color: var(--corporate-red); text-decoration: none; font-size: 0.9rem;">Clear filters</a>
        </div>
    @endif

    <div class="grid grid-cols-3">
        @forelse($events as $event)
            <div class="card">
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
                    $isOpen = now()->between($event->reg_start_date, $event->reg_end_date);
                @endphp

                @if($isFull)
                    <button class="btn btn-outline" disabled style="width: 100%; border-color: grey; color: grey;">Sold Out</button>
                @elseif(!$isOpen)
                    <button class="btn btn-outline" disabled style="width: 100%; border-color: grey; color: grey;">Registration Closed</button>
                @else
                    <a href="{{ route('events.public.show', $event->id) }}" class="btn btn-primary" style="width: 100%; text-align: center;">Register Now</a>
                @endif
            </div>
        @empty
            <div style="grid-column: span 3; text-align: center; padding: 4rem;">
                <p style="color: var(--text-muted); font-size: 1.2rem;">No events found matching your criteria.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
