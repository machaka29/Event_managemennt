<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Attendee;
use App\Services\NextSmsService;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $smsService;

    public function __construct(NextSmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function dashboard()
    {
        // 1. Statistics Cards
        $totalEvents = Event::count();
        $upcomingEventsCount = Event::where('date', '>', now())->count();
        $totalRegistrations = Attendee::count();
        $registrationsThisMonth = Attendee::where('created_at', '>=', now()->startOfMonth())->count();
        $activeEventsCount = Event::where('status', 'approved')->where('date', '>=', now()->toDateString())->count();
        $ongoingEventsCount = Event::where('status', 'approved')->where('date', '=', now()->toDateString())->count();
        $totalAttendance = Registration::where('attended', true)->count();
        $ongoingAttendance = Registration::where('attended', true)->whereHas('event', function($q) {
            $q->where('date', '=', now()->toDateString());
        })->count();
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
            'active_organizers' => User::where('role', 'organizer')->count(),
            'unread_registrations' => Registration::where('is_read', false)->count()
        ];

        return view('admin.dashboard', compact(
            'totalEvents', 'upcomingEventsCount', 'totalRegistrations', 'registrationsThisMonth',
            'activeEventsCount', 'ongoingEventsCount', 'totalOrganizers', 'pendingOrganizers',
            'totalAttendance', 'ongoingAttendance',
            'recentEvents', 'recentRegistrations', 'registrationsByWeek', 'systemStats'
        ));
    }

    public function search(Request $request)
    {
        $query = trim($request->input('query'));
        
        if (!$query) {
            return redirect()->route('admin.dashboard');
        }

        $lowQuery = strtolower($query);

        // Events Search
        if (in_array($lowQuery, ['event', 'events'])) {
            $events = Event::with(['organizer', 'registrations.attendee'])->latest()->get();
        } else {
            $events = Event::with(['organizer', 'registrations.attendee'])
                ->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhere('location', 'like', "%{$query}%")
                ->latest()
                ->get();
        }

        // Organizers Search
        if (in_array($lowQuery, ['organizer', 'organizers'])) {
            $organizers = User::where('role', 'organizer')->latest()->get();
        } else {
            $organizers = User::where('role', 'organizer')
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->orWhere('organization', 'like', "%{$query}%");
                })
                ->latest()
                ->get();
        }

        // Attendees Search
        if (in_array($lowQuery, ['attendee', 'attendees', 'member', 'members'])) {
            $attendees = Attendee::latest()->get();
        } else {
            $attendees = Attendee::where('full_name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('organization', 'like', "%{$query}%")
                ->orWhere('access_code', 'like', "%{$query}%")
                ->latest()
                ->get();
        }

        return view('admin.search', compact('events', 'organizers', 'attendees', 'query'));
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

    public function eventEdit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function eventUpdate(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'target_audience' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'reg_start_date' => 'required|date',
            'reg_end_date' => 'required|date',
            'gate_password' => 'required|string|min:4',
        ]);

        $event->update($validated);
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function eventDestroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function attendees()
    {
        // Mark unread as read when viewing the list
        Registration::where('is_read', false)->update(['is_read' => true]);
        
        $attendees = Registration::with(['event', 'attendee'])->latest()->paginate(10);
        return view('admin.attendees.index', compact('attendees'));
    }

    public function reports()
    {
        // 1. Attendance Statistics
        $totalRegistrations = Registration::count();
        $totalAttendance = Registration::where('attended', true)->count();
        $attendancePercentage = $totalRegistrations > 0 ? round(($totalAttendance / $totalRegistrations) * 100, 1) : 0;

        // Peak Check-in Time (Most common hour of updated_at where attended=true)
        $peakCheckin = Registration::where('attended', true)
            ->select(DB::raw('HOUR(updated_at) as hour'), DB::raw('count(*) as count'))
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->first();
        
        $peakHour = $peakCheckin ? \Carbon\Carbon::createFromTime($peakCheckin->hour)->format('h A') : 'N/A';

        // 2. Event Participation Summaries
        $totalEvents = Event::count();
        $totalEventsThisMonth = Event::whereYear('date', now()->year)->whereMonth('date', now()->month)->count();
        $totalEventsThisYear = Event::whereYear('date', now()->year)->count();
        
        $avgRegistrations = $totalEvents > 0 ? round($totalRegistrations / $totalEvents, 1) : 0;

        $popularEvents = Event::withCount(['registrations', 'registrations as attendance_count' => function($q) {
                $q->where('attended', true);
            }])
            ->orderBy('registrations_count', 'desc')
            ->take(8)
            ->get();

        // Registration trends (Last 6 months)
        $registrationTrend = Registration::select(
            DB::raw('count(*) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->take(6)
        ->get()
        ->reverse();

        $stats = [
            'total_registrations' => $totalRegistrations,
            'total_attendance' => $totalAttendance,
            'attendance_percentage' => $attendancePercentage,
            'peak_hour' => $peakHour,
            'total_events' => $totalEvents,
            'total_events_this_month' => $totalEventsThisMonth,
            'total_events_this_year' => $totalEventsThisYear,
            'avg_registrations' => $avgRegistrations,
            'popular_events' => $popularEvents,
            'registration_trend' => $registrationTrend,
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
        if ($request->filled('phone_number')) {
            $phoneNumber = ltrim($request->phone_number, '0');
            $request->merge(['phone' => '+255' . $phoneNumber]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.-]+$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => ['required', 'string', 'regex:/^\+255[0-9]{9}$/'],
            'organization' => ['required', 'string', 'max:255', 'regex:/[a-zA-Z]/'],
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization' => $request->organization,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'organizer',
        ]);

        // Send SMS Notification
        try {
            $message = "Hello {$request->name}, your Organizer account has been created. Email: {$request->email}, Password: {$request->password}. Login at: " . url('/login');
            $this->smsService->sendSms($request->phone, $message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send organizer SMS: " . $e->getMessage());
        }

        return redirect()->route('admin.organizers.index')->with('success', 'Organizer account created successfully and credentials sent via SMS.');
    }

    public function organizerEdit(User $organizer)
    {
        return view('admin.organizers.edit', compact('organizer'));
    }

    public function organizerUpdate(Request $request, User $organizer)
    {
        if ($request->filled('phone_number')) {
            $phoneNumber = ltrim($request->phone_number, '0');
            $request->merge(['phone' => '+255' . $phoneNumber]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.-]+$/'],
            'email' => 'required|string|email|max:255|unique:users,email,' . $organizer->id,
            'phone' => ['required', 'string', 'regex:/^\+255[0-9]{9}$/'],
            'organization' => ['required', 'string', 'max:255', 'regex:/[a-zA-Z]/'],
        ]);

        $organizer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'organization' => $request->organization,
        ]);

        if ($request->filled('password')) {
            $organizer->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        return redirect()->route('admin.organizers.index')->with('success', 'Organizer updated successfully.');
    }

    public function organizerDestroy(User $organizer)
    {
        $organizer->delete();
        return redirect()->route('admin.organizers.index')->with('success', 'Organizer deleted successfully.');
    }

    // attendeeCreate and attendeeStore removed to enforce public-only registration

    public function attendeeEdit(Attendee $attendee)
    {
        return view('events.attendees.edit', compact('attendee'));
    }

    public function attendeeUpdate(Request $request, Attendee $attendee)
    {
        if ($request->filled('phone_number')) {
            $phoneNumber = ltrim($request->phone_number, '0');
            $request->merge(['phone' => '+255' . $phoneNumber]);
        }

        $request->validate([
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s.-]+$/'],
            'email' => 'required|email|max:255|unique:attendees,email,' . $attendee->id,
            'phone' => ['nullable', 'string', 'regex:/^\+255[0-9]{9}$/'],
            'organization' => ['nullable', 'string', 'max:255', 'regex:/[a-zA-Z]/'],
        ]);

        $attendee->update($request->only(['full_name', 'email', 'phone', 'organization']));

        return redirect()->route('admin.attendees.list')->with('success', 'Member updated successfully.');
    }

    public function eventShow(Event $event)
    {
        $event->load(['registrations.attendee', 'organizer']);
        return view('admin.events.show', compact('event'));
    }

    public function attendeeDestroy(Attendee $attendee)
    {
        $attendee->delete();
        return redirect()->route('admin.attendees.list')->with('success', 'Member deleted successfully.');
    }

    public function markNotificationsRead()
    {
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                Registration::where('is_read', false)->update(['is_read' => true]);
            } else {
                $myEventIds = auth()->user()->events()->pluck('id');
                Registration::whereIn('event_id', $myEventIds)->where('is_read', false)->update(['is_read' => true]);
            }
        }
        return response()->json(['success' => true]);
    }
}
