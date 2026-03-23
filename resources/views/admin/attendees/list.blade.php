@extends('layouts.admin')

@section('title', 'Unique Attendees - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">Global Members</h1>
        <p style="color: #666; font-size: 1rem;">View all registered members who can access events with their IDs.</p>
    </div>
    <a href="{{ route('admin.attendees.create') }}" class="btn" style="background: var(--corporate-red); color: white; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-user-plus"></i> ADD NEW MEMBER
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
                <th style="padding: 15px 20px; color: var(--corporate-red);">Member Name</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Email</th>
                <th style="padding: 15px 20px; color: var(--corporate-red);">Access ID</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: center;">Events</th>
                <th style="padding: 15px 20px; color: var(--corporate-red); text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendees as $attendee)
                <tr style="border-bottom: 1px solid #FFF5F5; transition: background 0.2s;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='white'">
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $attendee->full_name }}</td>
                    <td style="padding: 15px 20px; color: #666;">{{ $attendee->email }}</td>
                    <td style="padding: 15px 20px;">
                        <code style="background: var(--accent-soft-red); color: var(--corporate-red); padding: 4px 8px; border-radius: 4px; font-weight: bold; border: 1px dashed var(--corporate-red);">
                            {{ $attendee->access_code ?? 'N/A' }}
                        </code>
                    </td>
                    <td style="padding: 15px 20px; text-align: center;">
                        <span style="background: var(--corporate-red); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem;">
                            {{ $attendee->registrations_count }}
                        </span>
                    </td>
                    <td style="padding: 15px 20px; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <button onclick="navigator.clipboard.writeText('{{ $attendee->access_code }}'); alert('ID Copied!');" style="background: none; border: 1px solid #eee; color: #888; padding: 5px 10px; border-radius: 4px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.borderColor='var(--corporate-red)'; this.style.color='var(--corporate-red)';" title="Copy Access ID">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <a href="{{ route('admin.attendees.edit', $attendee->id) }}" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #fef9e7; color: #f1c40f; border-radius: 4px; border: 1px solid #eee; text-decoration: none; transition: 0.3s;" onmouseover="this.style.background='#f1c40f'; this.style.color='white';" title="Edit Member">
                                <i class="fa-solid fa-pencil" style="font-size: 0.8rem;"></i>
                            </a>
                            <form action="{{ route('admin.attendees.destroy', $attendee->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this member? This action cannot be undone.');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" style="width: 32px; height: 32px; border: 1px solid #eee; background: #FFF5F5; color: var(--corporate-red); border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s;" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" title="Delete Member">
                                    <i class="fa-solid fa-trash-can" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </div>
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
