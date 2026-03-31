<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title', \App\Models\SystemSetting::get('system_name', 'EmCa Techonologies'))</title>
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
<body>
    <nav class="top-nav">
        <div class="nav-inner">
            <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.8rem;">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: white; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <img src="{{ asset('EmCa-Logo.png') }}" alt="EmCa" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h2 class="site-title" style="margin: 0; font-size: 1.3rem; color: #1e293b; font-weight: 800; letter-spacing: -0.5px;">EmCa Techonologies</h2>
            </a>

            <div class="nav-links">


                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px; font-weight: 800; text-decoration: none; font-size: 0.8rem;">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px; font-weight: 800; text-decoration: none; font-size: 0.8rem; display: flex; align-items: center; gap: 8px;">
                        LOGIN
                    </a>
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
    </script>

    <main>
        @yield('content')
    </main>

    <!-- PREMIUM FOOTER -->
    <footer style="background: white; border-top: 1px solid #e2e8f0; padding: 60px 0 30px; margin-top: 80px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; margin-bottom: 40px;">
                <div>
                    <h4 style="color: #1e293b; font-weight: 800; margin-bottom: 15px; font-size: 0.9rem; text-transform: uppercase;">Quick Links</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 10px;">
                        <li><a href="#" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">About Us</a></li>
                        <li><a href="#" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Contact</a></li>
                        <li><a href="#" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Categories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #1e293b; font-weight: 800; margin-bottom: 15px; font-size: 0.9rem; text-transform: uppercase;">Support</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 10px;">
                        <li><a href="#" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Privacy Policy</a></li>
                        <li><a href="#" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Terms of Service</a></li>
                        <li><a href="#" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Refund Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: #1e293b; font-weight: 800; margin-bottom: 15px; font-size: 0.9rem; text-transform: uppercase;">Connect</h4>
                    <div style="display: flex; gap: 15px; margin-top: 10px;">
                        <a href="#" style="color: #94a3b8; font-size: 1.2rem;"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" style="color: #94a3b8; font-size: 1.2rem;"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" style="color: #94a3b8; font-size: 1.2rem;"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid #f1f5f9; padding-top: 30px; text-align: center;">
                <p style="color: #94a3b8; font-size: 0.85rem;">&copy; {{ date('Y') }} Event Registration System. All rights reserved. Powered by <span style="color: var(--corporate-red); font-weight: 700;">EmCa Techonologies</span></p>
            </div>
        </div>
    </footer>
</body>
</html>
