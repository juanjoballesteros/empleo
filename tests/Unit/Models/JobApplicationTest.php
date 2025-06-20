<?php

declare(strict_types=1);

use App\Models\Candidate;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobOffer;

test('to array', function () {
    $jobApplication = JobApplication::factory()->create()->fresh();

    expect(array_keys($jobApplication->toArray()))->toEqual([
        'id',
        'job_offer_id',
        'candidate_id',
        'company_id',
        'status',
        'notes',
        'created_at',
        'updated_at',
    ]);
});

it('belong to a job offer', function () {
    $jobApplication = JobApplication::factory()->create();

    expect($jobApplication->jobOffer)->toBeInstanceOf(JobOffer::class);
});

it('belongs to a candidate', function () {
    $jobApplication = JobApplication::factory()->create();

    expect($jobApplication->candidate)->toBeInstanceOf(Candidate::class);
});

it('belongs to a company', function () {
    $jobApplication = JobApplication::factory()->create();

    expect($jobApplication->company)->toBeInstanceOf(Company::class);
});
