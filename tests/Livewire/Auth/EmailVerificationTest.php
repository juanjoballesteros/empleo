<?php

declare(strict_types=1);

use App\Livewire\Settings\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('email is already verified', function () {
    $user = User::factory()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email can be verified in profile', function () {
    $user = User::factory()->unverified()->create();

    Notification::fake();

    $response = Livewire::actingAs($user)
        ->test(Profile::class)
        ->call('resendVerificationNotification');

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('email can not verified in profile if is already verified', function () {
    $user = User::factory()->create();

    $response = Livewire::actingAs($user)
        ->test(Profile::class)
        ->call('resendVerificationNotification');

    $response->assertRedirect('dashboard');
});

test('verify email screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});

test('email verification notification can be sent from verify email', function () {
    $user = User::factory()->unverified()->create();

    Notification::fake();

    $response = Livewire::actingAs($user)
        ->test(App\Livewire\Auth\VerifyEmail::class)
        ->call('sendVerification');

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('email verification notification can not be sent from verify email if user is already verified', function () {
    $user = User::factory()->create();

    $response = Livewire::actingAs($user)
        ->test(App\Livewire\Auth\VerifyEmail::class)
        ->call('sendVerification');

    $response->assertRedirect('dashboard');
});

test('users can logout from verify email', function () {
    $user = User::factory()->create();

    $response = Livewire::actingAs($user)
        ->test(App\Livewire\Auth\VerifyEmail::class)
        ->call('logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});
