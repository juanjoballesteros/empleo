<?php

declare(strict_types=1);

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

    $response = $this->actingAs($user)->get('/cv/contact-info');

    $response->assertStatus(200);
});

it('can be created', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::actingAs($user)->test(ContactInfo::class)
        ->set('phone_number', '3124567890')
        ->set('email', 'email@email.com')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect('/cv/residence-info');

    $this->assertDatabaseCount('contact_infos', 1);
});

it('show validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::actingAs($user)->test(ContactInfo::class)
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

    $response = Livewire::actingAs($user)->test(ContactInfo::class);

    $response->assertSet('phone_number', $contactInfo->phone_number)
        ->assertSet('email', $contactInfo->email);

    $response->set('phone_number', '3100000000')
        ->set('email', 'correo@correo.com')
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect('/cv/residence-info');

    $this->assertDatabaseCount('contact_infos', 1);
});
