<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\Cv\Steps\BirthInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use Livewire\Livewire;

test('birth info screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get("/cv/{$user->cv->id}/birth-info");

    $response->assertStatus(200);
});

it('can be created', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $department = Department::all()->random()->first();

    $response = Livewire::test(BirthInfo::class, ['cv' => $user->cv])
        ->set('birthdate', '1990-01-01')
        ->set('department_id', $department->id)
        ->set('city_id', $department->cities->random()->first()->id)
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect("/cv/{$user->cv->id}/contact-info");

    $this->assertDatabaseCount('birth_infos', 1);
});

it('shows validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(BirthInfo::class, ['cv' => $user->cv])
        ->set('birthdate', '')
        ->call('store');

    $response->assertHasErrors([
        'birthdate',
        'department_id',
        'city_id',
    ]);
});

it('can be updated', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(App\Models\BirthInfo::factory()))
        ->create();
    $birthInfo = $user->cv->birthInfo;

    $response = Livewire::test(BirthInfo::class, ['cv' => $user->cv]);

    $response->assertSet('birthdate', $birthInfo->birthdate->format('Y-m-d'))
        ->assertSet('department_id', $birthInfo->department_id)
        ->assertSet('city_id', $birthInfo->city_id);

    $response->set('birthdate', '1990-01-01')
        ->set('department_id', $birthInfo->department_id)
        ->set('city_id', $birthInfo->city_id)
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect("/cv/{$user->cv->id}/contact-info");

    $this->assertDatabaseCount('birth_infos', 1);
});
