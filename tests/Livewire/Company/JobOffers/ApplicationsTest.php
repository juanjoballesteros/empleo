<?php

declare(strict_types=1);

use App\Livewire\Company\JobOffers\Applications;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Cv;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Livewire\Livewire;

test('applications screen can be rendered', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->for($user->userable)->create();

    $response = $this->actingAs($user)->get("/company/offers/$jobOffer->id/applications");

    $response->assertOk();
});

it('can update job application', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->for($user->userable)->create();
    $candidate = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobApplication = JobApplication::factory()->for($jobOffer)->for($user->userable)->for($candidate->userable)->create();
    Cv::factory()->for($candidate->userable)->create();

    $response = Livewire::actingAs($user)
        ->test(Applications::class, ['jobOffer' => $jobOffer])
        ->call('updateApplicationStatus', $jobApplication->id, 'accepted');

    $response->assertOk();
    $this->assertDatabaseHas('job_applications', [
        'id' => $jobApplication->id,
        'status' => 'accepted',
    ]);
});

it('can set notes when reject job application', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->for($user->userable)->create();
    $candidate = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobApplication = JobApplication::factory()->for($jobOffer)->for($user->userable)->for($candidate->userable)->create();
    Cv::factory()->for($candidate->userable)->create();

    $response = Livewire::actingAs($user)
        ->test(Applications::class, ['jobOffer' => $jobOffer])
        ->set('notes', 'El candidato no aplica porque no cumple los requisitos de experiencia laboral')
        ->call('updateApplicationStatus', $jobApplication->id, 'rejected');

    $response->assertOk();
    $this->assertDatabaseHas('job_applications', [
        'id' => $jobApplication->id,
        'status' => 'rejected',
        'notes' => 'El candidato no aplica porque no cumple los requisitos de experiencia laboral',
    ]);
});
