<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\WorkExperience;

test('to array', function () {
    $workExperience = WorkExperience::factory()->create()->fresh();

    expect(array_keys($workExperience->toArray()))->toEqual([
        'id',
        'name',
        'date_start',
        'actual',
        'date_end',
        'post',
        'email',
        'phone',
        'address',
        'department_id',
        'city_id',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a department', function () {
    $workExperience = WorkExperience::factory()->create();

    expect($workExperience->department)->toBeInstanceOf(Department::class);
});

test('belongs to a city', function () {
    $workExperience = WorkExperience::factory()->create();

    expect($workExperience->city)->toBeInstanceOf(City::class);
});

test('belongs to a cv', function () {
    $workExperience = WorkExperience::factory()->create();

    expect($workExperience->cv)->toBeInstanceOf(Cv::class);
});
