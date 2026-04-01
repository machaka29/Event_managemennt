@extends('layouts.app')

@section('title', 'Register for ' . $event->title . ' - EmCa Techonologies')

@section('content')
<div class="registration-page-wrapper">
    <div class="container py-5">
        
        <!-- Premium Breadcrumb/Back -->
        <div class="nav-back-container mb-4">
            @php
                $backUrl = route('home');
                $backText = 'Return to Events Explorer';
                if(auth()->check()) {
                    if(auth()->user()->role === 'admin') {
                        $backUrl = route('admin.dashboard');
                        $backText = 'Back to Admin Console';
                    } elseif(auth()->user()->role === 'organizer') {
                        $backUrl = route('dashboard');
                        $backText = 'Back to Organizer Hub';
                    }
                }
            @endphp
            <a href="{{ $backUrl }}" class="btn-back-link">
                <i class="fa-solid fa-arrow-left-long"></i> {{ $backText }}
            </a>
        </div>

        <div class="event-main-grid">
            <!-- Left Column: Content -->
            <div class="event-content-area">
                <div class="event-hero-image-card animate-in">
                    @if($event->image_path)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="hero-image">
                    @else
                        <div class="hero-image-placeholder">
                            <i class="fa-solid fa-calendar-star"></i>
                        </div>
                    @endif
                    <div class="event-category-badge">{{ $event->category->name ?? 'Special Event' }}</div>
                </div>

                <div class="event-description-card animate-in slow">
                    <h1 class="event-main-title">{{ $event->title }}</h1>
                    
                    <div class="event-summary-strip">
                        <div class="summary-item">
                            <i class="fa-solid fa-calendar-day"></i>
                            <div>
                                <span>DATE</span>
                                <strong>{{ \Carbon\Carbon::parse($event->date)->format('l, F d, Y') }}</strong>
                            </div>
                        </div>
                        <div class="summary-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <span>TIME</span>
                                <strong>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="description-content">
                        <h3 class="subsection-title">ABOUT THIS EXPERIENCE</h3>
                        <p>{{ $event->description }}</p>
                    </div>

                    <div class="venue-info-card">
                        <div class="venue-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="venue-text">
                            <h3>LOCATED AT</h3>
                            <p>{{ $event->location }}</p>
                            @if($event->venue)
                                <span class="venue-subtext">{{ $event->venue }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Registration Card -->
            <div class="registration-sidebar">
                <div class="sticky-card-wrapper">
                    <div class="registration-card animate-in-right">
                        <div class="card-header-accent"></div>
                        <div class="registration-card-body">
                            <div class="reg-header">
                                <div class="reg-icon-box">
                                    <i class="fa-solid fa-id-card-clip"></i>
                                </div>
                                <h2>Join the Event</h2>
                                <p>Fill in your details to secure your registration.</p>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger-premium">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger-premium">
                                    <ul class="error-list">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('events.public.register', $event->slug) }}" method="POST" class="premium-form">
                                @csrf
                                <div class="form-group-premium">
                                    <label>FULL NAME</label>
                                    <div class="input-wrapper">
                                        <i class="fa-solid fa-user"></i>
                                        <input type="text" name="full_name" placeholder="Enter your full name" required 
                                            pattern="^[a-zA-Z\s.-]+$" title="Name should only contain letters, spaces, dots or hyphens">
                                    </div>
                                </div>
                                
                                <div class="form-group-premium">
                                    <label>EMAIL ADDRESS</label>
                                    <div class="input-wrapper">
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="email" name="email" placeholder="you@example.com" required>
                                    </div>
                                </div>
                                
                                <div class="form-group-premium">
                                    <label>PHONE NUMBER</label>
                                    <div class="phone-input-group-premium">
                                        <span class="country-code">+255</span>
                                        <input type="tel" name="phone_number" placeholder="7XXXXXXXX" required 
                                            pattern="^[0-9]{9}$" maxlength="9" title="Please enter exactly 9 digits (e.g. 712XXXXXX)">
                                    </div>
                                    <small class="helper-text">Start with 7 or 6...</small>
                                </div>
                                
                                <div class="form-group-premium">
                                    <label>ORGANIZATION <span class="optional-tag">(OPTIONAL)</span></label>
                                    <div class="input-wrapper">
                                        <i class="fa-solid fa-building"></i>
                                        <input type="text" name="organization" placeholder="Your Company Ltd">
                                    </div>
                                </div>

                                <div class="registration-stats">
                                    <div class="stat-pill">
                                        <i class="fa-solid fa-users"></i>
                                        <span>{{ max(0, $event->capacity - $event->registrations()->count()) }} Spots Remaining</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn-register-premium">
                                    <span>CONFIRM REGISTRATION</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                                
                                <p class="secure-footer">
                                    <i class="fa-solid fa-shield-check"></i> Secure 256-bit encrypted registration
                                </p>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Need Help Card -->
                    <div class="help-micro-card mt-3">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Need assistance? <a href="#">Contact Organizer</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* PREMIUM REGISTRATION STYLES */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

.registration-page-wrapper {
    background-color: #f8fafc;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
}

.btn-back-link {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: #64748b;
    font-weight: 700;
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.2s;
    padding: 8px 0;
}
.btn-back-link i { transition: transform 0.2s; }
.btn-back-link:hover { color: var(--corporate-red); }
.btn-back-link:hover i { transform: translateX(-4px); }

.event-main-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 3rem;
}

@media (max-width: 1024px) {
    .event-main-grid { grid-template-columns: 1fr; }
    .registration-sidebar { order: -1; }
}

/* LEFT COLUMN */
.event-hero-image-card {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    height: 450px;
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
    margin-bottom: 2.5rem;
    background: #e2e8f0;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #cbd5e1;
    font-size: 5rem;
}

