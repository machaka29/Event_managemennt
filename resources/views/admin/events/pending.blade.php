@extends('layouts.admin')

@section('title', 'Pending Approvals - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Pending Approvals</h1>
    <p style="color: #666; font-size: 1rem;">Review and approve new event submissions from organizers.</p>
</div>

@if(session('success'))
    <div style="background: #FFF5F5; border-left: 5px solid var(--corporate-red); color: var(--corporate-red); padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width: 100%; border: 1px solid var(--corporate-red); border-radius: 8px; overflow: hidden; padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--header-gradient); text-align: left; border-bottom: 2px solid var(--corporate-red);">
                <th style="padding: 15px 20px; color: var(--corporate-red);">Event Title</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Organizer</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Date & Time</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Location</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr style="border-bottom: 1px solid #FFF5F5;">
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $event->title }}</td>
                    <td style="padding: 15px 20px;">{{ $event->organizer->name }}</td>
                    <td style="padding: 15px 20px;">
                        {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}<br>
                        <small style="color: #666;">{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</small>
                    </td>
                    <td style="padding: 15px 20px;">{{ $event->location }}</td>
                    <td style="padding: 15px 20px; text-align: right; display: flex; gap: 10px; justify-content: flex-end;">
                        <form action="{{ route('admin.events.approve', $event->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-primary" style="background: var(--corporate-red); padding: 8px 15px; font-size: 0.85rem; border: none; color: white; border-radius: 6px; cursor: pointer; font-weight: bold;">Approve</button>
                        </form>
                        <form action="{{ route('admin.events.reject', $event->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-primary" style="background: #333; padding: 8px 15px; font-size: 0.85rem; border: none; color: white; border-radius: 6px; cursor: pointer; font-weight: bold;">Reject</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                        <i class="fa-solid fa-circle-check" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                        All caught up! No events pending approval.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $events->links() }}
    </div>
</div>
@endsection
