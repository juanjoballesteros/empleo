<?php

declare(strict_types=1);

use App\Livewire\Dashboard;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs(User::factory()->for(Company::factory(), 'userable')->create());

    $this->get('/dashboard')->assertStatus(200);
});

test('can redirect to offers', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();

    $response = Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->set('search', 'test')
        ->call('send');

    $response->assertRedirect('/offers?search=test');
});
