<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - EmCa Technologies')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --corporate-red: #940000;
            --accent-soft-red: #FFF5F5;
            --header-gradient: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: #FFFFFF;
            border-right: 1px solid var(--corporate-red);
            position: fixed;
            top: 72px; /* Header height */
            bottom: 0;
            left: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 2rem 0 0;
            transition: all 0.3s ease;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem 5%;
            background: #FFFFFF;
            transition: all 0.3s ease;
        }

        /* Sidebar Menu Items */
        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2rem;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s;
        }

        .menu-item:hover {
            background: var(--accent-soft-red);
        }

        .menu-item.active {
            background: var(--header-gradient);
            border-left: 4px solid var(--corporate-red);
            color: var(--corporate-red);
            font-weight: bold;
        }

        .menu-item i {
            width: 20px;
            color: var(--corporate-red);
        }

        /* Submenu */
        .submenu {
            padding-left: 3.5rem;
            list-style: none;
            margin-bottom: 1rem;
        }

        .submenu li a {
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
            display: block;
            padding: 0.5rem 0;
        }

        .submenu li a:hover {
            color: var(--corporate-red);
        }

        /* Mobile Adjustments */
        @media (max-width: 1024px) {
            :root { --sidebar-width: 80px; }
            .menu-item span, .submenu, .sidebar-footer { display: none; }
            .menu-item { justify-content: center; padding: 1.5rem; }
        }

        @media (max-width: 768px) {
            .sidebar { left: -100%; }
            .main-content { margin-left: 0; }
            .sidebar.show { left: 0; width: 260px; z-index: 1001; }
            .sidebar.show .menu-item span { display: block; }
        }
    </style>
</head>
<body>
    <!-- FIXED TOP NAV -->
    <nav class="page-header" style="position: fixed; top: 0; width: 100%; z-index: 1000; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); background: var(--header-gradient); margin: 0;">
        <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 40px; height: 40px; border-radius: 5px; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <h2 style="margin: 0; font-size: 1.3rem; color: #333333; text-transform: uppercase;">{{ \App\Models\SystemSetting::get('system_name', 'EmCa Technologies') }}</h2>
                <p style="margin: 0; font-size: 0.75rem; color: var(--corporate-red); font-weight: bold; letter-spacing: 1px;">ADMIN PANEL</p>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <div style="text-align: right; display: none; @media (min-width: 768px) { display: block; }">
                <p style="margin: 0; font-weight: bold; font-size: 0.9rem;">{{ auth()->user()->name }}</p>
                <p style="margin: 0; font-size: 0.75rem; color: #666;">Administrator</p>
            </div>
            <a href="{{ route('profile.show') }}">
                 @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid var(--corporate-red);">
                @else
                    <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid var(--corporate-red);">
                        {{ strtoupper(auth()->user()->name[0]) }}
                    </div>
                @endif
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background: none; border: none; color: var(--corporate-red); cursor: pointer; font-size: 1.2rem;" title="Logout">
                    <i class="fa-solid fa-unlock-keyhole"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="admin-layout" style="margin-top: 72px;">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div style="padding: 0 2rem 1rem; border-bottom: 1px solid #FFF5F5; margin-bottom: 1.5rem;">
                <p style="font-size: 0.7rem; color: #999; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Main Navigation</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>DASHBOARD</span>
            </a>

            <a href="{{ route('admin.events.index') }}" class="menu-item {{ request()->routeIs('admin.events.index') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>MANAGE EVENTS</span>
            </a>

            <a href="{{ route('admin.attendees.index') }}" class="menu-item {{ request()->routeIs('admin.attendees.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list"></i>
                <span>ALL REGISTRATIONS</span>
            </a>

            <a href="{{ route('admin.organizers.index') }}" class="menu-item {{ request()->routeIs('admin.organizers*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i>
                <span>ORGANIZERS</span>
            </a>

            <a href="{{ route('admin.attendees.list') }}" class="menu-item {{ request()->routeIs('admin.attendees.list') ? 'active' : '' }}">
                <i class="fa-solid fa-user-tie"></i>
                <span>ATTENDEES</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="menu-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>REPORTS</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="menu-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                <i class="fa-solid fa-gears"></i>
                <span>SYSTEM SETTINGS</span>
            </a>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer" style="padding: 2rem; border-top: 1px solid #FFF5F5; margin-top: auto;">
                <p style="font-size: 0.75rem; color: #10b981; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i> System Status: Online</p>
                <p style="font-size: 0.75rem; color: #666; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-floppy-disk" style="font-size: 0.8rem; color: #999;"></i> Last Backup: Today</p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <footer style="text-align: center; padding: 20px 0; background: #FFFFFF; border-top: 1px solid var(--corporate-red); color: #666; font-size: 0.9rem; margin-top: auto;">
        <div>&copy; {{ date('Y') }} Event Registration System</div>
        <div style="font-size: 0.75rem; color: #999; margin-top: 5px;">Admin Panel v1.0</div>
    </footer>

    <!-- Toggle Sidebar Script for Mobile -->
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }
    </script>
</body>
</html>
