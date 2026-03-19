@extends('layouts.admin')

@section('title', 'Unique Attendees - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Global Attendees</h1>
        <p style="color: #666; font-size: 1rem;">View all unique people who have registered for any event.</p>
    </div>
</div>

<div class="card" style="max-width: 100%; border: 1px solid var(--corporate-red); border-radius: 8px; overflow: hidden; padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--header-gradient); text-align: left; border-bottom: 2px solid var(--corporate-red);">
                <th style="padding: 15px 20px; color: var(--corporate-red);">Full Name</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Email</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Phone</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Organization</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: center;">Events</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: right;">Joined</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendees as $attendee)
                <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $attendee->full_name }}</td>
                    <td style="padding: 15px 20px;">{{ $attendee->email }}</td>
                    <td style="padding: 15px 20px;">{{ $attendee->phone }}</td>
                    <td style="padding: 15px 20px;">{{ $attendee->organization ?? 'N/A' }}</td>
                    <td style="padding: 15px 20px; text-align: center;">
                        <span style="background: var(--corporate-red); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem;">
                            {{ $attendee->registrations_count }}
                        </span>
                    </td>
                    <td style="padding: 15px 20px; text-align: right;">
                        {{ $attendee->created_at->format('M d, Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $attendees->links() }}
    </div>
</div>
@endsection
