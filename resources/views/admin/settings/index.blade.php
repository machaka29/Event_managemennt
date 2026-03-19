@extends('layouts.app')

@section('title', 'System Settings - EventPro')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <h1 style="margin-bottom: 2rem;">System Settings</h1>

    @if(session('success'))
        <div style="background: #C6F6D5; color: #2F855A; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="app_name" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Application Name</label>
                <input type="text" name="app_name" id="app_name" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 4px;" value="{{ old('app_name', $settings['app_name'] ?? config('app.name')) }}">
                <small style="color: var(--text-muted);">This name will be displayed across the site headers and titles.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="contact_email" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 4px;" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                <small style="color: var(--text-muted);">The primary contact email address for inquiries.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="footer_text" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Footer Text</label>
                <input type="text" name="footer_text" id="footer_text" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 4px;" value="{{ old('footer_text', $settings['footer_text'] ?? 'Managed by EmCa TECHONOLOGY') }}">
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
