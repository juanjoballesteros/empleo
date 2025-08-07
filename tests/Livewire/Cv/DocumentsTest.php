<?php

declare(strict_types=1);

use App\Livewire\Cv\Documents;
use App\Models\BasicEducationInfo;
use App\Models\Candidate;
use App\Models\ContactInfo;
use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\LanguageInfo;
use App\Models\PersonalInfo;
use App\Models\ResidenceInfo;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()
        ->for(Candidate::factory()
            ->has(Cv::factory(['user_id' => 1])
                ->has(PersonalInfo::factory())
                ->has(ContactInfo::factory())
                ->has(ResidenceInfo::factory())
                ->has(BasicEducationInfo::factory())
                ->has(HigherEducation::factory(2))
                ->has(WorkExperience::factory(2))
                ->has(LanguageInfo::factory(2))
            ), 'userable')
        ->create();

});

test('screen is rendered', function () {
    $response = $this->actingAs($this->user)->get('/cv/documents');

    $response->assertOk();
});

test('set the data', function () {
    Storage::fake('public');

    $cv = $this->user->userable->cv;

    $cv->personalInfo->addMedia(UploadedFile::fake()->image('front.jpg'))
        ->toMediaCollection('front');

    $cv->personalInfo->addMedia(UploadedFile::fake()->image('back.jpg'))
        ->toMediaCollection('back');

    $cv->personalInfo->addMedia(UploadedFile::fake()->image('profile.jpg'))
        ->toMediaCollection('profile');

    $response = Livewire::actingAs($this->user)
        ->test(Documents::class);

    $response->assertSet('card', [
        'front' => '/storage/1/front.jpg',
        'back' => '/storage/2/back.jpg',
        'profile' => '/storage/3/profile.jpg',
    ]);
});

test('do noting if the cv is completed', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->create();

    $response = Livewire::actingAs($user)
        ->test(Documents::class);

    $response->assertSet('card', [])
        ->assertSet('education', [])
        ->assertSet('work', [])
        ->assertSet('lenguajes', []);
});
