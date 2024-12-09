<?php

use App\Livewire\Events\Index as Events;
use App\Livewire\Events\Attendees;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', Events::class)->name('index');
        Route::get('/{event}/attendees', Attendees::class)->name('attendees');
    });
});

Route::get('events', Events::class)
    ->middleware(['auth'])
    ->name('events');

require __DIR__ . '/auth.php';
