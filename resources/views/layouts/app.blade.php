<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Management')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
    <nav class="page-header" style="padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.75rem;">
            @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
            @if($systemLogo)
                <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @else
                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    E
                </div>
            @endif
            <h2 style="margin: 0;">EventPro</h2>
        </a>
        <div>
            @auth
                <a href="{{ route('profile.show') }}" style="text-decoration: none; margin-right: 1.5rem; display: flex; align-items: center;">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-color);">
                    @else
                        <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem; border: 2px solid var(--border-color);">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                    @endif
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="margin-right: 1rem;">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="margin-right: 1rem;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer style="text-align: center; padding: 2rem; color: var(--text-muted); border-top: 1px solid var(--border-color);">
        &copy; {{ date('Y') }} Event Registration & Attendance Management System
    </footer>
</body>
</html>
