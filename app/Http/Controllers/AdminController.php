<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Attendee;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistics Cards
        $totalEvents = Event::count();
        $upcomingEventsCount = Event::where('date', '>', now())->count();
        $totalRegistrations = Registration::count();
        $registrationsThisMonth = Registration::where('created_at', '>=', now()->startOfMonth())->count();
        $activeEventsCount = Event::where('status', 'approved')->where('date', '>=', now()->toDateString())->count();
        $ongoingEventsCount = Event::where('status', 'approved')->where('date', '=', now()->toDateString())->count();
        $totalOrganizers = User::where('role', 'organizer')->count();
        $pendingOrganizers = 0; // No status column in users yet, using 0

        // 2. Recent Events
        $recentEvents = Event::with('organizer')
            ->withCount('registrations')
            ->latest()
            ->take(5)
            ->get();

        // 3. Recent Registrations
        $recentRegistrations = Registration::with(['event', 'attendee'])
            ->latest()
            ->take(5)
            ->get();

        // 4. Registrations This Month (Weekly)
        $registrationsByWeek = [];
        for ($i = 0; $i < 4; $i++) {
            $start = now()->startOfMonth()->addWeeks($i);
            $end = (clone $start)->endOfWeek();
            $registrationsByWeek[] = Registration::whereBetween('created_at', [$start, $end])->count();
        }

        // 5. System Statistics
        $systemStats = [
            'total_attendees' => Attendee::count(),
            'pending_approvals' => Event::where('status', 'pending')->count(),
            'events_this_month' => Event::where('created_at', '>=', now()->startOfMonth())->count(),
            'active_organizers' => User::where('role', 'organizer')->count()
        ];

        return view('admin.dashboard', compact(
            'totalEvents', 'upcomingEventsCount', 'totalRegistrations', 'registrationsThisMonth',
            'activeEventsCount', 'ongoingEventsCount', 'totalOrganizers', 'pendingOrganizers',
            'recentEvents', 'recentRegistrations', 'registrationsByWeek', 'systemStats'
        ));
    }

    public function organizers()
    {
        $organizers = User::where('role', 'organizer')->latest()->paginate(10);
        return view('admin.organizers.index', compact('organizers'));
    }

    public function events()
    {
        $events = Event::with('organizer')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function pendingEvents()
    {
        $events = Event::with('organizer')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.events.pending', compact('events'));
    }

    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'approved']);
        return back()->with('success', 'Event approved successfully.');
    }

    public function rejectEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'rejected']);
        return back()->with('success', 'Event rejected.');
    }

    public function attendees()
    {
        $attendees = Registration::with(['event', 'attendee'])->latest()->paginate(10);
        return view('admin.attendees.index', compact('attendees'));
    }

    public function reports()
    {
        // Simple aggregate report data
        $stats = [
            'total_registrations' => Registration::count(),
            'total_attendance' => Registration::where('attended', true)->count(),
            'events_by_month' => Event::select(DB::raw('count(*) as count, MONTH(date) as month'))
                ->groupBy('month')
                ->get(),
            'popular_events' => Event::withCount('registrations')
                ->orderBy('registrations_count', 'desc')
                ->take(5)
                ->get()
        ];
        
        return view('admin.reports.index', compact('stats'));
    }

    public function globalAttendees()
    {
        $attendees = Attendee::withCount('registrations')->latest()->paginate(10);
        return view('admin.attendees.list', compact('attendees'));
    }

    public function organizerCreate()
    {
        return view('admin.organizers.create');
    }

    public function organizerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'organizer',
        ]);

        return redirect()->route('admin.organizers.index')->with('success', 'Organizer account created successfully.');
    }

    public function attendeeCreate()
    {
        return view('admin.attendees.create');
    }

    public function attendeeStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:attendees',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
        ]);

        $count = Attendee::count() + 1;
        $access_code = 'EM-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        Attendee::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization' => $request->organization,
            'access_code' => $access_code,
        ]);

        return redirect()->route('admin.attendees.list')->with('success', 'Member registered successfully. ID: ' . $access_code);
    }

    public function attendeeEdit(Attendee $attendee)
    {
        return view('events.attendees.edit', compact('attendee'));
    }

    public function attendeeUpdate(Request $request, Attendee $attendee)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:attendees,email,' . $attendee->id,
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
        ]);

        $attendee->update($request->only(['full_name', 'email', 'phone', 'organization']));

        return redirect()->route('admin.attendees.list')->with('success', 'Member updated successfully.');
    }

    public function attendeeDestroy(Attendee $attendee)
    {
        $attendee->delete();
        return redirect()->route('admin.attendees.list')->with('success', 'Member deleted successfully.');
    }
}
