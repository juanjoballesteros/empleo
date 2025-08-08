<?php

declare(strict_types=1);

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login');

    $response->assertHasErrors('email');

    $this->assertGuest();
});

test('users can not authenticate with to many attempts', function () {
    $user = User::factory()->create();

    Event::fake();

    $attempts = 0;
    while ($attempts < 6) {
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('login');

        $attempts += 1;
    }

    $response = Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login');

    Event::assertDispatched(Lockout::class);

    $response->assertHasErrors('email');
    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');

    $this->assertGuest();
});
