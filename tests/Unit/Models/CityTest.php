<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Company;
use App\Models\Department;

test('to array', function () {
    $city = City::query()->inRandomOrder()->first();

    expect(array_keys($city->toArray()))->toEqual([
        'id',
        'name',
        'department_id',
    ]);
});

it('belongs to department', function () {
    $city = City::query()->inRandomOrder()->first();

    expect($city->department)->toBeInstanceOf(Department::class);
});

it('has many companies', function () {
    $city = City::query()->inRandomOrder()->first();
    Company::factory()->count(3)->for($city)->create();

    expect($city->companies)->toHaveCount(3)->each->toBeInstanceOf(Company::class);
});
