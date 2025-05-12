<?php

declare(strict_types=1);

use App\Livewire\Candidate;
use App\Livewire\Company;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('select', 'select')->name('select');
    Route::get('company/register', Company\Register::class)->name('company.register');
    Route::get('candidate/register', Candidate\Register::class)->name('candidate.register');
});

Route::middleware(['auth', 'type'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
