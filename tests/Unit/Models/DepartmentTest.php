<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Company;
use App\Models\Department;

test('to array', function () {
    $department = Department::query()->inRandomOrder()->first();

    expect(array_keys($department->toArray()))->toEqual([
        'id',
        'name',
    ]);
});

it('has many cities', function () {
    $department = Department::query()->inRandomOrder()->first();

    $count = $department->cities()->count();

    expect($department->cities)->toHaveCount($count)->each->toBeInstanceOf(City::class);
});

it('has many companies', function () {
    $department = Department::query()->inRandomOrder()->first();
    Company::factory()->count(3)->for($department)->create();

    expect($department->companies)->toHaveCount(3)->each->toBeInstanceOf(Company::class);
});
