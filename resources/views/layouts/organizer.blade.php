<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Organizer Panel - EmCa Techonologies')</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts & Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        :root {
            --corporate-red: #940000;
            --accent-soft-red: #FFF5F5;
            --header-gradient: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
        }

        body, h1, h2, h3, h4, h5, h6, p, span, a, div, input, button, select, textarea {
            font-family: 'Century Gothic', sans-serif !important;
        }

        body {
            background-color: #FFFFFF;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Fixed Navigation */
        .org-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: #FFFFFF;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        .org-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--corporate-red);
            transition: opacity 0.3s;
        }

        .org-logo:hover {
            opacity: 0.8;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .user-profile-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px 16px;
            border-radius: 12px;
            transition: background 0.3s;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .user-profile-card:hover {
            background: #fafafa;
            border-color: #eee;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            display: block;
            font-weight: 800;
            color: #1a1a1a;
            font-size: 0.95rem;
            line-height: 1.2;
        }

        .user-role {
            display: block;
            font-size: 0.75rem;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-btn {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFF5F5;
            color: var(--corporate-red);
            border: 1px solid #f9dcdc;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1.2rem;
        }

        .logout-btn:hover {
            background: var(--corporate-red);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(148, 0, 0, 0.2);
        }

        /* Layout Container */
        .main-wrapper {
            display: flex;
            margin-top: 80px; 
        }

        .sidebar {
            width: 280px;
            height: calc(100vh - 80px);
            background: #FFFFFF;
            border-right: 1px solid #eee;
            position: fixed;
            top: 80px;
            left: 0;
            padding: 40px 0;
            z-index: 1001; /* Above Nav */
            overflow-y: auto;
            transition: transform 0.3s ease;
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 40px;
            text-decoration: none;
            color: #666;
            font-weight: 600;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-size: 0.95rem;
        }

        .sidebar-link:hover {
            background: #FFF5F5;
            color: var(--corporate-red);
        }

        .sidebar-link.active {
            background: var(--accent-soft-red);
            color: var(--corporate-red);
            border-left: 4px solid var(--corporate-red);
            font-weight: 800;
        }

        /* Main Content Area */
        .content-area {
            flex: 1;
            margin-left: 0;
            padding: 40px;
            background-color: #fafafa;
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        .content-wrapper {
            max-width: 1300px;
            margin: 0 auto;
            width: 100%;
        }

        @media (min-width: 993px) {
            body.sidebar-open .content-area {
                margin-left: 280px;
            }
        }

        .content-container {
            width: 100%;
            margin: 0;
        }

        /* Footer Styles */
        .dashboard-footer {
            margin-top: 80px;
            padding: 40px 0;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-link {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: var(--corporate-red);
        }

        .copyright {
            color: #aaa;
            font-size: 0.85rem;
        }

        .powered-by {
            margin-top: 10px;
            color: #777;
            font-weight: 700;
            font-size: 0.85rem;
        }

        @media (max-width: 1200px) and (min-width: 993px) {
            .sidebar { width: 240px; }
            body.sidebar-open .content-area { margin-left: 240px; }
        }

        @media (max-width: 992px) {
            .sidebar { 
                top: 0;
                height: 100vh;
                padding-top: 0;
                box-shadow: 5px 0 15px rgba(0,0,0,0.1);
                z-index: 1100;
            }
            .sidebar-backdrop.show { display: block; z-index: 1099; }
            
            .nav-right {
                display: none !important;
            }

            .mobile-sidebar-header {
                display: flex !important;
            }
        }

        /* Mobile Sidebar Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 850;
            backdrop-filter: blur(2px);
        }

        .sidebar-backdrop.show {
            display: block;
        }

        .hamburger {
            display: flex;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .hamburger:hover {
            background: var(--accent-soft-red);
            border-color: var(--corporate-red);
        }

        .hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--corporate-red);
            border-radius: 2px;
        }

        @media (max-width: 992px) {
            .mobile-only {
                display: flex !important;
            }
            .org-nav {
                justify-content: space-between !important;
                padding-right: 20px !important;
            }
        }

        /* Password Toggle Styles */
        .password-container {
            position: relative;
            width: 100%;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.3s;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 5px;
        }
        .password-toggle:hover {
            color: var(--corporate-red);
        }
    </style>
</head>
<body class="sidebar-open">
    <nav class="org-nav" style="background: var(--header-gradient); border-bottom: 1px solid #e2e8f0; height: 70px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="{{ route('dashboard') }}" class="org-logo">
                <div style="width: 40px; height: 40px; border-radius: 6px; background: white; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div style="margin-right: 10px;">
                    <span style="font-weight: 800; font-size: 1.1rem; color: #1a1a1a;">EmCa Techonologies</span><br>
                    <span style="font-weight: 700; font-size: 0.65rem; text-transform: uppercase; color: var(--corporate-red); letter-spacing: 1px;">Organizer Panel</span>
                </div>
            </a>
            <!-- Hamburger AFTER Logo -->
            <div class="hamburger" onclick="toggleSidebar()" style="z-index: 1050; margin-left: 5px;">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <!-- Mobile Logout -->
        <div class="mobile-only" style="display: none;">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: var(--accent-soft-red); color: var(--corporate-red); border: 1px solid #f9dcdc; border-radius: 8px; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
        
        <!-- Global Tools (Search, Notifications, Profile) -->
        <div class="nav-right" style="flex: 1; display: flex; justify-content: flex-end; align-items: center; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 15px; flex: 1; max-width: 500px; justify-content: flex-end;">
                <!-- Global Search -->
                <form action="{{ route('organizer.search') }}" method="GET" style="flex: 1; min-width: 250px; position: relative;">
                    <i class="fa-solid fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                    <input type="text" name="query" placeholder="Search my events, members..." 
                        required
                        value="{{ request('query') }}"
                        style="width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #e2e8f0; border-radius: 20px; font-size: 0.85rem; outline: none; background: #fff; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.02);"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.05)';"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.02)';" id="globalSearchInput">
                </form>

                <!-- Notification Bell & Dropdown -->
                <div style="position: relative;" id="notifDropdownContainer">
                    @php 
                        $myEventIds = auth()->user()->events()->pluck('id');
                        $unreadRegistrations = \App\Models\Registration::with(['attendee', 'event'])->whereIn('event_id', $myEventIds)->where('is_read', false)->latest()->take(5)->get();
                        $unreadCount = \App\Models\Registration::whereIn('event_id', $myEventIds)->where('is_read', false)->count(); 
                    @endphp
                    <button onclick="toggleNotifDropdown(event)" style="background: #f8fafc; color: #475569; width: 42px; height: 42px; border-radius: 50%; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; position: relative;" title="New Registrations">
                        <i class="fa-solid fa-bell"></i>
                        @if($unreadCount > 0)
                            <span style="position: absolute; top: -2px; right: -2px; background: #ef4444; color: white; font-size: 0.65rem; min-width: 18px; height: 18px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white;">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="notifDropdown" style="display: none; position: absolute; top: 52px; right: 0; width: 320px; background: white; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1001; overflow: hidden;">
                        <div style="padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                            <h4 style="margin: 0; font-size: 0.85rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Notifications</h4>
                            <span style="font-size: 0.65rem; background: var(--corporate-red); color: white; padding: 2px 8px; border-radius: 10px; font-weight: 800;">NEW</span>
                        </div>
                        
                        <div style="max-height: 350px; overflow-y: auto;">
                            @if($unreadRegistrations->count() > 0)
                                @foreach($unreadRegistrations as $notif)
                                    <a href="{{ route('organizer.registrations.index') }}" style="display: block; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                                        <div style="font-size: 0.85rem; color: #1e293b; font-weight: 700; line-height: 1.4;">
                                            {{ $notif->attendee->full_name }} <span style="font-weight: 500; color: #64748b;">registered for</span> {{ $notif->event->title }}
                                        </div>
                                        <div style="font-size: 0.65rem; color: #94a3b8; margin-top: 5px; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                            <i class="fa-solid fa-clock"></i> {{ $notif->created_at->diffForHumans() }}
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                                    <i class="fa-solid fa-bell-slash" style="font-size: 2rem; opacity: 0.2; margin-bottom: 10px;"></i>
                                    <div style="font-size: 0.85rem; font-weight: 700;">No new notifications</div>
                                    <div style="font-size: 0.7rem; margin-top: 5px;">You're all caught up!</div>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('organizer.registrations.index') }}" style="display: block; padding: 12px; text-align: center; font-size: 0.75rem; color: var(--corporate-red); font-weight: 800; text-decoration: none; background: #fff; border-top: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#fcf2f2';" onmouseout="this.style.background='white';">
                            VIEW ALL ACTIVITY
                        </a>
                    </div>
                </div>

                <!-- Profile Link -->
                <a href="{{ route('profile.show') }}" style="width: 42px; height: 42px; border-radius: 50%; overflow: hidden; border: 2px solid var(--accent-soft-red); display: block; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">
        <aside class="sidebar">

            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grip-vertical"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('organizer.events.index') }}" class="sidebar-link {{ request()->routeIs('organizer.events.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-plus"></i>
                <span>My Events</span>
            </a>
            <a href="{{ route('organizer.registrations.index') }}" class="sidebar-link {{ request()->routeIs('organizer.registrations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-group"></i>
                <span>Attendees</span>
            </a>


            <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i>
                <span>Settings</span>
            </a>
            
            <div style="position: absolute; bottom: 120px; left: 0; right: 0; padding: 0 40px;">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="sidebar-link" style="width: 100%; background: #fff5f5; color: #940000; border: 1px solid #fecaca; border-radius: 10px; cursor: pointer; padding: 12px 20px; text-decoration: none; display: flex; align-items: center; gap: 12px; font-weight: 800;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

            <div style="position: absolute; bottom: 40px; left: 40px;">
                <p style="font-size: 0.75rem; color: #bbb; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Status: Online</p>
                <p style="font-size: 0.7rem; color: #ccc;">Organizer Panel v1.2</p>
            </div>
        </aside>

        <main class="content-area">
            <div class="content-container content-wrapper">
                @yield('content')

                <footer style="margin-top: 60px; padding: 40px 0; border-top: 3px solid var(--corporate-red); background: white;">
                    <div style="display: flex; justify-content: center; gap: 25px; margin-bottom: 20px;">
                        <a href="javascript:void(0)" style="color: #666; text-decoration: none; font-size: 0.85rem; font-weight: 700;">About Us</a>
                        <a href="javascript:void(0)" style="color: #666; text-decoration: none; font-size: 0.85rem; font-weight: 700;">Help Center</a>
                        <a href="javascript:void(0)" style="color: #666; text-decoration: none; font-size: 0.85rem; font-weight: 700;">Privacy</a>
                    </div>
                    <div style="text-align: center;">
                        <p style="margin: 0; color: #1a1a1a; font-size: 0.9rem; font-weight: 800;">&copy; {{ date('Y') }} {{ \App\Models\SystemSetting::get('system_name', 'EmCa Techonologies') }}</p>
                        <p style="margin: 5px 0 0; color: var(--corporate-red); font-size: 0.7rem; font-weight: 800; letter-spacing: 1px;">{{ \App\Models\SystemSetting::get('system_footer', 'EmCa Techonologies') }}</p>
                    </div>
                </footer>
            </div>
        </main>
    </div>
    <div id="sidebar-backdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <script>
        // Set initial sidebar state
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth > 992) {
                document.querySelector('.sidebar').classList.add('show');
            } else {
                document.body.classList.remove('sidebar-open');
            }
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('show');
            document.body.classList.toggle('sidebar-open');
            
            if (window.innerWidth <= 992) {
                backdrop.classList.toggle('show');
                // Lock body scroll when sidebar is open on mobile
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
        }

        function toggleNotifDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('notifDropdown');
            const isOpening = dropdown.style.display === 'none';
            dropdown.style.display = isOpening ? 'block' : 'none';
            
            if (isOpening) {
                // Hide badge
                const badge = event.currentTarget.querySelector('span');
                if (badge) badge.style.display = 'none';
                
                // Keep 'NEW' label logic simple, but we can also hide 'NEW' if we want:
                const newLabel = dropdown.querySelector('span');
                if (newLabel && newLabel.innerText === 'NEW') newLabel.style.display = 'none';

                fetch('{{ route("notifications.markRead") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).catch(err => console.error(err));
            }
        }

        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Close dropdowns on outside click
        window.onclick = function(event) {
            const dropdown = document.getElementById('notifDropdown');
            const container = document.getElementById('notifDropdownContainer');
            if (dropdown && !container.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        }

        // Close sidebar when clicking links on mobile
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>
