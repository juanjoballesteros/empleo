<?php

declare(strict_types=1);

use App\Livewire\Company\JobOffers\Create;
use App\Models\Company;
use App\Models\User;
use Livewire\Livewire;

test('create screen can be rendered', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    $response = $this->actingAs($user)->get('/company/offers/create');

    $response->assertStatus(200);
});

test('user can create a job offer', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    $response = Livewire::actingAs($user)
        ->test(Create::class)
        ->set('title', 'Empleador Ejemplo')
        ->set('description', 'Descripción de ejemplo')
        ->set('requirements', 'Requisitos de ejemplo')
        ->set('salary', 100000)
        ->set('type', 'Tiempo Completo')
        ->set('location', 'Remoto')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirectToRoute('company.offers.index');

    $this->assertDatabaseCount('job_offers', 1);
});
