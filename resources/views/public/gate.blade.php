@extends('layouts.app')

@section('title', 'Member Access - EmCa TECHONOLOGY')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: #fafafa; padding: 20px;">
    <div style="max-width: 500px; width: 100%; background: white; padding: 50px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid #eee; text-align: center;">
        
        <div style="width: 80px; height: 80px; background: #FFF5F5; color: var(--corporate-red); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 30px; box-shadow: 0 8px 20px rgba(148, 0, 0, 0.1);">
            <i class="fa-solid fa-key"></i>
        </div>

        <h1 style="font-size: 2rem; color: #333; margin-bottom: 10px; font-weight: 800; letter-spacing: -0.5px;">Member Access</h1>
        <p style="color: #666; margin-bottom: 40px; font-size: 1.1rem; line-height: 1.6;">Enter your unique **Member ID** to view events and track your participation.</p>

        <form action="{{ route('member.gate.verify') }}" method="POST">
            @csrf
            <div style="margin-bottom: 25px; text-align: left;">
                <label for="access_code" style="display: block; font-weight: 700; color: #444; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Access ID</label>
                <input type="text" name="access_code" id="access_code" placeholder="e.g. EmCa-TSYCQ-26" required 
                    style="width: 100%; padding: 18px 25px; border-radius: 12px; border: 2px solid #eee; font-size: 1.2rem; outline: none; transition: border-color 0.3s; font-family: monospace; text-align: center; letter-spacing: 2px;"
                    onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                @error('access_code')
                    <p style="color: var(--corporate-red); font-size: 0.85rem; margin-top: 10px; font-weight: 600;"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>
                @enderror
            </div>

            <button type="submit" style="width: 100%; background: var(--corporate-red); color: white; padding: 18px; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 800; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(148, 0, 0, 0.2);"
                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(148, 0, 0, 0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(148, 0, 0, 0.2)';">
                VERIFY & ENTER SYSTEM
            </button>
        </form>

        <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee; color: #999; font-size: 0.85rem;">
            <p>Don't have an ID? Contact your Branch Administrator.</p>
            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 20px; font-weight: 700;">
                <a href="{{ route('login') }}" style="color: #666; text-decoration: none;">Admin Login</a>
                <span style="color: #eee;">|</span>
                <a href="#" style="color: #666; text-decoration: none;">Help Center</a>
            </div>
        </div>
    </div>
</div>
@endsection
