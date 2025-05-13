<?php

declare(strict_types=1);

use App\Livewire\JobOffers\Index;
use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\User;
use Livewire\Livewire;

test('index page can be rendered', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();

    $response = $this->actingAs($user)->get('/offers');

    $response->assertStatus(200);
});

it('can show job offers', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    JobOffer::factory(10)->create();
    JobOffer::factory()->create([
        'title' => 'Oferta de prueba con palabra',
    ]);

    $response = Livewire::actingAs($user)
        ->test(Index::class);

    $response->assertSee(['Oferta de prueba con palabra'])
        ->assertViewHas('jobOffers', function ($offers) {
            return $offers->count() === 11;
        });
});

it('can search job offers', function () {
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
