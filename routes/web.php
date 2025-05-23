<?php

use App\Models\LiveViewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('history', 'history')
    ->name('history');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Volt::route('match/new', 'match.new')->name('match.new');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::post('/live-ping', function (Request $request) {
    LiveViewer::updateOrCreate(
        ['session_id' => $request->session_id],
        ['last_ping' => now()]
    );
    return response()->noContent();
});

require __DIR__.'/auth.php';
