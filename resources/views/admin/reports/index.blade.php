@extends('layouts.admin')

@section('title', 'System Reports - Admin Panel')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="color: #333; font-size: 1.8rem; margin-bottom: 0.5rem; text-transform: uppercase;">System Reports</h1>
    <p style="color: #666; font-size: 1rem;">Analytics and performance overview of the registration system.</p>
</div>

<div class="grid grid-cols-2" style="gap: 30px; margin-bottom: 40px;">
    <!-- Overview Card -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="margin: 0 0 1.5rem; color: #333; font-size: 1.2rem; text-transform: uppercase;">Response Overview</h3>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <div style="font-size: 2.5rem; font-weight: bold; color: var(--corporate-red);">{{ $stats['total_registrations'] }}</div>
                    <div style="color: #666; font-size: 0.9rem;">Total Registrations</div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 2.5rem; font-weight: bold; color: #10b981;">{{ $stats['total_attendance'] }}</div>
                    <div style="color: #666; font-size: 0.9rem;">Total Attendance</div>
                </div>
            </div>
            
            <div style="background: #e0e0e0; height: 10px; border-radius: 5px; overflow: hidden; margin-top: 10px;">
                @php 
                    $percent = $stats['total_registrations'] > 0 ? ($stats['total_attendance'] / $stats['total_registrations']) * 100 : 0;
                @endphp
                <div style="background: #10b981; width: {{ $percent }}%; height: 100%;"></div>
            </div>
            <p style="font-size: 0.85rem; color: #666; text-align: center;">Attendance Rate: <strong>{{ number_format($percent, 1) }}%</strong></p>
        </div>
    </div>

    <!-- Monthly Stats -->
    <div style="background: #FFF5F5; border: 1px solid var(--corporate-red); border-radius: 8px; padding: 25px;">
        <h3 style="margin: 0 0 1.5rem; color: #333; font-size: 1.2rem; text-transform: uppercase;">Event Velocity</h3>
        <div style="display: flex; align-items: flex-end; gap: 10px; height: 150px; padding-top: 20px;">
            @foreach(range(1, 12) as $m)
                @php 
                    $count = $stats['events_by_month']->where('month', $m)->first()->count ?? 0;
                    $height = min($count * 20, 100); // Scale for display
                @endphp
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px;">
                    <div style="background: var(--corporate-red); width: 100%; height: {{ $height }}px; border-radius: 3px 3px 0 0; min-height: 2px;" title="{{ $count }} events"></div>
                    <span style="font-size: 0.7rem; color: #999;">{{ date('M', mktime(0, 0, 0, $m, 1)) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card" style="max-width: 100%; border: 1px solid var(--corporate-red); border-radius: 8px; overflow: hidden; padding: 0;">
    <div style="background: var(--header-gradient); padding: 15px 20px; border-bottom: 2px solid var(--corporate-red);">
        <h3 style="margin: 0; color: var(--corporate-red); font-size: 1.1rem; text-transform: uppercase;">Top Performing Events</h3>
    </div>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #FFF5F5;">
                <th style="padding: 15px 20px; color: #666;">Rank</th>
                <th style="padding: 15px 20px; color: #666;">Event Title</th>
                <th style="padding: 15px 20px; color: #666;">Registrations</th>
                <th style="padding: 15px 20px; color: #666;">Capacity</th>
                <th style="padding: 15px 20px; color: #666; text-align: right;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['popular_events'] as $index => $event)
                <tr style="border-bottom: 1px solid #FFF5F5;">
                    <td style="padding: 15px 20px; font-weight: bold; color: var(--corporate-red);">#{{ $index + 1 }}</td>
                    <td style="padding: 15px 20px; font-weight: bold;">{{ $event->title }}</td>
                    <td style="padding: 15px 20px;">{{ $event->registrations_count }}</td>
                    <td style="padding: 15px 20px;">{{ $event->capacity }}</td>
                    <td style="padding: 15px 20px; text-align: right;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; background: #FFF5F5; color: var(--corporate-red); border: 1px solid var(--corporate-red);">
                            {{ strtoupper($event->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 30px; text-align: center;">
    <button class="btn btn-primary" onclick="window.print()" style="padding: 12px 30px;">
        <i class="fa-solid fa-print"></i> Print Full Report
    </button>
</div>
@endsection
