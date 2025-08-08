<?php

declare(strict_types=1);

use App\Livewire\Company\JobOffers\Edit;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()
        ->for(Company::factory(), 'userable')
        ->create();
    $this->jobOffer = JobOffer::factory()->for($this->user->userable)->create();
});

test('edit screen can be rendered', function () {
    $response = $this->actingAs($this->user)->get("/company/offers/{$this->jobOffer->id}/edit");

    $response->assertOk();
});

test('fill the data from the job offer', function () {
    $response = Livewire::actingAs($this->user)
        ->test(Edit::class, ['jobOffer' => $this->jobOffer]);

    $response->assertSet('title', $this->jobOffer->title)
        ->assertSet('description', $this->jobOffer->description)
        ->assertSet('requirements', $this->jobOffer->requirements)
        ->assertSet('salary', $this->jobOffer->salary)
        ->assertSet('type', $this->jobOffer->type)
        ->assertSet('location', $this->jobOffer->location);
});

test('edit the job offer', function () {
    $response = Livewire::actingAs($this->user)
        ->test(Edit::class, ['jobOffer' => $this->jobOffer])
        ->set('title', 'Titulo')
        ->set('description', 'Description')
        ->call('update');

    $response->assertHasNoErrors()
        ->assertRedirect('/company/offers');

    $this->assertDatabaseHas('job_offers', [
        'title' => 'Titulo',
        'description' => 'Description',
    ]);
});
