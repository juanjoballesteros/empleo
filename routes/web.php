<?php

declare(strict_types=1);

use App\Http\Controllers\Cv\PdfController;
use App\Livewire\Company;
use App\Livewire\Cv;
use App\Livewire\Dashboard;
use App\Livewire\JobOffers;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('cv/import', Cv\Import::class)->name('cv.import');

Route::middleware(['auth', 'type'])->group(function () {
    Route::middleware('cv')->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');

        Route::get('/offers', JobOffers\Index::class)->name('offers.index');
    });

    Route::middleware('cv_created')->prefix('cv')->group(function () {
        Route::redirect('/', '/cv/personal-info')->name('cv.index');

        Route::middleware('cv')->group(function () {
            Route::get('documents', Cv\Documents::class)->name('cv.documents');
            Route::view('completed', 'completed')->name('cv.completed');
            Route::get('pdf', PdfController::class)->name('cv.pdf');
        });

        Route::get('personal-info', Cv\Steps\PersonalInfo::class)->name('cv.personal-info');
        Route::get('contact-info', Cv\Steps\ContactInfo::class)->name('cv.contact-info');
        Route::get('residence-info', Cv\Steps\ResidenceInfo::class)->name('cv.residence-info');
        Route::get('basic-education-info', Cv\Steps\BasicEducationInfo::class)->name('cv.basic-education-info');
        Route::get('higher-education-info', Cv\Steps\HigherEducation\Index::class)->name('cv.higher-education-info');
        Route::get('work-experience-info', Cv\Steps\WorkExperience\Index::class)->name('cv.work-experience-info');
        Route::get('language-info', Cv\Steps\Language\Index::class)->name('cv.language-info');
    });

    Route::prefix('company')->group(function () {
        Route::get('{cv}/pdf', PdfController::class)->name('company.cv.pdf');

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
