<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobOffer;

test('to array', function () {
    $jobOffer = JobOffer::factory()->create()->fresh();

    expect(array_keys($jobOffer->toArray()))->toEqual([
        'id',
        'title',
        'description',
        'requirements',
        'salary',
        'type',
        'location',
        'department_id',
        'city_id',
        'company_id',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a company', function () {
    $jobOffer = JobOffer::factory()->create();

    expect($jobOffer->company)->toBeInstanceOf(Company::class);
});

it('belongs to a department', function () {
    $jobOffer = JobOffer::factory()->presencial()->create();

    expect($jobOffer->department)->toBeInstanceOf(Department::class);
});

it('belongs to a city', function () {
    $jobOffer = JobOffer::factory()->presencial()->create();

    expect($jobOffer->city)->toBeInstanceOf(City::class);
});
