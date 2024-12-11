<?php

use App\Livewire\Events\Index as Events;
use App\Livewire\Events\Attendees;
use App\Livewire\Roles;
use App\Livewire\Users;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/events');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('profile', 'profile')
        ->name('profile');

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', Events::class)->name('index')->can('viewAny', Event::class);
        Route::get('/{event}/attendees', Attendees::class)->name('attendees')->can('view', Attendee::class);
    });

    Route::get('/users', Users::class)->name('users')->can('viewAny', User::class);
    Route::get('/roles', Roles::class)->name('roles')->can('viewAny', Role::class);
});

require __DIR__ . '/auth.php';
