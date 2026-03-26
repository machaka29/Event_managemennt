@extends('layouts.admin')

@section('title', 'Attendee Directory - Admin Panel')

@section('content')
<div style="background: white; padding: 20px 25px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1 style="font-size: 1.3rem; color: #1e293b; margin: 0; font-weight: 800; text-transform: uppercase;">Attendee Directory</h1>
            <div style="width: 40px; height: 3px; background: var(--corporate-red); margin-top: 8px; border-radius: 2px;"></div>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 8px; font-weight: 600;">Full registry of all platform members and participants.</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div style="background: #FFF5F5; border-left: 4px solid var(--corporate-red); color: var(--corporate-red); padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 700;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div style="background: white; border: 1px solid #eee; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden;">
    <div style="padding: 15px 25px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa; flex-wrap: wrap; gap: 10px;">
        <h2 style="margin: 0; font-size: 0.85rem; color: #475569; font-weight: 700;">Global Members</h2>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.8rem;"></i>
                <input type="text" id="tableSearch" placeholder="Search members..." style="padding: 8px 15px 8px 35px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 0.8rem; outline: none; width: 250px; transition: all 0.2s;" onfocus="this.style.borderColor='var(--corporate-red)'; this.style.boxShadow='0 0 0 3px rgba(148,0,0,0.1)';" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
            </div>
            <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Total: {{ $attendees->total() }}</div>
        </div>
    </div>
    <div class="table-responsive" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 750px;">
            <thead>
                <tr style="background: var(--corporate-red); color: white;">
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Full Name</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Contact</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Organization</th>
                    <th style="padding: 12px 25px; text-align: left; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Joined</th>
                    <th style="padding: 12px 25px; text-align: right; font-weight: 800; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $attendee)
                    <tr style="border-bottom: 1px solid #f1f1f1; transition: all 0.2s;" onmouseover="this.style.background='#fdfdfd'" onmouseout="this.style.background='white'">
                        <td style="padding: 14px 25px; font-weight: 700; color: #1e293b; font-size: 0.9rem;">{{ $attendee->full_name }}</td>
                        <td style="padding: 14px 25px;">
                            <div style="font-size: 0.85rem; color: #475569; font-weight: 600;">{{ $attendee->phone }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 2px;">{{ $attendee->email }}</div>
                        </td>
                        <td style="padding: 14px 25px; color: #64748b; font-size: 0.85rem;">{{ $attendee->organization ?: '---' }}</td>
                        <td style="padding: 14px 25px; color: #64748b; font-size: 0.85rem;">{{ $attendee->created_at->format('M d, Y') }}</td>
                        <td style="padding: 14px 25px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.attendees.edit', $attendee->id) }}" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; color: #475569; border-radius: 8px; text-decoration: none; border: 1px solid #eee; transition: all 0.3s;" title="Edit Member" onmouseover="this.style.background='#f1f5f9'; this.style.color='var(--corporate-red)'; this.style.borderColor='var(--corporate-red)';" onmouseout="this.style.background='#f9f9f9'; this.style.color='#475569'; this.style.borderColor='#eee';">
                                    <i class="fa-solid fa-pencil" style="font-size: 0.85rem;"></i>
                                </a>
                                <form action="{{ route('admin.attendees.destroy', $attendee->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this member permanently?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="width: 36px; height: 36px; border: none; background: #FFF5F5; color: var(--corporate-red); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" title="Delete Member" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';" onmouseout="this.style.background='#FFF5F5'; this.style.color='var(--corporate-red)';">
                                        <i class="fa-solid fa-trash-can" style="font-size: 0.85rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($attendees->hasPages())
        <div style="padding: 15px 25px; border-top: 1px solid #eee; background: #fafafa;">
            {{ $attendees->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tableSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
