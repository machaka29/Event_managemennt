@extends('layouts.admin')

@section('title', 'All Organizers - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Organizers</h1>
        <p style="color: #666; font-size: 1rem;">Manage all event organizers on the platform.</p>
    </div>
    <a href="#" class="btn btn-primary" style="padding: 12px 25px;">
        <i class="fa-solid fa-user-plus"></i> Add New Organizer
    </a>
</div>

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
                        <a href="#" style="color: var(--corporate-red); margin-right: 15px;"><i class="fa-solid fa-pen-to-square"></i></a>
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
