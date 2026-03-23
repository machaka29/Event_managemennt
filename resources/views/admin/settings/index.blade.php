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

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 30px;">
        <!-- Left Column: Branding/Logo -->
        <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee; height: fit-content;">
            <h3 style="margin: 0 0 20px; font-size: 1.1rem; color: #333; border-bottom: 1px solid #f4f4f4; padding-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">System Identity</h3>
            
            <div style="text-align: center; margin-bottom: 25px;">
                @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
                <div style="width: 120px; height: 120px; margin: 0 auto 15px; background: var(--accent-soft-red); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 2px dashed #ddd;">
                    @if($systemLogo)
                        <img src="{{ asset('storage/' . $systemLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-image" style="font-size: 3rem; color: var(--corporate-red); opacity: 0.3;"></i>
                    @endif
                </div>
                <p style="font-size: 0.8rem; color: #999;">Current System Logo</p>
            </div>

            <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label for="system_logo" style="display: block; margin-bottom: 8px; color: #555; font-weight: 700; font-size: 0.8rem; text-transform: uppercase;">Update Logo</label>
                    <input type="file" name="system_logo" id="system_logo" style="width: 100%; padding: 8px; border: 1px solid #eee; border-radius: 8px; font-size: 0.8rem; background: #fafafa;">
                </div>
                <button type="submit" style="width: 100%; background: #666; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#333'">
                    UPLOAD NEW LOGO
                </button>
            </form>
        </div>

        <!-- Right Column: General Settings -->
        <div style="background: white; padding: 35px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
            <h3 style="margin: 0 0 25px; font-size: 1.1rem; color: #333; border-bottom: 1px solid #f4f4f4; padding-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">General Configuration</h3>
            
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="system_name" style="display: block; margin-bottom: 10px; color: #333; font-weight: 700; font-size: 0.9rem; text-transform: uppercase;">Application Name</label>
                    <input type="text" name="system_name" id="system_name" value="{{ old('system_name', \App\Models\SystemSetting::get('system_name', 'EmCa Technologies')) }}" 
                        style="width: 100%; padding: 12px 15px; border: 1.5px solid #eee; border-radius: 8px; font-size: 1rem; transition: 0.3s; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="system_email" style="display: block; margin-bottom: 10px; color: #333; font-weight: 700; font-size: 0.9rem; text-transform: uppercase;">Contact Email</label>
                    <input type="email" name="system_email" id="system_email" value="{{ old('system_email', \App\Models\SystemSetting::get('system_email', 'info@emca.tech')) }}" 
                        style="width: 100%; padding: 12px 15px; border: 1.5px solid #eee; border-radius: 8px; font-size: 1rem; transition: 0.3s; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label for="system_footer" style="display: block; margin-bottom: 10px; color: #333; font-weight: 700; font-size: 0.9rem; text-transform: uppercase;">Footer Text</label>
                    <input type="text" name="system_footer" id="system_footer" value="{{ old('system_footer', \App\Models\SystemSetting::get('system_footer', 'Managed by EmCa TECHONOLOGY')) }}" 
                        style="width: 100%; padding: 12px 15px; border: 1.5px solid #eee; border-radius: 8px; font-size: 1rem; transition: 0.3s; outline: none;"
                        onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                </div>

                <div style="padding-top: 15px; border-top: 1px solid #f4f4f4;">
                    <button type="submit" style="background: var(--corporate-red); color: white; padding: 15px 40px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 800; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(148,0,0,0.2);"
                        onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fa-solid fa-floppy-disk"></i> SAVE CHANGES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
