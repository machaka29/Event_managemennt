<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', \App\Models\SystemSetting::get('system_name', 'EmCa TECHONOLOGY'))</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 0px;
            --corporate-red: #940000;
            --accent-soft-red: #FFF5F5;
            --header-gradient: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
            --header-height: 72px;
        }

        body, h1, h2, h3, h4, h5, h6, p, span, a, div, input, button, select, textarea {
            font-family: 'Century Gothic', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            margin: 0;
            background-color: #f8fafc;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR - Responsive Overlay Pattern */
        .sidebar {
            width: var(--sidebar-width);
            background: #FFFFFF;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: var(--header-height);
            bottom: 0;
            left: 0;
            z-index: 999;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 1.5rem var(--container-padding);
            background: #f8fafc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Collapsed Sidebar State - DESKTOP ONLY */
        @media (min-width: 1025px) {
            body.sidebar-collapsed {
                --sidebar-width: 80px;
            }
            body.sidebar-collapsed .sidebar-text,
            body.sidebar-collapsed .desktop-nav-label,
            body.sidebar-collapsed .site-branding,
            body.sidebar-collapsed .logout-btn-sidebar span {
                display: none;
            }
            body.sidebar-collapsed .menu-item {
                justify-content: center;
                padding: 1.2rem 0;
            }
            body.sidebar-collapsed .menu-item i {
                margin: 0;
                font-size: 1.4rem;
            }
            body.sidebar-collapsed .sidebar-footer {
                padding: 15px 10px;
            }
            body.sidebar-collapsed .logout-btn-sidebar {
                justify-content: center;
                padding: 12px 0;
            }
        }

        /* Menu Items */
        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background: #f1f5f9;
            color: var(--corporate-red);
        }

        .menu-item.active {
            background: var(--accent-soft-red);
            border-left-color: var(--corporate-red);
            color: var(--corporate-red);
            font-weight: 600;
        }

        .menu-item i {
            width: 20px;
            font-size: 1.1rem;
            color: inherit;
        }

        /* Mobile Sidebar Header */
        .mobile-sidebar-header {
            display: none;
            padding: 1.5rem 2rem 1rem;
            border-bottom: 2px solid var(--corporate-red);
            margin-bottom: 1rem;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
        }

        /* Breakpoints Logic */
        @media (max-width: 1199px) {
            .main-content { padding: 2rem 5%; }
        }

        @media (max-width: 1024px) {
            :root { --sidebar-width: 280px; }
            .sidebar { transform: translateX(-100%); top: 0; height: 100vh; padding-top: 0; }
            .main-content { margin-left: 0; }
            .sidebar.show { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .mobile-menu-toggle { display: flex !important; }
            .admin-user-info { display: none; }
            .mobile-sidebar-header { display: flex; }
            .desktop-nav-label { display: none; }
            .menu-item { padding: 1.2rem 2rem; font-size: 1.05rem; } /* Larger tap targets */
        }

        @media (max-width: 768px) {
            .main-content { padding: 1.5rem 15px; }
            .top-nav { padding: 0 15px !important; }
        }
    </style>
</head>
<body>
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- FIXED TOP NAV - CLEAN & PALE -->
    <nav class="top-nav" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; background: var(--header-gradient); border-bottom: 1px solid #e2e8f0; height: var(--header-height);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button onclick="toggleSidebar()" style="background: white; border: 1px solid #e2e8f0; color: #475569; width: 44px; height: 44px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;" class="menu-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
                    @if($systemLogo)
                        <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                    @endif
                </div>
                <div class="site-branding">
                    <h2 style="margin: 0; font-size: 1.1rem; color: #1e293b; text-transform: none; font-weight: 800; letter-spacing: -0.5px; line-height: 1;">EmCa Techonology</h2>
                    <p style="margin: 3px 0 0; font-size: 0.65rem; color: var(--corporate-red); font-weight: 800; letter-spacing: 1px; text-transform: none;">Management Portal</p>
                </div>
            </div>

                <!-- NOTIFICATIONS BELL -->
                @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                <div style="position: relative;" id="notificationWrapper">
                    <button onclick="toggleNotifications()" style="background: white; border: 1px solid #e2e8f0; color: #475569; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; position: relative;">
                        <i class="fa-solid fa-bell"></i>
                        @if($unreadCount > 0)
                            <span style="position: absolute; top: -5px; right: -5px; background: var(--corporate-red); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white;">{{ $unreadCount }}</span>
                        @endif
                    </button>

                    <!-- NOTIFICATIONS DROPDOWN -->
                    <div id="notificationDropdown" style="display: none; position: absolute; top: 50px; right: 0; width: 320px; background: white; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1001; max-height: 400px; overflow-y: auto;">
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

                <a href="{{ route('profile.show') }}" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid var(--accent-soft-red); display: block;">
                     @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                    @endif
                </a>
                </a>
            </div>
    </nav>

    <div class="admin-layout" style="margin-top: var(--header-height);">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <!-- Mobile Header (Hidden on Desktop) -->
            <div class="mobile-sidebar-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 30px; height: 30px; border-radius: 6px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($systemLogo)
                            <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                        @else
                            <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                        @endif
                    </div>
                    <h2 style="margin: 0; font-size: 1rem; color: #1e293b; font-weight: 800; text-transform: none;">Menu</h2>
                </div>
                <button onclick="toggleSidebar()" style="background: var(--accent-soft-red); border: none; font-size: 1.5rem; color: var(--corporate-red); cursor: pointer; width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">&times;</button>
            </div>

            <div class="desktop-nav-label" style="padding: 1.5rem 2rem 1rem; border-bottom: 1px solid #FFF5F5; margin-bottom: 1rem;">
                <p style="font-size: 0.7rem; color: #999; text-transform: none; font-weight: bold; letter-spacing: 1px; margin: 0;">Main Navigation</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.events.index') }}" class="menu-item {{ request()->routeIs('admin.events.index') ? 'active' : '' }}" style="position: relative;">
                <i class="fa-solid fa-calendar-check"></i>
                <span class="sidebar-text">Manage Events</span>
                @php $pendingCount = \App\Models\Event::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: var(--corporate-red); color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 10px; font-weight: 800;">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.events.pending') }}" class="menu-item {{ request()->routeIs('admin.events.pending') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="sidebar-text">Pending Approvals</span>
            </a>

            <a href="{{ route('admin.attendees.index') }}" class="menu-item {{ request()->routeIs('admin.attendees.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i>
                <span class="sidebar-text">All Registrations</span>
            </a>

            <div style="position: relative;">
                <a href="{{ route('admin.organizers.index') }}" class="menu-item {{ request()->routeIs('admin.organizers*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="sidebar-text">Organizers</span>
                </a>
                <a href="{{ route('admin.organizers.create') }}" style="position: absolute; right: 20px; top: 50%; translate: 0 -50%; color: var(--corporate-red); opacity: 0.6; transition: 0.3s;" onmouseover="this.style.opacity='1';" title="Add New Organizer">
                    <i class="fa-solid fa-plus-circle"></i>
                </a>
            </div>

            <div style="position: relative;">
                <a href="{{ route('admin.attendees.list') }}" class="menu-item {{ request()->routeIs('admin.attendees.list') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="sidebar-text">Attendees</span>
                </a>
            </div>

            <a href="{{ route('admin.reports.index') }}" class="menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="sidebar-text">Reports</span>
            </a>

            <a href="{{ route('admin.sms.create') }}" class="menu-item {{ request()->routeIs('admin.sms*') ? 'active' : '' }}">
                <i class="fa-solid fa-comment-sms"></i>
                <span class="sidebar-text">Sms Broadcast</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="menu-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                <i class="fa-solid fa-gears"></i>
                <span class="sidebar-text">System Settings</span>
            </a>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer" style="padding: 1rem 2rem; border-top: 1px solid #FFF5F5; margin-top: auto;">
                <p style="font-size: 0.75rem; color: #059669; font-weight: 700; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i> System Online</p>
                
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn-sidebar" style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 12px 15px; background: #FFF5F5; border: 1px solid #FFE4E4; border-radius: 8px; color: #dc2626; font-size: 0.85rem; font-weight: 800; cursor: pointer; transition: 0.3s; text-transform: uppercase;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <footer style="text-align: center; padding: 20px 0; background: #FFFFFF; border-top: 1px solid #eee; color: #666; font-size: 0.9rem; margin-top: auto;">
        <div>&copy; {{ date('Y') }} {{ \App\Models\SystemSetting::get('system_name', 'EmCa TECHONOLOGY') }}</div>
        <div style="font-size: 0.75rem; color: #999; margin-top: 5px;">{{ \App\Models\SystemSetting::get('system_footer', 'Managed by EmCa TECHONOLOGY') }}</div>
    </footer>

    <!-- Toggle Sidebar & Notifications Script -->
    <script>
        // Apply sidebar state as soon as possible
        if (window.innerWidth > 1024 && localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-collapsed');
        }

        function toggleSidebar() {
            if (window.innerWidth <= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
            }
        }

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
