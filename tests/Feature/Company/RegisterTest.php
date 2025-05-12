<?php

declare(strict_types=1);

use App\Livewire\Company\Register;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Livewire\Livewire;

test('register screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/company/register');

    $response->assertStatus(200);
});

test('user can register as company', function () {
    $user = User::factory()->create();

    $city = City::query()->inRandomOrder()->first();

    $response = Livewire::actingAs($user)
        ->test(Register::class)
        ->set('name', 'Emplesa Ejemplo')
        ->set('nit', 123456789)
        ->set('department_id', $city->department_id)
        ->set('city_id', $city->id)
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirectToRoute('dashboard');

    expect($user->fresh()->userable)->toBeInstanceOf(Company::class);
});
