@extends('layouts.admin')

@section('title', 'System Reports - Admin Panel')

@section('content')
<div style="margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px;" class="report-header">
    <h1 style="color: #1e293b; font-size: 1.3rem; margin: 0; text-transform: uppercase; font-weight: 800;" class="page-title">System Analytics</h1>
    <p style="color: #64748b; font-size: 0.8rem; margin: 5px 0 0; font-weight: 600;" class="page-subtitle">Performance overview of event participation and attendance.</p>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid-admin" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 2rem;">
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; border-left: 5px solid var(--corporate-red); box-shadow: 0 4px 6px rgba(0,0,0,0.02);" class="stat-card">
        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">Total Events</div>
        <div style="font-size: 1.8rem; font-weight: 900; color: #1e293b;">{{ $stats['total_events'] }}</div>
        <div style="font-size: 0.7rem; font-weight: 700; color: var(--corporate-red); margin-top: 8px; background: var(--accent-soft-red); display: inline-block; padding: 2px 8px; border-radius: 4px;">{{ $stats['total_events_this_month'] }} this month</div>
    </div>
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; border-left: 5px solid var(--corporate-red); box-shadow: 0 4px 6px rgba(0,0,0,0.02);" class="stat-card">
        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">Total Members</div>
        <div style="font-size: 1.8rem; font-weight: 900; color: #1e293b;">{{ number_format($stats['total_registrations']) }}</div>
        <div style="font-size: 0.7rem; font-weight: 700; color: #059669; margin-top: 8px; background: #ecfdf5; display: inline-block; padding: 2px 8px; border-radius: 4px;"><i class="fa-solid fa-arrow-trend-up"></i> {{ $stats['avg_registrations'] }} avg</div>
    </div>
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; border-left: 5px solid var(--corporate-red); box-shadow: 0 4px 6px rgba(0,0,0,0.02);" class="stat-card">
        <div style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">Show-up Rate</div>
        <div style="font-size: 1.8rem; font-weight: 900; color: #1e293b;">{{ $stats['attendance_percentage'] }}%</div>
        <div style="margin-top: 12px; height: 6px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
            <div style="width: {{ $stats['attendance_percentage'] }}%; height: 100%; background: var(--corporate-red);"></div>
        </div>
    </div>
</div>

