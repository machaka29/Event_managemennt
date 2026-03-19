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
    <nav class="page-header" style="padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.75rem;">
            @php 
                $systemLogo = \App\Models\SystemSetting::get('system_logo'); 
                $appName = \App\Models\Setting::where('key', 'app_name')->value('value') ?: 'EmCa TECHONOLOGY';
                $footerText = \App\Models\Setting::where('key', 'footer_text')->value('value') ?: 'Managed by EmCa TECHONOLOGY';
                $contactEmail = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@EmCa.tech';
            @endphp
    <nav class="page-header" style="position: sticky; top: 0; z-index: 1000; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); background: var(--header-gradient);">
        <a href="{{ route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.8rem;">
            @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
            @if($systemLogo)
                <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 40px; height: 40px; border-radius: 5px; object-fit: cover;">
            @else
                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: 'Century Gothic', sans-serif;">
                    {{ substr($appName, 0, 1) }}
                </div>
            @endif
            <h2 style="margin: 0; font-family: 'Century Gothic', sans-serif; font-size: 1.25rem;">{{ $appName }}</h2>
        </a>

        <!-- Center Menu -->
        <div style="display: flex; gap: 1rem; flex: 1; justify-content: center; align-items: center;">
            <!-- Removed as per user request -->
        </div>

        <div>
            @auth
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <a href="{{ route('profile.show') }}" style="text-decoration: none; display: flex; align-items: center;">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-color);">
                        @else
                            <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem; border: 2px solid var(--border-color); font-family: 'Century Gothic', sans-serif;">
                                {{ strtoupper(auth()->user()->name[0]) }}
                            </div>
                        @endif
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
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

    <footer style="padding: 3rem 2rem; color: var(--text-muted); border-top: 1px solid var(--border-color); background: #f8f9fa;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 2rem; text-align: left;">
            <div style="flex: 1; min-width: 250px;">
                <h3 style="color: var(--corporate-red); margin-bottom: 1rem; font-family: 'Century Gothic', sans-serif;">EmCa TECHONOLOGY</h3>
                <p style="font-size: 0.9rem; line-height: 1.6;">Providing modern event registration and attendance management solutions.</p>
            </div>
                <h4 style="margin-bottom: 1rem; color: #333; font-family: 'Century Gothic', sans-serif;">Contact Us</h4>
                <p style="font-size: 0.9rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.27-2.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    0673389493
                </p>
                <p style="font-size: 0.9rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    {{ $contactEmail }}
                </p>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <h4 style="margin-bottom: 1rem; color: #333; font-family: 'Century Gothic', sans-serif;">Location</h4>
                <p style="font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Moshi, Kilimanjaro
                </p>
            </div>
        </div>
        <div style="margin-top: 3rem; text-align: center; border-top: 1px solid #eee; padding-top: 1.5rem; font-size: 0.85rem;">
            &copy; {{ date('Y') }} {{ $footerText }}
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
