<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Management')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Extra styles if needed */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--header-gradient);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--corporate-red);
            font-weight: bold;
        }
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: 'Century Gothic', sans-serif;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--corporate-red);
            box-shadow: 0 0 0 2px var(--accent-soft-red);
        }
        .text-error {
            color: var(--corporate-red);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <nav class="page-header" style="position: sticky; top: 0; z-index: 1000; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); background: var(--header-gradient);">
        <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.8rem;">
            @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
            @if($systemLogo)
                <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 40px; height: 40px; border-radius: 5px; object-fit: cover;">
            @else
                <div style="width: 40px; height: 40px; border-radius: 5px; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            @endif
            <div>
                <h2 style="margin: 0; font-size: 1.3rem; color: #333333; font-weight: bold;">EmCa Technologies</h2>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            @auth
                <a href="{{ route('dashboard') }}" style="color: var(--corporate-red); text-decoration: none; font-weight: bold;">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="padding: 10px 25px; background: var(--corporate-red); border: none;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary" style="background-color: var(--corporate-red); padding: 10px 35px; border-radius: 5px; color: white; text-decoration: none; font-weight: bold; border: none;">LOGIN</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer id="contact" style="text-align: center; padding: 60px 20px; background: #FFFFFF; border-top: 1px solid var(--corporate-red); color: #666666; font-family: 'Century Gothic', sans-serif;">
        <div style="margin-bottom: 2rem; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
             @if($systemLogo)
                <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
            @else
                <div style="width: 50px; height: 50px; border-radius: 8px; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5rem;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            @endif
            <h2 style="margin: 0; font-size: 1.8rem; color: #333333; font-weight: bold;">EmCa Technologies</h2>
        </div>

        <div style="margin-bottom: 2rem; display: flex; justify-content: center; gap: 2.5rem; color: var(--corporate-red); font-weight: 500;">
            <a href="#" style="text-decoration: none; color: inherit;">About Us</a>
            <a href="#" style="text-decoration: none; color: inherit;">Contact</a>
            <a href="#" style="text-decoration: none; color: inherit;">Privacy Policy</a>
            <a href="#" style="text-decoration: none; color: inherit;">Terms of Use</a>
        </div>

        <div style="font-size: 0.95rem; color: #888;">
            &copy; {{ date('Y') }} EmCa Technologies. All rights reserved.
        </div>
    </footer>
</body>
</html>
