@extends('layouts.organizer')

@section('title', 'Manage Members - EmCa Technologies')

@section('content')
<!-- SECTION: PREMIUM HEADER -->
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2.22rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px; text-transform: none;">
                Member Directory
            </h1>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
            <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">View and manage registered members who can access your events using their unique IDs.</p>
        </div>
        <div style="text-align: right;">
            <!-- Member addition by Organizer disabled as per request -->
        </div>
    </div>
</div>

@if(session('success'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<!-- SECTION: MEMBERS TABLE -->
<div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
    <div style="padding: 25px 35px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
        <h2 style="margin: 0; font-size: 1.3rem; color: #333; font-weight: 700;">Verified Members</h2>
        <div style="font-size: 0.9rem; color: #888;">Total Members: {{ $attendees->total() }}</div>
    </div>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding: 20px 35px; text-align: left; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Member Info</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Access ID</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Events joined</th>
                <th style="padding: 20px 35px; text-align: center; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Status</th>
                <th style="padding: 20px 35px; text-align: right; color: #555; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #eee; letter-spacing: 1px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($attendees->count() > 0)
                @foreach($attendees as $attendee)
                    <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                        <td style="padding: 25px 35px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 45px; height: 45px; border-radius: 10px; background: #eee; color: #555; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem;">
                                    {{ strtoupper(substr($attendee->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1a1a1a; font-size: 1.1rem;">{{ $attendee->full_name }}</div>
                                    <div style="color: #888; font-size: 0.85rem;">{{ $attendee->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 25px 35px; text-align: center;">
                            <div style="background: #FFF5F5; color: var(--corporate-red); padding: 8px 15px; border-radius: 10px; font-weight: 800; font-family: monospace; border: 1px dashed var(--corporate-red); display: inline-block; font-size: 1rem; letter-spacing: 1px;">
                                {{ $attendee->access_code ?? 'NO-ID' }}
                            </div>
                        </td>
                        <td style="padding: 25px 35px; text-align: center;">
                            <div style="font-size: 1.2rem; font-weight: 800; color: #444;">{{ $attendee->registrations_count }}</div>
                        </td>
                        <td style="padding: 25px 35px; text-align: center;">
                            <span style="background: #eafaf1; color: #2ecc71; padding: 6px 15px; border-radius: 30px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #d4efdf;">
                                <i class="fa-solid fa-circle-check"></i> VERIFIED
                            </span>
                        </td>
                        <td style="padding: 25px 35px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                                <button onclick="navigator.clipboard.writeText('{{ $attendee->access_code }}'); alert('ID Copied!');" style="width: 40px; height: 40px; border: none; background: #f5f5f5; color: #666; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='#eee';" title="Copy Access ID">
                                    <i class="fa-solid fa-copy"></i>
                                </button>
                                <a href="{{ route('organizer.attendees.edit', $attendee->id) }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #fef9e7; color: #f1c40f; border-radius: 8px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#f1c40f'; this.style.color='white';" onmouseout="this.style.background='#fef9e7'; this.style.color='#f1c40f';" title="Edit Member">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('organizer.attendees.destroy', $attendee->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this member? This action cannot be undone.');">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" style="width: 40px; height: 40px; border: none; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='#FFF5F5'; this.style.color='var(--corporate-red)';" title="Delete Member">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="padding: 80px; text-align: center; color: #bbb;">
                        <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.2;"><i class="fa-solid fa-users-slash"></i></div>
                        <div style="font-size: 1.2rem; font-weight: 600;">No members registered in your database.</div>
                        <p style="margin-top: 10px;">Add your first member to provide them event access.</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    
    @if($attendees->hasPages())
        <div style="padding: 25px 35px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $attendees->links() }}
        </div>
    @endif
</div>
@endsection
