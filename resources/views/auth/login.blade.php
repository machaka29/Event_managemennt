@extends('layouts.app')

@section('title', 'Login - EventPro')

@section('content')
<div class="auth-container" style="flex-direction: column; gap: 2rem; padding: 2rem 0;">
    <div class="card" style="width: 100%; max-width: 400px;">
        <h3 style="text-align: center; margin-bottom: 0.5rem;">Enter your credentials to register</h3>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem; font-size: 0.9rem;">Fill in the details below to access your account.</p>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; font-family: 'Century Gothic', sans-serif;">Login</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Don't have an account? <a href="{{ route('register') }}" style="color: var(--corporate-red);">Register here</a>
        </p>
    </div>

    <div style="width: 100%; max-width: 400px;">
        <a href="javascript:history.back()" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back
        </a>
    </div>
</div>
@endsection
