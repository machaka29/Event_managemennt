@extends('layouts.admin')

@section('title', 'All Organizers - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Organizers</h1>
        <p style="color: #666; font-size: 1rem;">Manage all event organizers on the platform.</p>
    </div>
    <a href="{{ route('admin.organizers.create') }}" class="btn" style="background: var(--corporate-red); color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-user-plus"></i> ADD NEW ORGANIZER
    </a>
</div>

@if(session('success'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width: 100%; border: 1px solid var(--corporate-red); border-radius: 8px; overflow: hidden; padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--header-gradient); text-align: left; border-bottom: 2px solid var(--corporate-red);">
                <th style="padding: 15px 20px; color: var(--corporate-red);">Name</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Email</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Events</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Joined Date</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organizers as $org)
                <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $org->name }}</td>
                    <td style="padding: 15px 20px;">{{ $org->email }}</td>
                    <td style="padding: 15px 20px;">{{ $org->events()->count() }}</td>
                    <td style="padding: 15px 20px;">{{ $org->created_at->format('M d, Y') }}</td>
                    <td style="padding: 15px 20px; text-align: right;">
                        <a href="#" style="color: var(--corporate-red); margin-right: 15px;"><i class="fa-solid fa-pencil"></i></a>
                        <a href="#" style="color: #666;"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $organizers->links() }}
    </div>
</div>
@endsection
