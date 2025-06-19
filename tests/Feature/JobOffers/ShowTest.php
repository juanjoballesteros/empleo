<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\JobOffers\Show;
use App\Models\BasicEducationInfo;
use App\Models\BirthInfo;
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

test('show screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory()
            ->has(Cv::factory()
                ->has(PersonalInfo::factory())
                ->has(BirthInfo::factory())
                ->has(ContactInfo::factory())
                ->has(ResidenceInfo::factory())
                ->has(BasicEducationInfo::factory())
                ->has(HigherEducation::factory(2))
                ->has(WorkExperience::factory(2))
                ->has(LanguageInfo::factory(2))
            ), 'userable')
        ->create();
    $user->assignRole(Roles::CANDIDATO);
    JobOffer::factory(10)->create();

    $response = $this->actingAs($user)->get('offers');

    $response->assertOk()
        ->assertSeeLivewire(Show::class);
});

it('change the job offer', function () {
    $jobOffer = JobOffer::factory()->create([
        'title' => 'Oferta de trabajo',
    ]);

    $response = Livewire::test(Show::class)
        ->dispatch('job-offer.change', $jobOffer->id);

    $response->assertSee('Oferta de trabajo');
});
