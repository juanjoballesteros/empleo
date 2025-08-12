<?php

declare(strict_types=1);

use App\Livewire\Auth\Company;
use App\Models\City;
use Livewire\Livewire;

test('register screen can be rendered', function () {
    $response = $this->get('/register/company');

    $response->assertStatus(200);
});

test('user can register as company', function () {
    $city = City::query()->inRandomOrder()->first();

    $response = Livewire::test(Company::class)
        ->set('name', 'Empresa Ejemplo')
        ->set('nit', 123456789)
        ->set('department_id', $city->department_id)
        ->set('city_id', $city->id)
        ->set('email', 'correo@correo.com')
        ->set('password', '12345678')
        ->set('password_confirmation', '12345678')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirectToRoute('dashboard');
});
