<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\Company\JobOffers\Applications;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;
use Livewire\Livewire;

test('applications screen can be rendered', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->for($user->userable)->create();
    $user->assignRole(Roles::EMPRESA);

    $response = $this->actingAs($user)->get("/company/offers/$jobOffer->id/applications");

    $response->assertOk();
});

it('can update job application', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();
    $jobOffer = JobOffer::factory()->for($user->userable)->create();
    $candidate = User::factory()->for(Candidate::factory(), 'userable')->create();
    $jobApplication = JobApplication::factory()->for($jobOffer)->for($user->userable)->for($candidate->userable)->create();
    $user->assignRole(Roles::EMPRESA);

    $response = Livewire::actingAs($user)
        ->test(Applications::class, ['jobOffer' => $jobOffer])
        ->call('updateApplicationStatus', $jobApplication->id, 'accepted');

    $response->assertOk();
    $this->assertDatabaseHas('job_applications', [
        'id' => $jobApplication->id,
        'status' => 'accepted',
    ]);
});
