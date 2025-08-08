<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\HigherEducation;

test('to array', function () {
    $higherEducation = HigherEducation::factory()->create()->fresh();

    expect(array_keys($higherEducation->toArray()))->toEqual([
        'id',
        'type',
        'semester',
        'date_semester',
        'licensed',
        'program',
        'department_id',
        'city_id',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a department', function () {
    $higherEducation = HigherEducation::factory()->create();

    expect($higherEducation->department)->toBeInstanceOf(Department::class);
});

test('belongs to a city', function () {
    $higherEducation = HigherEducation::factory()->create();

    expect($higherEducation->city)->toBeInstanceOf(City::class);
});

test('belongs to a cv', function () {
    $higherEducation = HigherEducation::factory()->create();

    expect($higherEducation->cv)->toBeInstanceOf(Cv::class);
});
