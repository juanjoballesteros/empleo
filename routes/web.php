<?php

declare(strict_types=1);

use App\Actions\CvPdf;
use App\Livewire\Candidate;
use App\Livewire\Company;
use App\Livewire\Cv;
use App\Livewire\Dashboard;
use App\Livewire\JobOffers;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('select', 'select')->name('select');
    Route::get('company/register', Company\Register::class)->name('company.register');
    Route::get('candidate/register', Candidate\Register::class)->name('candidate.register');
});

Route::middleware(['auth', 'type'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::middleware('role:candidato')->group(function () {
        Route::middleware('cv')->prefix('offers')->group(function () {
            Route::get('/', JobOffers\Index::class)->name('offers.index');
        });

        Route::prefix('cv')->group(function () {
            Route::prefix('{cv}')->group(function () {
                Route::get('pdf', CvPdf::class)->name('cv.pdf');

                Route::get('personal-info', Cv\Steps\PersonalInfo::class)->name('cv.create.personal-info');
                Route::get('birth-info', Cv\Steps\BirthInfo::class)->name('cv.create.birth-info');
                Route::get('contact-info', Cv\Steps\ContactInfo::class)->name('cv.create.contact-info');
                Route::get('residence-info', Cv\Steps\ResidenceInfo::class)->name('cv.create.residence-info');
                Route::get('basic-education-info', Cv\Steps\BasicEducationInfo::class)->name('cv.create.basic-education-info');
                Route::get('higher-education-info', Cv\Steps\HigherEducationInfo::class)->name('cv.create.higher-education-info');
                Route::get('work-experience-info', Cv\Steps\WorkExperienceInfo::class)->name('cv.create.work-experience-info');
                Route::get('language-info', Cv\Steps\LanguageInfo::class)->name('cv.create.language-info');
            });
        });
    });

    Route::middleware('role:empresa')->prefix('company')->group(function () {
        Route::get('{cv}/pdf', CvPdf::class)->name('company.cv.pdf');

        Route::prefix('offers')->group(function () {
            Route::get('/', Company\JobOffers\Index::class)->name('company.offers.index');
            Route::get('create', Company\JobOffers\Create::class)->name('company.offers.create');
            Route::get('{jobOffer}/edit', Company\JobOffers\Edit::class)->name('company.offers.edit');
            Route::get('{jobOffer}/applications', Company\JobOffers\Applications::class)->name('company.offers.applications');
        });
    });

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
