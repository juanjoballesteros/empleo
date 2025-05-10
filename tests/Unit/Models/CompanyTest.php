<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Company;
use App\Models\Department;

test('to array', function () {
    $company = Company::factory()->create()->fresh();

    expect(array_keys($company->toArray()))->toEqual([
        'id',
        'name',
        'nit',
        'department_id',
        'city_id',
        'created_at',
        'updated_at',
    ]);
});

it('belong to a department', function () {
    $company = Company::factory()->create();

    expect($company->department)->toBeInstanceOf(Department::class);
});

it('belong to a city', function () {
    $company = Company::factory()->create();

    expect($company->city)->toBeInstanceOf(City::class);
});