{{-- TABLE + CHART SIDE BY SIDE --}}
<div style="display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; align-items: start;">

    {{-- TOP EVENTS TABLE --}}
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02);" class="table-container">
        <div style="padding: 15px 20px; background: #fafafa; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; color: #475569;">Top Performing Events</h3>
            <button onclick="window.print()" class="hide-mobile" style="font-size: 0.65rem; font-weight: 800; color: var(--corporate-red); background: var(--accent-soft-red); padding: 5px 12px; border-radius: 6px; border: 1px solid rgba(148,0,0,0.1); cursor: pointer;">
                <i class="fa-solid fa-print"></i> PDF
            </button>
        </div>
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--corporate-red); color: white;">
                        <th style="padding: 12px 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: left;">Event Name</th>
                        <th style="padding: 12px 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;" class="col-reg">Reg.</th>
                        <th style="padding: 12px 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: center;" class="col-att">Att.</th>
                        <th style="padding: 12px 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; text-align: right;">Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats['popular_events'] as $event)
                        @php 
                            $rate = $event->registrations_count > 0 ? round(($event->attendance_count / $event->registrations_count) * 100, 1) : 0;
                        @endphp
                        <tr style="border-bottom: 1px solid #f8fafc;">
                            <td style="padding: 12px 20px; font-weight: 700; color: #1e293b; font-size: 0.85rem;">{{ Str::limit($event->title, 25) }}</td>
                            <td style="padding: 12px 10px; text-align: center; font-weight: 700; color: #64748b; font-size: 0.85rem;" class="col-reg">{{ $event->registrations_count }}</td>
                            <td style="padding: 12px 10px; text-align: center; font-weight: 800; color: var(--corporate-red); font-size: 0.85rem;" class="col-att">{{ $event->attendance_count }}</td>
                            <td style="padding: 12px 20px; text-align: right;">
                                <span style="font-weight: 900; color: {{ $rate > 50 ? '#059669' : 'var(--corporate-red)' }}; font-size: 0.8rem; background: {{ $rate > 50 ? '#ecfdf5' : '#FFF5F5' }}; padding: 3px 8px; border-radius: 4px;">{{ $rate }}%</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- REGISTRATION TRENDS --}}
    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; display: flex; flex-direction: column;">
        <div style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9;">
            <h3 style="margin: 0 0 5px; font-size: 0.9rem; font-weight: 800; text-transform: uppercase; color: #1e293b;">Registration Activity</h3>
            <p style="margin: 0; font-size: 0.75rem; color: #64748b; font-weight: 600;">Monthly signup volume distribution.</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; flex: 1; justify-content: center;">
            @php $maxCount = $stats['registration_trend']->max('count') ?: 1; @endphp
            
            @forelse($stats['registration_trend'] as $trend)
                @php $percentage = ($trend->count / $maxCount) * 100; @endphp
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                        <span style="font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase;">
                            <i class="fa-regular fa-calendar" style="color: #cbd5e1; margin-right: 5px;"></i>
                            {{ \Carbon\Carbon::parse($trend->month)->format('M y') }}
                        </span>
                        <span style="font-size: 0.85rem; font-weight: 900; color: var(--corporate-red);">{{ $trend->count }}</span>
                    </div>
                    <div style="height: 6px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: {{ $percentage }}%; height: 100%; background: linear-gradient(90deg, #FFF5F5, var(--corporate-red)); border-radius: 10px;"></div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 20px 0; color: #94a3b8; font-size: 0.8rem; font-weight: 600;">
                    No registration data available yet.
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- EXPORT SECTION --}}
<div style="margin-top: 2rem; text-align: center; background: #fafafa; padding: 30px; border-radius: 10px; border: 1px solid #e2e8f0;">
    <i class="fa-solid fa-file-pdf" style="font-size: 1.5rem; color: var(--corporate-red); margin-bottom: 10px;"></i>
    <h4 style="margin: 0 0 8px; color: #1e293b; font-weight: 800; text-transform: uppercase; font-size: 0.9rem;">Generate Report</h4>
    <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 15px;">Download a printable PDF of current analytics.</p>
    <button class="btn btn-primary" onclick="window.print()" style="padding: 0 30px; height: 42px; font-size: 0.8rem;">
        <i class="fa-solid fa-download" style="margin-right: 8px;"></i> EXPORT PDF
    </button>
</div>

<style>
    @media (max-width: 768px) {
        .report-header { text-align: left !important; margin-bottom: 20px !important; }
        .page-title { font-size: 1.4rem !important; }
        .page-subtitle { font-size: 0.8rem !important; }
        
        .stats-grid-admin { 
            grid-template-columns: repeat(3, 1fr) !important; 
            gap: 8px !important; 
            margin-bottom: 25px !important;
        }
        .stat-card { 
            padding: 12px 5px !important; 
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            gap: 8px !important;
            border-left-width: 3px !important;
        }
        .stat-card div:first-child { font-size: 0.6rem !important; margin-bottom: 5px !important; }
        .stat-card div:nth-child(2) { font-size: 1.25rem !important; }
        .stat-card div:last-child { font-size: 0.55rem !important; padding: 2px 5px !important; }
        
        div[style*="grid-template-columns: 1fr 300px"] { grid-template-columns: 1fr !important; gap: 20px !important; }
        
        .col-reg, .col-att { width: 50px !important; font-size: 0.6rem !important; }
        .table-responsive td { padding: 12px 10px !important; font-size: 0.75rem !important; }
        .hide-mobile { display: none !important; }
    }
</style>
@endsection
