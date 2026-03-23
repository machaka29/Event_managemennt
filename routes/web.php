<?php

use App\Http\Controllers\MemberGateController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Member Gate Routes
Route::get('/gate', [MemberGateController::class, 'showGate'])->name('member.gate');
Route::post('/gate', [MemberGateController::class, 'verifyGate'])->name('member.gate.verify');
Route::get('/member/logout', [MemberGateController::class, 'logout'])->name('member.logout.get');
Route::post('/member/logout', [MemberGateController::class, 'logout'])->name('member.logout');

// Public Event Routes
Route::get('/', [PublicEventController::class, 'index'])->name('home');
Route::get('/events/public/{id}', [PublicEventController::class, 'show'])->name('events.public.show');

// Protected Public Routes
Route::middleware('member.access')->group(function () {
    Route::post('/events/public/{id}/register', [PublicEventController::class, 'register'])->name('events.public.register');
    Route::get('/tickets/{ticket_id}', [PublicEventController::class, 'ticket'])->name('events.public.ticket');
    Route::get('/tickets/{ticket_id}/download', [PublicEventController::class, 'downloadTicket'])->name('events.public.ticket.download');
    Route::get('/verify/{ticket_id}', [PublicEventController::class, 'verifyTicket'])->name('events.public.verify');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Registration disabled for public
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'updateInfo'])->name('profile.info');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Organizer Routes
    Route::middleware('role:organizer')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\EventController::class, 'index'])->name('dashboard');
        Route::get('/organizer/events', [\App\Http\Controllers\EventController::class, 'allEvents'])->name('organizer.events.index');
        Route::get('/organizer/registrations', [\App\Http\Controllers\EventController::class, 'allRegistrations'])->name('organizer.registrations.index');
        Route::get('/organizer/attendees', [\App\Http\Controllers\EventController::class, 'attendeesIndex'])->name('organizer.attendees.index');
        Route::get('/organizer/attendees/create', [\App\Http\Controllers\EventController::class, 'attendeeCreate'])->name('organizer.attendees.create');
        Route::post('/organizer/attendees', [\App\Http\Controllers\EventController::class, 'attendeeStore'])->name('organizer.attendees.store');
        Route::get('/organizer/attendees/{attendee}/edit', [\App\Http\Controllers\EventController::class, 'attendeeEdit'])->name('organizer.attendees.edit');
        Route::put('/organizer/attendees/{attendee}', [\App\Http\Controllers\EventController::class, 'attendeeUpdate'])->name('organizer.attendees.update');
        Route::delete('/organizer/attendees/{attendee}', [\App\Http\Controllers\EventController::class, 'attendeeDestroy'])->name('organizer.attendees.destroy');
        Route::get('/organizer/reports', [\App\Http\Controllers\EventController::class, 'reports'])->name('organizer.reports.index');

        Route::resource('events', \App\Http\Controllers\EventController::class);
        Route::patch('/registrations/{registration}/attendance', [\App\Http\Controllers\EventController::class, 'markAttendance'])->name('registrations.attendance');
        Route::get('/events/{event}/export', [\App\Http\Controllers\EventController::class, 'exportAttendees'])->name('events.export');
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', function() { return redirect()->route('admin.dashboard'); });
        Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        Route::get('/admin/organizers', [\App\Http\Controllers\AdminController::class, 'organizers'])->name('admin.organizers.index');
        Route::get('/admin/organizers/create', [\App\Http\Controllers\AdminController::class, 'organizerCreate'])->name('admin.organizers.create');
        Route::post('/admin/organizers', [\App\Http\Controllers\AdminController::class, 'organizerStore'])->name('admin.organizers.store');
        Route::get('/admin/events', [\App\Http\Controllers\AdminController::class, 'events'])->name('admin.events.index');
        Route::get('/admin/events/pending', [\App\Http\Controllers\AdminController::class, 'pendingEvents'])->name('admin.events.pending');
        Route::patch('/admin/events/{id}/approve', [\App\Http\Controllers\AdminController::class, 'approveEvent'])->name('admin.events.approve');
        Route::patch('/admin/events/{id}/reject', [\App\Http\Controllers\AdminController::class, 'rejectEvent'])->name('admin.events.reject');
        
        Route::get('/admin/registrations', [\App\Http\Controllers\AdminController::class, 'attendees'])->name('admin.attendees.index');
        Route::get('/admin/attendees', [\App\Http\Controllers\AdminController::class, 'globalAttendees'])->name('admin.attendees.list');
        Route::get('/admin/attendees/create', [\App\Http\Controllers\AdminController::class, 'attendeeCreate'])->name('admin.attendees.create');
        Route::post('/admin/attendees', [\App\Http\Controllers\AdminController::class, 'attendeeStore'])->name('admin.attendees.store');
        Route::get('/admin/attendees/{attendee}/edit', [\App\Http\Controllers\AdminController::class, 'attendeeEdit'])->name('admin.attendees.edit');
        Route::put('/admin/attendees/{attendee}', [\App\Http\Controllers\AdminController::class, 'attendeeUpdate'])->name('admin.attendees.update');
        Route::delete('/admin/attendees/{attendee}', [\App\Http\Controllers\AdminController::class, 'attendeeDestroy'])->name('admin.attendees.destroy');
        Route::get('/admin/reports', [\App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports.index');
        Route::get('/admin/settings', function() { return view('admin.settings'); })->name('admin.settings.index');
        
        Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/settings/logo', [\App\Http\Controllers\SystemSettingController::class, 'updateLogo'])->name('admin.settings.logo');
        Route::post('/admin/settings/general', [\App\Http\Controllers\SystemSettingController::class, 'updateSettings'])->name('admin.settings.general');
    });
});
