<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\Cv\Steps\ContactInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Livewire\Livewire;

test('contact info screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get("/cv/{$user->cv->id}/contact-info");

    $response->assertStatus(200);
});

it('can be created', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(ContactInfo::class, ['cv' => $user->cv])
        ->set('phone_number', '3124567890')
        ->set('email', 'email@email.com')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect("/cv/{$user->cv->id}/residence-info");

    $this->assertDatabaseCount('contact_infos', 1);
});

it('show validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(ContactInfo::class, ['cv' => $user->cv])
        ->set('phone_number', '')
        ->set('email', '')
        ->call('store');

    $response->assertHasErrors([
        'phone_number',
        'email',
    ])->assertNoRedirect();
});

it('assert can be updated', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(App\Models\ContactInfo::factory()))
        ->create();

    $contactInfo = $user->cv->contactInfo;

    $response = Livewire::test(ContactInfo::class, ['cv' => $user->cv]);

    $response->assertSet('phone_number', $contactInfo->phone_number)
        ->assertSet('email', $contactInfo->email);

    $response->set('phone_number', '3100000000')
        ->set('email', 'correo@correo.com')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect("/cv/{$user->cv->id}/residence-info");

    $this->assertDatabaseCount('contact_infos', 1);
});
