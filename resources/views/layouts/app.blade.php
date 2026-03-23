<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Management')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        :root {
            --corporate-red: #940000;
            --accent-soft-red: #FFF5F5;
            --header-gradient: linear-gradient(135deg, #FFF5F5 0%, #FFFFFF 100%);
            --border-color: #eee;
            --text-muted: #666;
        }

        body {
            margin: 0;
            font-family: 'Century Gothic', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .auth-container {
            min-height: calc(100vh - 72px);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f7f6;
            padding: 2rem;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--corporate-red);
            color: white;
        }

        .btn-primary:hover {
            background: #940000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(148,0,0,0.2);
        }

        .btn-back {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .btn-back:hover {
            color: var(--corporate-red);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: inherit;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--corporate-red);
            box-shadow: 0 0 0 3px rgba(204,0,0,0.1);
        }
        .text-error {
            color: var(--corporate-red);
            font-size: 0.85rem;
            margin-top: 0.4rem;
        }
    </style>
</head>
<body>
    <nav class="page-header" style="position: sticky; top: 0; z-index: 1000; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); background: white; height: 72px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        @php 
            $systemLogo = \App\Models\SystemSetting::get('system_logo'); 
            $appName = \App\Models\SystemSetting::get('system_name', 'EmCa Technologies');
            $systemFooter = \App\Models\SystemSetting::get('system_footer', 'Managed by EmCa TECHONOLOGY');
        @endphp
        
        <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')) : route('home') }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.8rem;">
            @if($systemLogo)
                <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 40px; height: 40px; border-radius: 5px; object-fit: cover;">
            @else
                <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            @endif
            <h2 style="margin: 0; font-family: 'Century Gothic', sans-serif; font-size: 1.3rem; color: #333; font-weight: bold;">{{ $appName }}</h2>
        </a>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            @auth
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <a href="{{ route('profile.show') }}" style="text-decoration: none; display: flex; align-items: center;">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="P" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--corporate-red);">
                        @else
                            <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--corporate-red); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem; border: 1px solid white;">
                                {{ strtoupper(auth()->user()->name[0]) }}
                            </div>
                        @endif
                    </a>
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-outline" style="text-decoration: none; color: var(--corporate-red); font-weight: bold; font-size: 0.9rem;">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background: var(--corporate-red); border: none; color: white; font-weight: bold; border-radius: 5px; cursor: pointer;">Logout</button>
                    </form>
                </div>
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
            <h2 style="margin: 0; font-size: 1.8rem; color: #333333; font-weight: bold;">{{ $appName }}</h2>
        </div>

        <div style="margin-bottom: 2rem; display: flex; justify-content: center; gap: 2.5rem; color: var(--corporate-red); font-weight: 500;">
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">About Us</a>
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">Contact</a>
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">Privacy Policy</a>
            <a href="javascript:void(0)" style="text-decoration: none; color: inherit;">Terms of Use</a>
        </div>

        <div style="font-size: 0.95rem; color: #888;">
            &copy; {{ date('Y') }} {{ $appName }}. {{ $systemFooter }}
        </div>
    </footer>
</body>
</html>
