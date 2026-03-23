@extends('layouts.admin')

@section('title', 'System Settings - Admin Panel')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-bottom: 50px;">
    <div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--corporate-red); padding-bottom: 20px;">
        <div>
            <h1 style="margin: 0; color: #333; font-size: 1.8rem; font-weight: 800; text-transform: uppercase;">System Settings</h1>
            <p style="color: var(--corporate-red); margin: 5px 0 0; font-weight: 600; font-size: 0.9rem;">Manage global application configuration and branding.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #666; text-decoration: none; font-weight: 600; border: 1px solid #ddd; padding: 10px 15px; border-radius: 8px; transition: 0.3s;" onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.color='var(--corporate-red)';" onmouseout="this.style.borderColor='#ddd'; this.style.color='#666';">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div style="background: #FFF5F5; border-left: 5px solid var(--corporate-red); color: var(--corporate-red); padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 12px rgba(148,0,0,0.05);">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 2rem;">
                <label for="system_name" style="display: block; margin-bottom: 10px; color: #333; font-weight: 700; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px;">Application Name</label>
                <input type="text" name="system_name" id="system_name" value="{{ old('system_name', \App\Models\SystemSetting::get('system_name', 'EmCa Technologies')) }}" 
                    style="width: 100%; padding: 15px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; transition: all 0.3s; outline: none;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.05)';"
                    onblur="this.style.borderColor='#eee'; this.style.boxShadow='none';">
                <p style="color: #888; font-size: 0.85rem; margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> This name will be displayed across the site headers and titles.</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="system_email" style="display: block; margin-bottom: 10px; color: #333; font-weight: 700; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px;">Contact Email</label>
                <input type="email" name="system_email" id="system_email" value="{{ old('system_email', \App\Models\SystemSetting::get('system_email', 'info@emca.tech')) }}" 
                    style="width: 100%; padding: 15px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; transition: all 0.3s; outline: none;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.05)';"
                    onblur="this.style.borderColor='#eee'; this.style.boxShadow='none';">
                <p style="color: #888; font-size: 0.85rem; margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> The primary contact email address for inquiries.</p>
            </div>

            <div style="margin-bottom: 2.5rem;">
                <label for="system_footer" style="display: block; margin-bottom: 10px; color: #333; font-weight: 700; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px;">Footer Text</label>
                <input type="text" name="system_footer" id="system_footer" value="{{ old('system_footer', \App\Models\SystemSetting::get('system_footer', 'Managed by EmCa TECHONOLOGY')) }}" 
                    style="width: 100%; padding: 15px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; transition: all 0.3s; outline: none;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 4px rgba(148,0,0,0.05)';"
                    onblur="this.style.borderColor='#eee'; this.style.boxShadow='none';">
                <p style="color: #888; font-size: 0.85rem; margin-top: 8px;"><i class="fa-solid fa-circle-info"></i> The text displayed at the bottom of every page.</p>
            </div>

            <div style="padding-top: 20px; border-top: 1px solid #f4f4f4;">
                <button type="submit" style="background: var(--corporate-red); color: white; padding: 15px 40px; border: none; border-radius: 10px; font-size: 1rem; font-weight: 800; cursor: pointer; transition: all 0.3s; box-shadow: 0 10px 20px rgba(148, 0, 0, 0.2);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(148, 0, 0, 0.3)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(148, 0, 0, 0.2)';">
                    <i class="fa-solid fa-floppy-disk"></i> SAVE SETTINGS
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
