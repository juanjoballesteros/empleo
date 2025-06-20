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
use App\Models\JobApplication;
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
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->create([
        'title' => 'Oferta de trabajo',
    ]);

    $response = Livewire::actingAs($user)
        ->test(Show::class)
        ->dispatch('job-offer.change', $jobOffer->id);

    $response->assertSee('Oferta de trabajo');
});

it('can apply to a job application', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->create();

    $response = Livewire::actingAs($user)
        ->test(Show::class)
        ->dispatch('job-offer.change', $jobOffer->id)
        ->call('applyForJob');

    $response->assertOk()
        ->assertSet('hasApplied', true)
        ->assertSee('Ya te has postulado');
    $this->assertDatabaseHas('job_applications', [
        'job_offer_id' => $jobOffer->id,
        'candidate_id' => $user->userable->id,
    ]);
});

it('cant apply if is already applied', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->create();
    $jobApplication = JobApplication::factory()->for($user->userable)->for($jobOffer)->create();

    $response = Livewire::actingAs($user)
        ->test(Show::class)
        ->dispatch('job-offer.change', $jobOffer->id)
        ->call('applyForJob');

    $response->assertSet('hasApplied', true)
        ->assertSee('Ya te has postulado');
    $this->assertDatabaseCount('job_applications', 1);
});
