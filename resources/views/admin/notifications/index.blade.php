@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.organizer')

@section('title', 'All Notifications')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-weight: 800; color: #1e293b; margin: 0; font-size: 1.8rem;">Notifications</h1>
            <p style="color: #64748b; margin: 5px 0 0;">Manage your registration alerts and updates</p>
        </div>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
        <form action="{{ route('notifications.markRead') }}" method="POST">
            @csrf
            <button type="submit" style="background: var(--accent-soft-red); color: var(--corporate-red); border: 1px solid #f9dcdc; padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='var(--corporate-red)'; this.style.color='white';">
                <i class="fa-solid fa-check-double" style="margin-right: 8px;"></i> Mark All as Read
            </button>
        </form>
        @endif
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #10b981; color: #065f46; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div style="padding: 0;">
            @forelse($notifications as $notification)
                <div style="padding: 20px 30px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: flex-start; gap: 20px; {{ $notification->unread() ? 'background: #fdf2f2; border-left: 4px solid var(--corporate-red);' : 'padding-left: 34px;' }}">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $notification->unread() ? 'var(--corporate-red)' : '#f1f5f9' }}; color: {{ $notification->unread() ? 'white' : '#64748b' }}; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <h3 style="margin: 0; font-size: 1rem; font-weight: 700; color: #1e293b;">
                                {{ $notification->data['message'] ?? 'New Attendee Registered' }}
                            </h3>
                            <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p style="margin: 8px 0 0; color: #64748b; font-size: 0.9rem; line-height: 1.5;">
                            A new attendee named <strong>{{ $notification->data['attendee_name'] ?? 'N/A' }}</strong> has just registered for the event <strong>"{{ $notification->data['event_title'] ?? 'N/A' }}"</strong>.
                        </p>
                        <div style="margin-top: 15px; display: flex; gap: 10px;">
                            <a href="{{ route('admin.attendees.index') }}" style="font-size: 0.8rem; color: var(--corporate-red); text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                                View Registration <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 60px 30px; text-align: center;">
                    <i class="fa-solid fa-bell-slash" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 20px; display: block;"></i>
                    <h3 style="margin: 0; color: #64748b; font-weight: 700;">No notifications found</h3>
                    <p style="color: #94a3b8; margin: 10px 0 0;">When new attendees register, you'll see alerts here.</p>
                </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
            <div style="padding: 20px 30px; background: #f8fafc; border-top: 1px solid #f1f5f9;">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
