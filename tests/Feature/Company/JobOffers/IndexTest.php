<?php

declare(strict_types=1);

use App\Livewire\Company\JobOffers\Index;
use App\Models\Company;
use App\Models\JobOffer;
use App\Models\User;
use Livewire\Livewire;

test('index screen can be rendered', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    $response = $this->actingAs($user)->get('/offers');

    $response->assertStatus(200);
});

test('index displays the offers', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    $jobOffers = JobOffer::factory(3)->for($user->userable)->create();

    $response = Livewire::actingAs($user)
        ->test(Index::class);

    $response->assertSee($jobOffers[0]->title)
        ->assertViewHas('jobOffers', function ($offers) {
            return $offers->count() === 3;
        });
});

test('index not display the offers of other companies', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    $jobOffers = JobOffer::factory(3)->create();

    $response = Livewire::actingAs($user)
        ->test(Index::class);

    $response->assertDontSee($jobOffers[0]->title)
        ->assertViewHas('jobOffers', function ($offers) {
            return $offers->count() === 0;
        });
});

test('user can search', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    JobOffer::factory()->for($user->userable)->create([
        'title' => 'Oferta que contiene la palabra prueba',
    ]);

    JobOffer::factory()->for($user->userable)->create([
        'title' => 'Oferta con otra palabra',
    ]);

    $response = Livewire::actingAs($user)
        ->withQueryParams(['search' => 'prue'])
        ->test(Index::class);

    $response->assertSee('Oferta que contiene la palabra prueba')
        ->assertDontSee('Oferta con otra palabra')
        ->assertViewHas('jobOffers', function ($offers) {
            return $offers->count() === 1;
        });
});

test('user can delete offers', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    $jobOffers = JobOffer::factory(3)->for($user->userable)->create();

    $response = Livewire::actingAs($user)
        ->test(Index::class);

    $response->assertSee($jobOffers[0]->title);

    $response->call('delete', $jobOffers[0]->id)
        ->assertDontSee($jobOffers[0]->title);
});
