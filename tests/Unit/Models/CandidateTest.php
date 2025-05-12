<?php

declare(strict_types=1);

use App\Models\Candidate;
use App\Models\City;
use App\Models\Department;
use App\Models\User;

test('to array', function () {
    $candidate = Candidate::factory()->create()->fresh();

    expect(array_keys($candidate->toArray()))->toEqual([
        'id',
        'department_id',
        'city_id',
        'created_at',
        'updated_at',
    ]);
});

it('has a user', function () {
    $candidate = Candidate::factory()->has(User::factory())->create();

    expect($candidate->user)->toBeInstanceOf(User::class);
});

it('belongs to a department', function () {
    $candidate = Candidate::factory()->create();

    expect($candidate->department)->toBeInstanceOf(Department::class);
});

it('belongs to a city', function () {
    $candidate = Candidate::factory()->create();

    expect($candidate->city)->toBeInstanceOf(City::class);
});
