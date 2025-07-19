<?php

declare(strict_types=1);

use App\Livewire\Candidate\Register;
use App\Models\City;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Prism\Prism\Prism;
use Prism\Prism\Testing\StructuredResponseFake;

test('register screen can be rendered', function () {
    $response = $this->get('/candidate/register');

    $response->assertOk();
});

test('user can register as candidate', function () {
    Storage::fake('public');

    $city = City::query()->inRandomOrder()->first();

    $response = Livewire::test(Register::class)
        ->set('file', UploadedFile::fake()->image('card.jpg'))
        ->set('name', 'Candidato Ejemplo')
        ->set('identification', '123456789')
        ->set('email', 'ejem@ejem.com')
        ->set('department_id', $city->department_id)
        ->set('city_id', $city->id)
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirectToRoute('dashboard');

    Storage::assertExists('1/card.jpg');
});

it('analyze image and generate a structured response', function () {
    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
            'names' => 'Pedro',
            'last_names' => 'Sanchez Cadena',
            'identification' => '123456789',
        ]);

    Prism::fake([$fakeResponse]);

    $response = Livewire::test(Register::class)
        ->set('file', UploadedFile::fake()->image('card.jpg'))
        ->call('analyzeImage');

    $response->assertHasNoErrors()
        ->assertSet('name', 'Pedro Sanchez Cadena')
        ->assertSet('identification', '123456789')
        ->assertSet('show', true);
});

it('show error message if card is not recognized', function () {
    $fakeResponse = StructuredResponseFake::make()
        ->withStructured([
            'names' => null,
            'last_names' => null,
            'identification' => null,
        ]);

    Prism::fake([$fakeResponse]);

    $response = Livewire::test(Register::class)
        ->set('file', UploadedFile::fake()->image('card.jpg'))
        ->call('analyzeImage');

    $response->assertSet('show', false)
        ->assertSet('name', '')
        ->assertSet('identification', '');
});
