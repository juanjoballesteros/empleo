<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\Cv\Steps\ResidenceInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use Livewire\Livewire;

test('residence info screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get("/cv/{$user->cv->id}/residence-info");

    $response->assertOk();
});

it('can be created', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $department = Department::all()->random()->first();

    $response = Livewire::test(ResidenceInfo::class, ['cv' => $user->cv])
        ->set('department_id', $department->id)
        ->set('city_id', $department->cities->random()->first()->id)
        ->set('address', fake()->address())
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect("/cv/{$user->cv->id}/basic-education-info");

    $this->assertDatabaseCount('residence_infos', 1);
});

it('show validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(ResidenceInfo::class, ['cv' => $user->cv])
        ->set('department_id', '')
        ->set('city_id', '')
        ->set('address', '')
        ->call('store');

    $response->assertHasErrors([
        'department_id',
        'city_id',
        'address',
    ])->assertNoRedirect();
});

it('can be updated', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(App\Models\ResidenceInfo::factory()))
        ->create();
    $residenceInfo = $user->cv->residenceInfo;

    $response = Livewire::test(ResidenceInfo::class, ['cv' => $user->cv]);

    $response->assertSet('department_id', $residenceInfo->department_id)
        ->assertSet('city_id', $residenceInfo->city_id)
        ->assertSet('address', $residenceInfo->address);

    $response->set('department_id', $residenceInfo->department_id)
        ->set('city_id', $residenceInfo->city_id)
        ->set('address', $residenceInfo->address)
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect("/cv/{$user->cv->id}/basic-education-info");

    $this->assertDatabaseCount('residence_infos', 1);
});
