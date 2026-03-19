@extends('layouts.admin')

@section('title', 'System Settings - EmCa Technologies')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">System Settings</h1>
    <p style="color: #666; font-size: 1rem;">Configure your platform branding and global information.</p>
</div>

<div class="grid grid-cols-2" style="gap: 2rem;">
    <!-- Branding -->
    <div class="card" style="border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="margin-bottom: 1.5rem; color: var(--corporate-red); display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-paintbrush"></i> Platform Branding
        </h3>
        <form action="{{ route('admin.settings.logo') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf
            <div class="form-group">
                <label for="system_logo" style="display: block; font-weight: bold; margin-bottom: 8px;">Institutional Logo</label>
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 15px;">
                    @php $systemLogo = \App\Models\SystemSetting::get('system_logo'); @endphp
                    @if($systemLogo)
                        <img src="{{ asset('storage/' . $systemLogo) }}" alt="Current Logo" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--corporate-red);">
                    @else
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: #FFF5F5; color: var(--corporate-red); display: flex; align-items: center; justify-content: center; font-size: 2rem; border: 2px dashed var(--corporate-red);">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    @endif
                    <div style="flex: 1;">
                        <input type="file" name="system_logo" id="system_logo" class="form-control" required style="padding: 10px;">
                        <p style="font-size: 0.8rem; color: #666; margin-top: 5px;">Recommended: 200x200px PNG/JPG</p>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 12px 25px; align-self: flex-start;">Update Logo</button>
        </form>
    </div>

    <!-- General Info -->
    <div class="card" style="border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="margin-bottom: 1.5rem; color: var(--corporate-red); display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-building-columns"></i> General Information
        </h3>
        <form action="{{ route('admin.settings.general') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf
            <div class="form-group">
                <label for="system_name" style="display: block; font-weight: bold; margin-bottom: 8px;">Platform Name</label>
                <input type="text" name="system_name" id="system_name" class="form-control" value="{{ \App\Models\SystemSetting::get('system_name', 'EmCa Technologies') }}" required style="padding: 12px;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="system_phone" style="display: block; font-weight: bold; margin-bottom: 8px;">Contact Phone</label>
                    <input type="text" name="system_phone" id="system_phone" class="form-control" value="{{ \App\Models\SystemSetting::get('system_phone') }}" style="padding: 12px;">
                </div>
                <div class="form-group">
                    <label for="system_email" style="display: block; font-weight: bold; margin-bottom: 8px;">Support Email</label>
                    <input type="email" name="system_email" id="system_email" class="form-control" value="{{ \App\Models\SystemSetting::get('system_email') }}" style="padding: 12px;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 12px 25px; align-self: flex-start;">Save Configuration</button>
        </form>
    </div>
</div>

<div class="card" style="margin-top: 2rem; border: 1px solid #e0e0e0; background: #fafafa; padding: 20px;">
    <h4 style="margin-bottom: 10px; color: #333;"><i class="fa-solid fa-shield-halved"></i> Security & Maintenance</h4>
    <p style="font-size: 0.9rem; color: #666; margin-bottom: 15px;">Advanced settings for security, backups, and system logs will be available in the next update.</p>
    <div style="display: flex; gap: 10px;">
        <button disabled class="btn" style="background: #e0e0e0; color: #999; cursor: not-allowed; padding: 10px 20px;">Configure Email</button>
        <button disabled class="btn" style="background: #e0e0e0; color: #999; cursor: not-allowed; padding: 10px 20px;">Storage Management</button>
    </div>
</div>
@endsection
