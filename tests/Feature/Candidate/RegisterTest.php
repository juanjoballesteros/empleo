<?php

declare(strict_types=1);

use App\Livewire\Candidate\Register;
use App\Models\Candidate;
use App\Models\City;
use App\Models\User;
use Livewire\Livewire;

test('register screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/candidate/register');

    $response->assertStatus(200);
});

test('user can register as candidate', function () {
    $user = User::factory()->create();

    $city = City::query()->inRandomOrder()->first();

    $response = Livewire::actingAs($user)
        ->test(Register::class)
        ->set('department_id', $city->department_id)
        ->set('city_id', $city->id)
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirectToRoute('dashboard');

    expect($user->fresh()->userable)->toBeInstanceOf(Candidate::class);
});
