<?php

declare(strict_types=1);

use App\Models\Candidate;
use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobOffer;

test('to array', function () {
    $department = Department::query()->inRandomOrder()->first();

    expect(array_keys($department->toArray()))->toEqual([
        'id',
        'name',
    ]);
});

test('has many cities', function () {
    $department = Department::query()->inRandomOrder()->first();

    $count = $department->cities()->count();

    expect($department->cities)->toHaveCount($count)->each->toBeInstanceOf(City::class);
});

test('has many companies', function () {
    $department = Department::query()->inRandomOrder()->first();
    Company::factory()->count(3)->for($department)->create();

    expect($department->companies)->toHaveCount(3)->each->toBeInstanceOf(Company::class);
});

test('has many candidates', function () {
    $department = Department::query()->inRandomOrder()->first();
    Candidate::factory()->count(3)->for($department)->create();

    expect($department->candidates)->toHaveCount(3)->each->toBeInstanceOf(Candidate::class);
});

test('has many job offers', function () {
    $department = Department::query()->inRandomOrder()->first();
    JobOffer::factory()->count(3)->for($department)->create();

    expect($department->jobOffers)->toHaveCount(3)->each->toBeInstanceOf(JobOffer::class);
});