.event-category-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    color: #0f172a;
    padding: 8px 20px;
    border-radius: 12px;
    font-weight: 800;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.event-description-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.event-main-title {
    font-size: 3rem;
    font-weight: 900;
    color: #0f172a;
    line-height: 1.1;
    margin-bottom: 2rem;
    letter-spacing: -2px;
}

.event-summary-strip {
    display: flex;
    gap: 3rem;
    margin-bottom: 3rem;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 2rem;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 15px;
}
.summary-item i {
    width: 48px;
    height: 48px;
    background: var(--accent-soft-red);
    color: var(--corporate-red);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.25rem;
}
.summary-item span { font-size: 0.7rem; color: #94a3b8; font-weight: 800; letter-spacing: 1px; display: block; }
.summary-item strong { font-size: 1rem; color: #1e293b; font-weight: 700; }

.section-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px; }
.description-content p { color: #475569; line-height: 1.8; font-size: 1.1rem; margin-bottom: 2.5rem; }

.venue-info-card {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    gap: 20px;
}
.venue-icon { color: var(--corporate-red); font-size: 1.5rem; margin-top: 5px; }
.venue-text h3 { font-size: 0.8rem; font-weight: 800; color: #94a3b8; margin-bottom: 8px; letter-spacing: 1px; }
.venue-text p { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; }
.venue-subtext { color: #64748b; font-size: 0.9rem; margin-top: 5px; display: block; }

/* RIGHT COLUMN - REGISTRATION */
.sticky-card-wrapper {
    position: sticky;
    top: 100px;
}

.registration-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 30px 60px -12px rgba(0,0,0,0.15);
    border: 1px solid #f1f5f9;
}

.card-header-accent {
    height: 6px;
    background: linear-gradient(to right, var(--corporate-red), #ff4d4d);
}

.registration-card-body {
    padding: 2.5rem;
}

.reg-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.reg-icon-box {
    width: 64px;
    height: 64px;
    background: var(--accent-soft-red);
    color: var(--corporate-red);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 1.75rem;
}

.reg-header h2 { font-size: 1.5rem; font-weight: 900; color: #0f172a; margin-bottom: 8px; letter-spacing: -0.5px; }
.reg-header p { color: #64748b; font-size: 0.9rem; line-height: 1.5; }

/* FORM STYLES */
.form-group-premium { margin-bottom: 1.25rem; }
.form-group-premium label { font-size: 0.7rem; font-weight: 800; color: #94a3b8; letter-spacing: 1px; margin-bottom: 8px; display: block; }
.optional-tag { font-weight: 500; font-style: italic; opacity: 0.7; }

.input-wrapper { position: relative; }
.input-wrapper i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #CBD5E1; transition: color 0.2s; }

.premium-form input {
    width: 100%;
    padding: 14px 16px 14px 48px;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    font-size: 1rem;
    color: #1E293B;
    background: #F8FAFC;
    transition: all 0.2s;
}

.premium-form input:focus {
    background: white;
    border-color: var(--corporate-red);
    box-shadow: 0 0 0 4px var(--accent-soft-red);
    outline: none;
}
.premium-form input:focus + i { color: var(--corporate-red); }

/* PHONE INPUT */
.phone-input-group-premium {
    display: flex;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    overflow: hidden;
    background: #F8FAFC;
    transition: all 0.2s;
}
.phone-input-group-premium:focus-within {
    border-color: var(--corporate-red);
    box-shadow: 0 0 0 4px var(--accent-soft-red);
    background: white;
}
.country-code { padding: 14px 18px; background: #f1f5f9; color: #475569; font-weight: 900; font-size: 0.95rem; border-right: 1px solid #E2E8F0; }
.phone-input-group-premium input { padding-left: 16px; border: none; background: transparent; }

.helper-text { font-size: 0.7rem; color: #94a3b8; font-weight: 500; margin-top: 6px; display: block; }

/* ALERTS */
.alert-danger-premium {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #991B1B;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    font-size: 0.85rem;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}
.error-list { list-style: none; padding: 0; margin: 0; }

.registration-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 2rem 0;
}
.stat-pill { background: #f1f5f9; padding: 8px 16px; border-radius: 30px; font-size: 0.8rem; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 8px; }
.stat-pill i { color: var(--corporate-red); }
.price-tag { font-size: 1.25rem; font-weight: 900; color: #16a34a; }

.btn-register-premium {
    width: 100%;
    padding: 18px;
    background: var(--corporate-red);
    color: white;
    border: none;
    border-radius: 14px;
    font-weight: 900;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 10px 20px -5px rgba(148,0,0,0.3);
}
.btn-register-premium:hover { background: #7a0000; transform: translateY(-2px); box-shadow: 0 15px 30px -5px rgba(148,0,0,0.4); }

.secure-footer { text-align: center; font-size: 0.7rem; color: #94a3b8; margin-top: 1.5rem; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 6px; }
.secure-footer i { color: #16a34a; }

.help-micro-card {
    background: transparent;
    border: 1px dashed #cbd5e1;
    padding: 12px;
    border-radius: 12px;
    text-align: center;
    font-size: 0.8rem;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.help-micro-card a { color: var(--corporate-red); font-weight: 800; text-decoration: none; }

/* ANIMATIONS */
.animate-in { animation: fadeInUp 0.8s ease-out both; }
.animate-in.slow { animation-delay: 0.2s; }
.animate-in-right { animation: fadeInRight 0.8s ease-out 0.4s both; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .event-main-title { font-size: 2rem; }
    .event-description-card { padding: 1.5rem; }
    .event-summary-strip { flex-direction: column; gap: 1.5rem; }
    .registration-card-body { padding: 1.5rem; }
}
</style>
@endsection
