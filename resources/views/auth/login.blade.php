@extends('layouts.app')

@section('title', 'Login - EmCa TECHONOLOGY')

@section('content')
<div class="auth-container" style="background: #fafafa; padding: 40px 15px;">
    <div class="card" style="width: 100%; max-width: 400px; padding: 0; overflow: hidden; border: 1px solid #e2e8f0; border-top: 4px solid var(--corporate-red);">
        <!-- Header with Pale Gradient -->
        <div style="background: var(--header-gradient); padding: 30px; text-align: center; border-bottom: 1px solid #f1f5f9;">
            <div style="width: 50px; height: 50px; background: var(--accent-soft-red); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; color: var(--corporate-red); font-size: 1.4rem;">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 style="margin: 0; font-size: 1.4rem; font-weight: 800; letter-spacing: -0.5px; text-transform: uppercase;">PORTAL ACCESS</h2>
            <p style="color: var(--text-muted); margin-top: 5px; font-size: 0.85rem; font-weight: 600;">Secure Login Required</p>
        </div>
        
        <div style="padding: 30px;">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div style="position: relative;">
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus style="height: 44px; padding-left: 15px;" placeholder="Email address">
                    </div>
                    @error('email')
                        <p style="color: #dc2626; font-size: 0.75rem; font-weight: 700; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="password">Security Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" class="form-control" required style="height: 44px; padding-left: 15px;" placeholder="••••••••">
                    </div>
                    @error('password')
                        <p style="color: #dc2626; font-size: 0.75rem; font-weight: 700; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 0.95rem; height: 48px;">
                    Login
                </button>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; text-align: center;">
                <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='var(--corporate-red)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fa-solid fa-arrow-left"></i> BACK TO HOME
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
