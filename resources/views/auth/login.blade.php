@extends('layouts.app')

@section('title', 'Login - EventPro')

@section('content')
<div class="auth-container">
    <div class="card" style="width: 100%; max-width: 400px;">
        <h3 style="text-align: center; margin-bottom: 1.5rem;">Organizer Login</h3>
        
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
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
            Don't have an account? <a href="{{ route('register') }}" style="color: var(--corporate-red);">Register here</a>
        </p>
    </div>
</div>
@endsection
