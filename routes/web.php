<?php

use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\AuthController;

Route::get('/', [PublicEventController::class, 'index'])->name('home');
Route::get('/events/public/{id}', [PublicEventController::class, 'show'])->name('events.public.show');
Route::post('/events/public/{id}/register', [PublicEventController::class, 'register'])->name('events.public.register');
Route::get('/tickets/{ticket_id}', [PublicEventController::class, 'ticket'])->name('events.public.ticket');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'updateInfo'])->name('profile.info');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Organizer Routes
    Route::middleware('role:organizer')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\EventController::class, 'index'])->name('dashboard');

        Route::resource('events', \App\Http\Controllers\EventController::class);
        Route::patch('/registrations/{registration}/attendance', [\App\Http\Controllers\EventController::class, 'markAttendance'])->name('registrations.attendance');
        Route::get('/events/{event}/export', [\App\Http\Controllers\EventController::class, 'exportAttendees'])->name('events.export');
    });

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
        Route::post('/admin/settings/logo', [\App\Http\Controllers\SystemSettingController::class, 'updateLogo'])->name('admin.settings.logo');
    });
});
