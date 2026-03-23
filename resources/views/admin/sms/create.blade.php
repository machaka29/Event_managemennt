@extends('layouts.admin')

@section('title', 'SMS Broadcast - Admin Panel')

@section('content')
<div style="background: white; padding: 40px; border-radius: 12px; border: 1px solid #eee; margin-bottom: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <h1 style="font-size: 2.22rem; color: #333; margin: 0; font-weight: 800; letter-spacing: -0.5px;">SMS Broadcast Center</h1>
    <div style="width: 60px; height: 4px; background: var(--corporate-red); margin-top: 12px; border-radius: 2px;"></div>
    <p style="font-size: 1.1rem; color: #666; margin-top: 15px; font-weight: 500;">Send informational text messages directly to members' phones using NextSMS.</p>
</div>

@if(session('success'))
    <div style="background: #FFF5F5; border-left: 5px solid var(--corporate-red); color: var(--corporate-red); padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #f9f9f9; border-left: 5px solid #333; color: #333; padding: 15px 25px; border-radius: 8px; margin-bottom: 30px; font-weight: 600;">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
    </div>
@endif

<div style="background: white; border: 1px solid #eee; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 800px;">
    <form action="{{ route('admin.sms.send') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
            <div>
                <label style="display: block; font-weight: 800; color: #333; margin-bottom: 8px;">Sender ID / Name</label>
                <input type="text" name="sender_id" placeholder="e.g. EMCA_TECH" maxlength="11" style="width: 100%; padding: 15px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                <p style="color: #888; font-size: 0.75rem; margin-top: 5px;">Max 11 alphanumeric characters.</p>
            </div>
            <div>
                <label style="display: block; font-weight: 800; color: #333; margin-bottom: 8px;">Target Audience</label>
                <select name="target_audience" required style="width: 100%; padding: 15px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'">
                    <option value="all">Every Registered Member</option>
                    <optgroup label="Specific Event Attendees">
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }} ({{ $event->registrations_count }} registered)</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 8px;">
                <label style="display: block; font-weight: 800; color: #333;">SMS Message</label>
                <span id="charCount" style="font-size: 0.85rem; color: #888; font-weight: bold; background: #eee; padding: 4px 10px; border-radius: 20px;">0 chars | 1 SMS</span>
            </div>
            
            <textarea name="message" id="smsMessage" rows="5" required placeholder="Type your broadcast message here..." style="width: 100%; padding: 15px 20px; border: 2px solid #eee; border-radius: 10px; font-size: 1rem; font-family: inherit; outline: none; resize: vertical; transition: 0.3s;" onfocus="this.style.borderColor='var(--corporate-red)'" onblur="this.style.borderColor='#eee'"></textarea>
            
            <p style="color: #666; font-size: 0.85rem; margin-top: 10px;">
                <i class="fa-solid fa-circle-info" style="color: var(--corporate-red);"></i> 
                Standard SMS limit is 160 characters. Messages longer than this will be split and charged as multiple SMS pages by the network provider.
            </p>
        </div>

        <button type="submit" onclick="return confirm('Are you sure you want to send this broadcast message? This action is irreversible.');" style="background: var(--corporate-red); color: white; border: none; padding: 16px 35px; border-radius: 10px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(148,0,0,0.2); width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <i class="fa-solid fa-paper-plane"></i> DISPATCH BROADCAST
        </button>
    </form>
</div>

<script>
    document.getElementById('smsMessage').addEventListener('input', function() {
        const length = this.value.length;
        const smsCount = Math.ceil((length > 0 ? length : 1) / 160);
        document.getElementById('charCount').textContent = `${length} chars | ${smsCount} SMS`;
        
        if (smsCount > 1) {
            document.getElementById('charCount').style.background = '#FFF5F5';
            document.getElementById('charCount').style.color = 'var(--corporate-red)';
            document.getElementById('charCount').style.border = '1px solid var(--corporate-red)';
        } else {
            document.getElementById('charCount').style.background = '#eee';
            document.getElementById('charCount').style.color = '#888';
            document.getElementById('charCount').style.border = 'none';
        }
    });
</script>
@endsection
