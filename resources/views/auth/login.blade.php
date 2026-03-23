@extends('layouts.app')

@section('title', 'Login - EventPro')

@section('content')
<div class="auth-container" style="flex-direction: column; gap: 2rem; padding: 2rem 0;">
    <div class="card" style="width: 100%; max-width: 400px; padding: 40px; border-top: 4px solid var(--corporate-red);">
        <h3 style="text-align: center; margin-bottom: 0.5rem; color: var(--corporate-red); font-weight: 800; font-size: 1.8rem; text-transform: uppercase;">Login</h3>
        <p style="text-align: center; color: #666; margin-bottom: 2.5rem; font-size: 0.95rem;">Please enter your credentials to access the panel.</p>
        
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

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #999;">
            Only authorized personnel can login here.
        </p>
    </div>

    <div style="width: 100%; max-width: 400px; display: flex; justify-content: center;">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Home
        </a>
    </div>
</div>
@endsection
