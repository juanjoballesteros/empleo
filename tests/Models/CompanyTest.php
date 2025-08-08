<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\User;

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

test('has a user', function () {
    $company = Company::factory()->has(User::factory())->create();

    expect($company->user)->toBeInstanceOf(User::class);
});

test('have many job offers', function () {
    $company = Company::factory()->has(JobOffer::factory(3))->create();

    expect($company->jobOffers)->toHaveCount(3)->each->toBeInstanceOf(JobOffer::class);
});

test('belong to a department', function () {
    $company = Company::factory()->create();

    expect($company->department)->toBeInstanceOf(Department::class);
});

test('belong to a city', function () {
    $company = Company::factory()->create();

    expect($company->city)->toBeInstanceOf(City::class);
});

test('has many job applications', function () {
    $company = Company::factory()->has(JobApplication::factory(3))->create();

    expect($company->jobApplications)->toHaveCount(3)->each->toBeInstanceOf(JobApplication::class);
});
