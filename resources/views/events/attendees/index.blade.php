@extends('layouts.organizer')

@section('title', 'Manage Members - EmCa TECHONOLOGY')

@section('content')
<!-- SECTION: PREMIUM HEADER -->
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);" class="member-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="flex: 1; min-width: 280px;">
            <h1 style="font-size: 2.22rem; color: #1a1a1a; margin: 0; font-weight: 800; letter-spacing: -0.5px; text-transform: none;" class="page-title">
                Member Directory
            </h1>
            <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
            <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;" class="page-subtitle">View and manage registered members who can access your events using their unique IDs.</p>
        </div>
        <div style="text-align: right;" class="header-actions">
            <p style="font-size: 0.8rem; color: #888; margin: 0; font-weight: 600;">Registrations are managed via the public event links.</p>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .member-header { padding: 20px !important; margin-bottom: 25px !important; }
        .page-title { font-size: 1.6rem !important; }
        .page-subtitle { font-size: 0.95rem !important; }
        .header-actions { text-align: left !important; width: 100%; }
        
        .col-id { width: 70px !important; }
        .col-events { width: 40px !important; }
        .col-status { width: 40px !important; }
        .col-action { width: 50px !important; }
        .hide-mobile { display: none !important; }
        .badge-compact { padding: 4px 8px !important; font-size: 0.6rem !important; }
    }
</style>

@if(session('success'))
    <div style="background: #eafaf1; border-left: 5px solid #2ecc71; color: #27ae60; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<!-- SECTION: MEMBERS TABLE -->
<div style="background: white; border: 1px solid #eee; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; width: 100%;">
    <div style="padding: 25px 35px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa; flex-wrap: wrap; gap: 15px;">
        <h2 style="margin: 0; font-size: 1.3rem; color: #333; font-weight: 700;">Verified Members</h2>
        
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999; font-size: 0.9rem;"></i>
                <input type="text" id="tableSearch" placeholder="Quick search members..." 
                    style="padding: 12px 15px 12px 42px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem; outline: none; width: 300px; transition: all 0.3s; background: white;"
                    onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px var(--accent-soft-red)';"
                    onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none';">
            </div>
            <div style="font-size: 0.9rem; color: #888; font-weight: 600;">Total Members: {{ $attendees->total() }}</div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="mainTable" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--corporate-red); color: white;">
                    <th style="padding: 20px 35px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Member</th>
                    <th style="padding: 20px 35px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-id">ID</th>
                    <th style="padding: 20px 35px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-events">Evts</th>
                    <th style="padding: 20px 35px; text-align: center; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-status">Status</th>
                    <th style="padding: 20px 35px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;" class="col-action">Act</th>
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
                            <td style="padding: 25px 35px; text-align: center;" class="col-id">
                                <div style="background: #FFF5F5; color: var(--corporate-red); padding: 6px 10px; border-radius: 8px; font-weight: 800; font-family: monospace; border: 1px dashed var(--corporate-red); display: inline-block; font-size: 0.85rem; letter-spacing: 0.5px;">
                                    {{ $attendee->access_code ?? 'N/A' }}
                                </div>
                            </td>
                            <td style="padding: 25px 35px; text-align: center;" class="col-events">
                                <div style="font-size: 1.1rem; font-weight: 800; color: #444;">{{ $attendee->registrations_count }}</div>
                            </td>
                            <td style="padding: 25px 35px; text-align: center;" class="col-status">
                                <span style="background: #eafaf1; color: #2ecc71; padding: 6px 12px; border-radius: 30px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 5px; border: 1px solid #d4efdf;" class="badge-compact">
                                    <i class="fa-solid fa-circle-check"></i> <span class="hide-mobile">VERIFIED</span>
                                </span>
                            </td>
                            <td style="padding: 25px 35px; text-align: right;" class="col-action">
                                <div style="display: flex; justify-content: flex-end; gap: 5px;">
                                    <a href="{{ route('organizer.attendees.edit', $attendee->id) }}" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #fef9e7; color: #f1c40f; border-radius: 6px; text-decoration: none;" title="Edit">
                                        <i class="fa-solid fa-pen" style="font-size: 0.8rem;"></i>
                                    </a>
                                    <form action="{{ route('organizer.attendees.destroy', $attendee->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="width: 32px; height: 32px; border: none; background: #FFF5F5; color: var(--corporate-red); border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="return confirm('Delete Member?')">
                                            <i class="fa-solid fa-trash-can" style="font-size: 0.8rem;"></i>
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
    </div>
    
    @if($attendees->hasPages())
        <div style="padding: 25px 35px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $attendees->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        let searchTerm = this.value.toLowerCase();
        let table = document.getElementById('mainTable');
        let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let row of rows) {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });
</script>
@endpush
