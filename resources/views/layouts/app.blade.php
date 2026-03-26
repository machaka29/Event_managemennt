<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', \App\Models\SystemSetting::get('system_name', 'EmCa TECHONOLOGY'))</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --corporate-red: #940000;
            --accent-soft-red: #FFF5F5;
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

        /* Top Nav Refinement */
        .top-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            height: var(--header-height);
            border-bottom: 2px solid var(--corporate-red);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            padding: 0 var(--container-padding);
        }

        .nav-inner {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        /* Hamburger Menu */
        .mobile-menu-toggle {
            display: none;
            background: #f1f5f9;
            border: none;
            color: #475569;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .mobile-menu-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: white;
            z-index: 999;
            flex-direction: column;
            padding: 2rem;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-menu-toggle { display: flex; }
            .site-title { font-size: 1.1rem !important; }
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="nav-inner">
            <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.8rem;">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
                    @if($systemLogo)
                        <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    @else
                        <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                    @endif
                </div>
                <h2 class="site-title" style="margin: 0; font-size: 1.3rem; color: #1e293b; font-weight: 800; letter-spacing: -0.5px;">EmCa TECHONOLOGY</h2>
            </a>

            <div class="nav-links">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-outline" style="min-width: 140px;">DASHBOARD</a>
                    <a href="{{ route('profile.show') }}" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid var(--accent-soft-red); display: block;">
                         @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ strtoupper(auth()->user()->name[0]) }}
                            </div>
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 10px 35px;">LOGIN</a>
                @endauth
            </div>

            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenu" class="mobile-menu-overlay">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div style="font-weight: 800; color: var(--corporate-red); font-size: 1.25rem;">MENU</div>
            <button onclick="toggleMobileMenu()" style="background: none; border: none; font-size: 1.5rem; color: #475569;">&times;</button>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline" style="width: 100%;">HOME</a>
        @auth
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-outline" style="width: 100%;">DASHBOARD</a>
            <a href="{{ route('profile.show') }}" class="btn btn-outline" style="width: 100%;">MY PROFILE</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" style="width: 100%;">LOGOUT</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%;">LOGIN</a>
        @endauth
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>

    <main>
        @yield('content')
    </main>

    <footer id="contact" style="text-align: center; padding: 60px 20px; background: #FFFFFF; border-top: 1px solid var(--corporate-red); color: #666666; font-family: 'Century Gothic', sans-serif;">
        <div style="margin-bottom: 2rem; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 8px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                @if($systemLogo)
                    <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                    <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                @endif
            </div>
            <h2 style="margin: 0; font-size: 1.8rem; color: #333333; font-weight: bold;">EmCa TECHONOLOGY</h2>
        </div>

        <div style="margin-bottom: 2rem; display: flex; justify-content: center; gap: 2.5rem; color: var(--corporate-red); font-weight: 500;">
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">About Us</a>
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">Contact</a>
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">Privacy Policy</a>
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">Terms of Use</a>
        </div>

        <div style="font-size: 0.95rem; color: #888;">
            &copy; {{ date('Y') }} EmCa TECHONOLOGY. Managed by EmCa TECHONOLOGY
        </div>
    </footer>
</body>
</html>
