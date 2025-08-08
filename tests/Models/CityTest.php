<?php

declare(strict_types=1);

use App\Models\Candidate;
use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobOffer;

test('to array', function () {
    $city = City::query()->inRandomOrder()->first();

    expect(array_keys($city->toArray()))->toEqual([
        'id',
        'name',
        'department_id',
    ]);
});

test('belongs to department', function () {
    $city = City::query()->inRandomOrder()->first();

    expect($city->department)->toBeInstanceOf(Department::class);
});

test('has many companies', function () {
    $city = City::query()->inRandomOrder()->first();
    Company::factory()->count(3)->for($city)->create();

    expect($city->companies)->toHaveCount(3)->each->toBeInstanceOf(Company::class);
});

test('has many candidates', function () {
    $city = City::query()->inRandomOrder()->first();
    Candidate::factory()->count(3)->for($city)->create();

    expect($city->candidates)->toHaveCount(3)->each->toBeInstanceOf(Candidate::class);
});

test('has many job offers', function () {
    $city = City::query()->inRandomOrder()->first();
    JobOffer::factory()->count(3)->for($city)->create();

    expect($city->jobOffers)->toHaveCount(3)->each->toBeInstanceOf(JobOffer::class);
});
