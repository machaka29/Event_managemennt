@extends('layouts.app')

@section('title', 'Discover & Register for Amazing Events - EmCa Techonologies')

@section('content')
<style>
    /* ═══ ANIMATIONS ═══ */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes tickBounce {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-on-scroll {
        opacity: 0; transform: translateY(25px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .animate-on-scroll.visible { opacity: 1; transform: translateY(0); }
    .stagger-1 { transition-delay: 0.08s; }
    .stagger-2 { transition-delay: 0.16s; }
    .stagger-3 { transition-delay: 0.24s; }
    .stagger-4 { transition-delay: 0.32s; }
    .stagger-5 { transition-delay: 0.40s; }
    .stagger-6 { transition-delay: 0.48s; }

    /* ═══ HERO ═══ */
    .hero {
        background: linear-gradient(135deg, #7a0000 0%, var(--corporate-red) 50%, #b30000 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        padding: 100px 0 80px;
        color: white;
        text-align: center;
        position: relative;
    }
    .hero::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0; right: 0;
        height: 60px;
        background: linear-gradient(to top, #FFF5F5, transparent);
    }
    .hero-content { position: relative; z-index: 2; }
    .hero-tag {
        display: inline-block;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin-bottom: 22px;
        animation: fadeInUp 0.7s ease-out;
    }
    .hero h1 {
        font-size: clamp(1.9rem, 5vw, 3.2rem);
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 18px;
        animation: fadeInUp 0.7s ease-out 0.1s both;
        letter-spacing: -1px;
    }
    .hero h1 .highlight {
        background: linear-gradient(135deg, #FF8C00, #FFB347, #FF6B00);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hero p {
        font-size: 1.05rem;
        color: rgba(255,255,255,0.85);
        max-width: 650px;
        margin: 0 auto 35px;
        line-height: 1.7;
        animation: fadeInUp 0.7s ease-out 0.2s both;
    }

    /* ═══ SEARCH BAR ═══ */
    .search-bar {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 10px;
        border-radius: 50px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 10px;
        box-shadow: 0 15px 35px rgba(148,0,0,0.08);
        animation: fadeInUp 0.7s ease-out 0.3s both;
        position: relative;
        z-index: 2;
    }
    .s-field { position: relative; }
    .s-field i {
        position: absolute; left: 14px; top: 50%;
        transform: translateY(-50%); font-size: 0.85rem;
    }
    .s-field input {
        width: 100%; border: none;
        padding: 13px 12px 13px 40px;
        outline: none; font-size: 0.9rem;
        color: #1e293b; font-family: inherit;
        background: #f8fafc; border-radius: 9px;
    }
    .s-field input:focus { background: #f1f5f9; }
    .s-field input::placeholder { color: #94a3b8; }
    .s-btn {
        padding: 0 28px; border-radius: 9px;
        font-weight: 800; font-size: 0.82rem;
        border: none; cursor: pointer;
        background: #940000; color: white;
        font-family: inherit; text-transform: uppercase;
        transition: all 0.3s; white-space: nowrap;
    }
    .s-btn:hover {
        background: #B30000; transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(148,0,0,0.35);
    }



    /* ═══ SECTION REUSABLES ═══ */
    .section-head {
        text-align: center; margin-bottom: 40px;
    }
    .section-head .badge {
        display: inline-block; background: #FFF5F5;
        color: #940000; padding: 6px 18px; border-radius: 50px;
        font-weight: 800; font-size: 0.72rem; margin-bottom: 12px;
        border: 1px solid rgba(148,0,0,0.06);
    }
    .section-head h2 {
        font-size: clamp(1.3rem, 2.5vw, 1.9rem);
        font-weight: 900; color: #1e293b;
        text-transform: uppercase; margin-bottom: 0;
    }
    .section-head .line {
        width: 45px; height: 4px; background: #940000;
        margin: 14px auto 0; border-radius: 10px;
    }

    /* ═══ EVENT CARDS ═══ */
    .ev-section { padding: 70px 0; background: #fff; }
    .ev-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .ev-card {
        background: white; border-radius: 14px;
        overflow: hidden; border: 1px solid #e2e8f0;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .ev-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(148,0,0,0.1);
    }
    .ev-img {
        height: 190px; background-size: cover;
        background-position: center; position: relative;
    }
    .ev-tag {
        position: absolute; top: 12px; left: 12px;
        padding: 4px 12px; border-radius: 5px;
        font-weight: 800; font-size: 0.68rem;
        color: white; text-transform: uppercase; z-index: 1;
    }
    .ev-tag.hot { background: #e74c3c; }
    .ev-tag.trend { background: #940000; }
    .ev-tag.new { background: #3498db; }
    .ev-spots {
        position: absolute; top: 12px; right: 12px;
        background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
        color: white; padding: 4px 10px; border-radius: 5px;
        font-size: 0.68rem; font-weight: 700;
    }
    .ev-body { padding: 20px; }
    .ev-body h3 {
        font-size: 1.05rem; font-weight: 800;
        color: #1e293b; margin-bottom: 12px;
    }
    .ev-meta {
        display: grid; gap: 6px;
        margin-bottom: 16px; color: #64748b; font-size: 0.82rem;
    }
    .ev-meta span { display: flex; align-items: center; gap: 7px; }
    .ev-meta i { width: 14px; color: #940000; font-size: 0.78rem; }
    .ev-strip {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 14px; background: #f8fafc;
        border-radius: 8px; margin-bottom: 14px;
    }
    .ev-strip .filling {
        font-size: 0.76rem; font-weight: 700; color: #e67e22;
    }
    .ev-strip .free {
        font-size: 0.73rem; font-weight: 800; color: #16a34a;
        background: #f0fdf4; padding: 3px 10px; border-radius: 16px;
        border: 1px solid #bbf7d0;
    }
    .ev-btn {
        display: block; width: 100%; padding: 12px;
        border: none; border-radius: 8px;
        font-weight: 800; font-size: 0.82rem;
        cursor: pointer; text-align: center; text-decoration: none;
        text-transform: uppercase; font-family: inherit;
        background: #940000; color: white;
        transition: all 0.3s;
        box-shadow: 0 3px 12px rgba(148,0,0,0.15);
    }
    .ev-btn:hover {
        background: #B30000; transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(148,0,0,0.25);
    }

    /* ═══ WHY US ═══ */
    .why-section { padding: 70px 0; background: #f8fafc; }
    .why-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .why-card {
        text-align: center; padding: 32px 22px;
        border: 1px solid #e2e8f0; background: white;
        border-radius: 14px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .why-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(148,0,0,0.06);
    }
    .why-icon {
        width: 60px; height: 60px;
        background: #fdf2f2; color: #940000; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 1.4rem;
        transition: all 0.3s;
    }
    .why-card:hover .why-icon {
        background: #940000; color: white; transform: scale(1.08);
    }
    .why-card h3 {
        font-size: 0.85rem; font-weight: 800; color: #1e293b;
        margin-bottom: 10px; text-transform: uppercase;
    }
    .why-card p {
        color: #64748b; font-size: 0.82rem;
        line-height: 1.6; margin: 0;
    }


    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 1024px) {
        .ev-grid { grid-template-columns: repeat(2, 1fr); }
        .why-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .hero { padding: 80px 0 65px; }
        .hero h1 { font-size: 1.6rem; }
        .hero p { font-size: 0.92rem; margin-bottom: 25px; }
        .search-bar {
            grid-template-columns: 1fr; padding: 10px; border-radius: 16px; gap: 8px;
        }
        .s-field input { border-radius: 8px; padding: 14px 12px 14px 40px; }
        .s-btn { width: 100%; height: 48px; border-radius: 8px; }
        .hero-badges { flex-direction: column; gap: 6px; }
        .hero-badges .dot { display: none; }
        .stats-row { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .stat-num { font-size: 1.4rem; }
        .ev-grid, .why-grid { grid-template-columns: 1fr; max-width: 380px; margin: 0 auto; }
        .testi-grid { grid-template-columns: 1fr; }
        .section-head h2 { font-size: 1.2rem; }
        .ev-section, .why-section, .testi-section, .email-section { padding: 50px 0; }
        .email-form { flex-direction: column; }
        .email-form button { padding: 12px; border-radius: 8px; }
    }
</style>

<!-- ═══════════ HERO ═══════════ -->
<div class="hero">
    <div class="container hero-content">
        <div class="hero-tag">Event Registration Platform</div>
        <h1>
            <span class="highlight">Discover & Register for Amazing Events Near You</span>
        </h1>
        <p>Join 10,000+ attendees who found their next unforgettable experience. Browse events, register in seconds — no account needed!</p>

        <form action="{{ route('home') }}#events-list" method="GET" class="search-bar">
            <div class="s-field" style="border-right: none;">
                <i class="fa-solid fa-search" style="color: #940000; font-size: 1.1rem;"></i>
                <input type="text" name="search" placeholder="Search events, organizers, location..." value="{{ request('search') }}" style="font-size: 0.95rem;">
            </div>
            <button type="submit" class="s-btn" style="padding: 0 35px;"><i class="fa-solid fa-magnifying-glass"></i>&nbsp; SEARCH</button>
        </form>


    </div>
</div>



<!-- ═══════════ FEATURED EVENTS ═══════════ -->
<div id="events-list" class="ev-section">
    <div class="container">
        <div class="section-head animate-on-scroll">
            <h2 style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <i class="fa-regular fa-calendar-check" style="color: #940000;"></i> Upcoming Events
            </h2>
            <div class="line"></div>
        </div>

        <div class="ev-grid">
            @forelse($events as $index => $event)
            <div class="ev-card animate-on-scroll stagger-{{ ($index % 3) + 1 }}">
                <div class="ev-img" style="background-image: url('{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('images/placeholder-event.png') }}'); background-color: #f1f5f9;">
                    <span class="ev-tag {{ $index == 0 ? 'hot' : ($index == 1 ? 'trend' : 'new') }}">
                        @if($index == 0) 🔥 Featured @elseif($index == 1) 🎉 Trending @else 💼 New @endif
                    </span>
                    <span class="ev-spots"><i class="fa-solid fa-users"></i> {{ max(0, $event->capacity - $event->registrations()->count()) }} left</span>
                </div>
                <div class="ev-body">
                    <h3>{{ \Illuminate\Support\Str::limit($event->title, 40) }}</h3>
                    <div class="ev-meta">
                        <span><i class="fa-solid fa-calendar-days"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                        <span><i class="fa-solid fa-location-dot"></i> {{ \Illuminate\Support\Str::limit($event->location, 25) }}</span>
                    </div>
                    <div class="ev-strip">
                        @php
                            $spotsLeft = $event->capacity - $event->registrations()->count();
                        @endphp
                        @if($spotsLeft <= 0)
                            <span class="filling" style="color: #e74c3c;"><i class="fa-solid fa-ban"></i> Fully Booked</span>
                        @elseif($spotsLeft <= 10)
                            <span class="filling"><i class="fa-solid fa-fire"></i> Filling fast!</span>
                        @else
                            <span class="filling" style="color: #2ecc71;"><i class="fa-solid fa-check-circle"></i> Available</span>
                        @endif
                        <span class="free">✓ Free Registration</span>
                    </div>
                    @if($spotsLeft > 0)
                        <a href="{{ route('events.public.show', $event->slug) }}" class="ev-btn">REGISTER NOW</a>
                    @else
                        <button class="ev-btn" style="background: #94a3b8; cursor: not-allowed;" disabled>SOLD OUT</button>
                    @endif
                </div>
            </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 15px; color: #cbd5e1;"></i>
                    <h4>No upcoming events found at this time.</h4>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- ═══════════ HOW IT WORKS ═══════════ -->
<div class="how-it-works" style="padding: 70px 0; background: white;">
    <div class="container">
        <div class="section-head animate-on-scroll">
            <h2>How It Works</h2>
            <div class="line"></div>
        </div>
        <div class="why-grid" style="grid-template-columns: repeat(3, 1fr); margin-top: 40px;">
            <div class="why-card animate-on-scroll stagger-1" style="border: none; background: #fafafa;">
                <div style="font-size: 3rem; font-weight: 900; color: rgba(148,0,0,0.1); position: absolute; top: 10px; right: 20px;">01</div>
                <div class="why-icon" style="background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.05);"><i class="fa-solid fa-magnifying-glass"></i></div>
                <h3 style="font-size: 1rem;">Find Your Event</h3>
                <p>Browse and pick the event you want to attend.</p>
            </div>
            <div class="why-card animate-on-scroll stagger-2" style="border: none; background: #fafafa;">
                <div style="font-size: 3rem; font-weight: 900; color: rgba(148,0,0,0.1); position: absolute; top: 10px; right: 20px;">02</div>
                <div class="why-icon" style="background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.05);"><i class="fa-solid fa-user-pen"></i></div>
                <h3 style="font-size: 1rem;">Quick Registration</h3>
                <p>Register in seconds. No account or password needed.</p>
            </div>
            <div class="why-card animate-on-scroll stagger-3" style="border: none; background: #fafafa;">
                <div style="font-size: 3rem; font-weight: 900; color: rgba(148,0,0,0.1); position: absolute; top: 10px; right: 20px;">03</div>
                <div class="why-icon" style="background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.05);"><i class="fa-solid fa-paper-plane"></i></div>
                <h3 style="font-size: 1rem;">Get Your QR Ticket</h3>
                <p>Receive your ticket on your phone instantly.</p>
            </div>
        </div>
    </div>
</div>




<!-- ═══════════ SCRIPTS ═══════════ -->
<script>
(function() {
    // Scroll reveal
    var io = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.animate-on-scroll').forEach(function(el) { io.observe(el); });

    // Counting numbers
    var done = false;
    var po = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting && !done) {
                done = true;
                document.querySelectorAll('.stat-num[data-count]').forEach(function(el) {
                    var target = parseInt(el.getAttribute('data-count'));
                    var suffix = el.getAttribute('data-suffix') || '+';
                    var cur = 0, inc = target / 45;
                    var t = setInterval(function() {
                        cur += inc;
                        if (cur >= target) { cur = target; clearInterval(t); }
                        el.textContent = Math.floor(cur).toLocaleString() + suffix;
                    }, 40);
                });
            }
        });
    }, { threshold: 0.25 });
    var bar = document.querySelector('.stats-bar');
    if (bar) po.observe(bar);
})();
</script>
@endsection
