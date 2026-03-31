<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', \App\Models\SystemSetting::get('system_name', 'EmCa Techonologies'))</title>
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

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background: #FFFFFF;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: var(--header-height);
            bottom: 0;
            left: 0;
            z-index: 1001; /* Above Top Nav */
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .main-content {
            flex: 1;
            margin-left: 0;
            padding: 2rem;
            background: #f8fafc;
            transition: all 0.3s ease;
            width: 100%;
        }

        .content-wrapper {
            max-width: 1300px;
            margin: 0 auto;
            width: 100%;
        }

        /* Desktop: when sidebar is open, push content */
        @media (min-width: 1025px) {
            .sidebar.show {
                transform: translateX(0);
            }
            body.sidebar-open .main-content {
                margin-left: var(--sidebar-width);
            }
        }

        /* Hamburger always visible */
        .mobile-menu-toggle {
            display: flex !important;
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            z-index: 998;
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

        /* Sidebar Header (with close button) */
        .mobile-sidebar-header {
            display: flex;
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
            .sidebar { top: 0; height: 100vh; padding-top: 0; z-index: 1100; }
            .sidebar-overlay.show { display: block; z-index: 1099; }
            .admin-user-info { display: none; }
            .desktop-nav-label { display: none; }
            .menu-item { padding: 1.2rem 2rem; font-size: 1.05rem; } /* Larger tap targets */
        }

        @media (max-width: 768px) {
            .main-content { padding: 1.5rem 15px; }
            .top-nav { padding: 0 15px !important; }
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
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- FIXED TOP NAV - CLEAN & PALE -->
    <nav class="top-nav" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; background: var(--header-gradient); border-bottom: 1px solid #e2e8f0; height: var(--header-height);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div class="site-branding" style="margin-right: 15px;">
                    <h2 style="margin: 0; font-size: 1.1rem; color: #1e293b; font-weight: 800; letter-spacing: -0.5px; line-height: 1;">EmCa Techonologies</h2>
                    <p style="margin: 3px 0 0; font-size: 0.65rem; color: var(--corporate-red); font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">Management Portal</p>
                </div>
                <!-- Hamburger AFTER Branding -->
                <button onclick="toggleSidebar()" class="mobile-menu-toggle" style="background: var(--accent-soft-red); border: 2px solid var(--corporate-red); color: var(--corporate-red); width: 44px; height: 44px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 2px 8px rgba(148,0,0,0.1); transition: all 0.3s; z-index: 1050;" title="Toggle Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: nowrap;">
                <!-- Notification Bell & Dropdown -->
                <div style="position: relative;" id="notifDropdownContainer">
                    @php 
                        $unreadRegistrations = \App\Models\Registration::with(['attendee', 'event'])->where('is_read', false)->latest()->take(5)->get();
                        $unreadCount = \App\Models\Registration::where('is_read', false)->count(); 
                    @endphp
                    <button onclick="toggleNotifDropdown(event)" style="background: #f1f5f9; color: #475569; width: 40px; height: 40px; border-radius: 50%; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; position: relative;" title="Search notifications">
                        <i class="fa-solid fa-bell"></i>
                        @if($unreadCount > 0)
                            <span style="position: absolute; top: -2px; right: -2px; background: #ef4444; color: white; font-size: 0.65rem; min-width: 18px; height: 18px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white;">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="notifDropdown" style="display: none; position: absolute; top: 50px; right: 0; width: 320px; background: white; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1001; overflow: hidden;">
                        <div style="padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                            <h4 style="margin: 0; font-size: 0.85rem; color: #1e293b; font-weight: 800; text-transform: uppercase;">Notifications</h4>
                            <span style="font-size: 0.65rem; background: var(--corporate-red); color: white; padding: 2px 8px; border-radius: 10px; font-weight: 800;">NEW</span>
                        </div>
                        
                        <div style="max-height: 350px; overflow-y: auto;">
                            @if($unreadRegistrations->count() > 0)
                                @foreach($unreadRegistrations as $notif)
                                    <a href="{{ route('admin.attendees.index') }}" style="display: block; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid #f8fafc; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='white';">
                                        <div style="font-size: 0.85rem; color: #1e293b; font-weight: 700; line-height: 1.4;">
                                            {{ $notif->attendee->full_name }} <span style="font-weight: 500; color: #64748b;">has registered for</span> {{ $notif->event->title }}
                                        </div>
                                        <div style="font-size: 0.65rem; color: #94a3b8; margin-top: 5px; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                            <i class="fa-solid fa-clock"></i> {{ $notif->created_at->diffForHumans() }}
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                                    <i class="fa-solid fa-bell-slash" style="font-size: 2rem; opacity: 0.2; margin-bottom: 10px;"></i>
                                    <div style="font-size: 0.85rem; font-weight: 700;">No new attendees</div>
                                    <div style="font-size: 0.7rem; margin-top: 5px;">You're all caught up!</div>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('admin.attendees.index') }}" style="display: block; padding: 12px; text-align: center; font-size: 0.75rem; color: var(--corporate-red); font-weight: 800; text-decoration: none; background: #fff; border-top: 1px solid #f1f5f9; transition: background 0.2s;" onmouseover="this.style.background='#fcf2f2';" onmouseout="this.style.background='white';">
                            VIEW ALL REGISTRATIONS
                        </a>
                    </div>
                </div>

                <!-- Global Search -->
                <form action="{{ route('admin.search') }}" method="GET" style="flex: 1; max-width: 400px; margin: 0 20px; position: relative;" class="admin-global-search">
                    <i class="fa-solid fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                    <input type="text" name="query" placeholder="Search events, members, organizers..." 
                        required
                        value="{{ request('query') }}"
                        style="width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #e2e8f0; border-radius: 20px; font-size: 0.85rem; outline: none; background: #fff; transition: all 0.3s;"
                        onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.05)';"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                </form>
                <a href="{{ route('profile.show') }}" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid var(--accent-soft-red); display: block;">
                     @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                    @endif
                </a>
            </div>
    </nav>

    <div class="admin-layout" style="margin-top: var(--header-height);">
        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="desktop-nav-label" style="padding: 1.5rem 2rem 1rem; border-bottom: 1px solid #FFF5F5; margin-bottom: 1rem;">
                <p style="font-size: 0.7rem; color: #999; text-transform: uppercase; font-weight: bold; letter-spacing: 1px; margin: 0;">Main Navigation</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.events.index') }}" class="menu-item {{ request()->routeIs('admin.events.index') ? 'active' : '' }}" style="position: relative;">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Manage Events</span>
                @php $pendingCount = \App\Models\Event::where('status', 'pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: var(--corporate-red); color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 10px; font-weight: 800;">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.events.pending') }}" class="menu-item {{ request()->routeIs('admin.events.pending') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Pending Approvals</span>
            </a>

            <a href="{{ route('admin.attendees.index') }}" class="menu-item {{ request()->routeIs('admin.attendees.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>All Registrations</span>
            </a>

            <div style="position: relative;">
                <a href="{{ route('admin.organizers.index') }}" class="menu-item {{ request()->routeIs('admin.organizers*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear"></i>
                    <span>Organizers</span>
                </a>
                <a href="{{ route('admin.organizers.create') }}" style="position: absolute; right: 20px; top: 50%; translate: 0 -50%; color: var(--corporate-red); opacity: 0.6; transition: 0.3s;" onmouseover="this.style.opacity='1';" title="Add New Organizer">
                    <i class="fa-solid fa-plus-circle"></i>
                </a>
            </div>

            <div style="position: relative;">
                <a href="{{ route('admin.attendees.list') }}" class="menu-item {{ request()->routeIs('admin.attendees.list') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Attendees</span>
                </a>
            </div>



            <a href="{{ route('profile.show') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profile Settings</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="menu-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                <i class="fa-solid fa-gears"></i>
                <span>System Settings</span>
            </a>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer" style="padding: 1.5rem 2rem; border-top: 1px solid #f1f5f9; margin-top: auto;">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="menu-item" style="width: 100%; background: #fef2f2; color: #ef4444; border: none; border-radius: 8px; cursor: pointer; padding: 0.75rem 1.5rem; justify-content: flex-start;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
                <div style="margin-top: 1rem; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></div>
                    <p style="font-size: 0.75rem; color: #64748b; font-weight: 700; margin: 0;">System Online</p>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <footer style="background: #FFFFFF; border-top: 3px solid var(--corporate-red); padding: 30px 20px; color: #64748b; text-align: center;">
        <div style="margin-bottom: 10px; font-weight: 800; color: #1e293b; font-size: 0.9rem;">
            &copy; {{ date('Y') }} {{ \App\Models\SystemSetting::get('system_name', 'EmCa Techonologies') }}
        </div>
        <div style="font-size: 0.7rem; color: var(--corporate-red); font-weight: 800; letter-spacing: 1.5px;">
            {{ \App\Models\SystemSetting::get('system_footer', 'EmCa Techonologies') }}
        </div>
    </footer>

    <!-- Toggle Dropdowns Scripts -->
    <script>
        // Set initial sidebar state
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth > 1024) {
                document.querySelector('.sidebar').classList.add('show');
            } else {
                document.body.classList.remove('sidebar-open');
            }
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            document.body.classList.toggle('sidebar-open');
            
            if (window.innerWidth <= 1024) {
                overlay.classList.toggle('show');
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
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

        // Close on outside click
        window.onclick = function(event) {
            const dropdown = document.getElementById('notifDropdown');
            const container = document.getElementById('notifDropdownContainer');
            if (dropdown && !container.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        }

        // Auto-close sidebar when clicking menu links on mobile
        document.querySelectorAll('.sidebar .menu-item').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1024) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>
