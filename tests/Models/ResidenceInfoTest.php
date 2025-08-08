<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\ResidenceInfo;

test('to array', function () {
    $residenceInfo = ResidenceInfo::factory()->create()->fresh();

    expect(array_keys($residenceInfo->toArray()))->toEqual([
        'id',
        'department_id',
        'city_id',
        'address',
        'check',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a department', function () {
    $residenceInfo = ResidenceInfo::factory()->create();

    expect($residenceInfo->department)->toBeInstanceOf(Department::class);
});

test('belongs to a city', function () {
    $residenceInfo = ResidenceInfo::factory()->create();

    expect($residenceInfo->city)->toBeInstanceOf(City::class);
});

test('belongs to a cv', function () {
    $residenceInfo = ResidenceInfo::factory()->create();

    expect($residenceInfo->cv)->toBeInstanceOf(Cv::class);
});
