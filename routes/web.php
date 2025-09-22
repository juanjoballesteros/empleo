<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\SSOController;
use App\Http\Controllers\Cv\PdfController;
use App\Http\Controllers\WhatsAppController;
use App\Livewire\Actions\Logout;
use App\Livewire\Auth\Candidate;
use App\Livewire\Auth\Company as CompanyAuth;
use App\Livewire\Company;
use App\Livewire\Cv;
use App\Livewire\Dashboard;
use App\Livewire\JobOffers;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('cv/import', Cv\Import::class)->name('cv.import');

Route::get('whatsapp', [WhatsAppController::class, 'token'])->name('whatsapp.token');
Route::post('whatsapp', [WhatsAppController::class, 'webhook'])->name('whatsapp.webhook');

Route::middleware('guest')->group(function () {
    Route::get('auth/redirect/{type?}', [SSOController::class, 'redirect'])->name('sso.redirect');
    Route::get('auth/callback', [SSOController::class, 'callback'])->name('sso.callback');

    Route::redirect('login', 'auth/redirect')->name('login');
    Route::redirect('register', 'auth/redirect/register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::view('select', 'select')->name('select');
    Route::get('register/company', CompanyAuth::class)->name('register.company');
    Route::get('register/candidate', Candidate::class)->name('register.candidate');
});

Route::post('logout', Logout::class)
    ->name('logout');

Route::get('cv/pdf/{cv?}', PdfController::class)->name('cv.pdf');

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
});
