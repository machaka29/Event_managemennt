<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Organizer Panel - ' . config('app.name', 'EventReg'))</title>
    
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
            z-index: 900;
            overflow-y: auto;
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
            margin-left: 280px;
            padding: 40px;
            background-color: #fafafa;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Collapsed Sidebar State - DESKTOP ONLY */
        @media (min-width: 993px) {
            body.sidebar-collapsed .sidebar {
                width: 80px;
            }
            body.sidebar-collapsed .content-area {
                margin-left: 80px;
            }
            body.sidebar-collapsed .sidebar-text,
            body.sidebar-collapsed .org-logo div:last-child,
            body.sidebar-collapsed .logout-btn-text {
                display: none;
            }
            body.sidebar-collapsed .sidebar-link {
                justify-content: center;
                padding: 14px 0;
                border-left-width: 0;
                border-bottom: 4px solid transparent;
            }
            body.sidebar-collapsed .sidebar-link.active {
                border-bottom-color: var(--corporate-red);
                background: var(--accent-soft-red);
            }
            body.sidebar-collapsed .sidebar-link i {
                font-size: 1.4rem;
                margin: 0;
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

        @media (max-width: 1200px) {
            .sidebar { width: 240px; }
            .content-area { margin-left: 240px; }
        }

        @media (max-width: 992px) {
            .sidebar { 
                left: -280px; 
                transition: left 0.3s ease;
                box-shadow: 5px 0 15px rgba(0,0,0,0.1);
            }
            .sidebar.show {
                left: 0;
            }
            .content-area { margin-left: 0; padding: 20px; }
            
            .hamburger {
                display: flex !important;
            }
            
            .nav-right {
                display: none !important;
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
    </style>
</head>
<body>
    <nav class="org-nav" style="background: var(--header-gradient); border-bottom: 1px solid #e2e8f0; height: 70px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div class="hamburger" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="{{ route('dashboard') }}" class="org-logo">
                <div style="width: 40px; height: 40px; border-radius: 6px; background: white; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
                    @if($systemLogo)
                        <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                    @endif
                </div>
                <div>
                    <span style="font-weight: 800; font-size: 1.1rem; color: #1a1a1a; text-transform: none;">EmCa Techonology</span><br>
                    <span style="font-weight: 700; font-size: 0.65rem; text-transform: none; color: var(--corporate-red); letter-spacing: 1px;">Organizer Panel</span>
                </div>
            </a>
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
        
        <div class="nav-right">
            <div style="display: flex; align-items: center; gap: 20px;">
                <!-- NOTIFICATIONS BELL -->
                @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                <div style="position: relative;" id="notificationWrapper">
                    <button onclick="toggleNotifications()" style="background: #f5f5f5; border: none; width: 40px; height: 40px; border-radius: 50%; color: #666; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; position: relative; transition: all 0.3s;" onmouseover="this.style.background='#eee';">
                        <i class="fa-solid fa-bell"></i>
                        @if($unreadCount > 0)
                            <span style="position: absolute; top: -2px; right: -2px; background: var(--corporate-red); color: white; border-radius: 50%; width: 16px; height: 16px; font-size: 0.6rem; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white;">{{ $unreadCount }}</span>
                        @endif
                    </button>

                    <!-- NOTIFICATIONS DROPDOWN -->
                    <div id="notificationDropdown" style="display: none; position: absolute; top: 50px; right: -100px; width: 320px; background: white; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1001; max-height: 400px; overflow-y: auto;">
                        <div style="padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; font-size: 0.9rem; font-weight: 800; color: #1e293b;">Notifications</h3>
                            @if($unreadCount > 0)
                                <form action="{{ route('notifications.markRead') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; font-size: 0.75rem; color: var(--corporate-red); text-decoration: none; font-weight: 700; cursor: pointer; padding: 0;">Mark all read</button>
                                </form>
                            @endif
                        </div>
                        <div style="padding: 5px 0;">
                            @forelse(auth()->user()->notifications->take(5) as $notification)
                                <div style="padding: 12px 20px; border-bottom: 1px solid #f8fafc; {{ $notification->unread() ? 'background: var(--accent-soft-red);' : '' }}">
                                    <p style="margin: 0; font-size: 0.8rem; color: #334155; line-height: 1.4;">
                                        <strong>{{ $notification->data['message'] ?? 'New Notification' }}</strong>
                                    </p>
                                    <p style="margin: 5px 0 0; font-size: 0.7rem; color: #64748b;">
                                        <i class="fa-solid fa-clock" style="font-size: 0.65rem; margin-right: 4px;"></i> {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            @empty
                                <div style="padding: 30px 20px; text-align: center; color: #94a3b8;">
                                    <i class="fa-solid fa-bell-slash" style="font-size: 1.5rem; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                    <p style="margin: 0; font-size: 0.8rem;">No notifications yet</p>
                                </div>
                            @endforelse
                        </div>
                        <div style="padding: 12px; border-top: 1px solid #f1f5f9; text-align: center;">
                            <a href="{{ route('notifications.index') }}" style="font-size: 0.8rem; color: #475569; text-decoration: none; font-weight: 700;">View All Notifications</a>
                        </div>
                    </div>
                </div>
                <div style="height: 30px; width: 1px; background: #eee;"></div>
            </div>

            <div class="user-profile-card">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">Organizer • {{ auth()->user()->email }}</span>
                </div>
                <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-soft-red); border: 2px solid #f9dcdc; padding: 3px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover;">
                    @else
                        <span style="font-weight: 800; color: var(--corporate-red); font-size: 1.2rem;">{{ strtoupper(auth()->user()->name[0]) }}</span>
                    @endif
                </div>
            </div>
            

        </div>
    </nav>

    <div class="main-wrapper">
        <aside class="sidebar">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-grip-vertical"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
            <a href="{{ route('organizer.events.index') }}" class="sidebar-link {{ request()->routeIs('organizer.events.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-plus"></i>
                <span class="sidebar-text">My events</span>
            </a>
            <a href="{{ route('organizer.registrations.index') }}" class="sidebar-link {{ request()->routeIs('organizer.registrations.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-group"></i>
                <span class="sidebar-text">Attendees</span>
            </a>

            <a href="{{ route('organizer.reports.index') }}" class="sidebar-link {{ request()->routeIs('organizer.reports.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-simple"></i>
                <span class="sidebar-text">Analytics</span>
            </a>
            <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i>
                <span class="sidebar-text">Settings</span>
            </a>
            
            
            <div style="margin-top: auto; padding: 20px; border-top: 1px solid #eee;">
                <div style="margin-bottom: 15px;">
                    <p style="font-size: 0.7rem; color: #059669; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 6px; margin: 0 0 4px;">
                        <i class="fa-solid fa-circle" style="font-size: 0.4rem;"></i> Online
                    </p>
                    <p style="font-size: 0.65rem; color: #999; margin: 0;">Organizer Panel v1.2</p>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 10px; padding: 12px; background: #fff5f5; border: 1px solid #ffe4e4; border-radius: 8px; color: #dc2626; font-size: 0.8rem; font-weight: 800; cursor: pointer; transition: 0.2s; font-family: inherit; text-transform: uppercase;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="logout-btn-text">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="content-area">
            <div class="content-container">
                @yield('content')

                <footer class="dashboard-footer">
                    <div class="footer-links">
                        <a href="javascript:void(0)" class="footer-link">About Us</a>
                        <a href="javascript:void(0)" class="footer-link">Contact</a>
                        <a href="javascript:void(0)" class="footer-link">Privacy Policy</a>
                        <a href="javascript:void(0)" class="footer-link">Terms of Use</a>
                    </div>
                    <p class="copyright">&copy; {{ date('Y') }} {{ \App\Models\SystemSetting::get('system_name', 'EmCa TECHONOLOGY') }}. All rights reserved.</p>
                    <p class="powered-by">{{ \App\Models\SystemSetting::get('system_footer', 'Managed by EmCa TECHONOLOGY') }}</p>
                </footer>
            </div>
        </main>
    </div>
    <div id="sidebar-backdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <script>
        // Apply sidebar state as soon as possible
        if (window.innerWidth > 992 && localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-collapsed');
        }

        function toggleSidebar() {
            if (window.innerWidth <= 992) {
                const sidebar = document.querySelector('.sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
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

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const wrapper = document.getElementById('notificationWrapper');
            const dropdown = document.getElementById('notificationDropdown');
            if (wrapper && !wrapper.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
