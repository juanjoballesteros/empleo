<?php

declare(strict_types=1);

use App\Livewire\JobOffers\Index;
use App\Models\BasicEducationInfo;
use App\Models\Candidate;
use App\Models\ContactInfo;
use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\JobOffer;
use App\Models\LanguageInfo;
use App\Models\PersonalInfo;
use App\Models\ResidenceInfo;
use App\Models\User;
use App\Models\WorkExperience;
use Livewire\Livewire;

test('index page can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory()
            ->has(Cv::factory()
                ->completed()
                ->has(PersonalInfo::factory())
                ->has(ContactInfo::factory())
                ->has(ResidenceInfo::factory())
                ->has(BasicEducationInfo::factory())
                ->has(HigherEducation::factory(2))
                ->has(WorkExperience::factory(2))
                ->has(LanguageInfo::factory(2))
            ), 'userable')
        ->create();

    $response = $this->actingAs($user)->get('/offers');

    $response->assertStatus(200);
});

test('can show job offers', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    JobOffer::factory(10)->create();
    JobOffer::factory()->create([
        'title' => 'Oferta de prueba con palabra',
    ]);

    $response = Livewire::actingAs($user)
        ->withUrlParams(['search' => 'oferta'])
        ->test(Index::class);

    $response->assertSee(['Oferta de prueba con palabra'])
        ->assertViewHas('jobOffers', function ($offers) {
            return $offers->count() === 1;
        });
});

test('show 1 job offer', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->create();

    $response = Livewire::actingAs($user)
        ->test(Index::class)
        ->call('openJobOffer', $jobOffer->id);

    $response->assertSet('open', true)
        ->assertDispatched('job-offer.change');
});

test('can search job offers', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    JobOffer::factory(10)->create();
    JobOffer::factory()->create([
        'title' => 'Oferta de prueba con palabra',
    ]);

    $response = Livewire::actingAs($user)
        ->withQueryParams(['search' => 'prueba'])
        ->test(Index::class);

    $response->assertSee(['Oferta de prueba con palabra'])
        ->assertViewHas('jobOffers', function ($offers) {
            return $offers->count() === 1;
        });
});
