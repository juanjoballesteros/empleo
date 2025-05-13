<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\BirthInfo;
use App\Models\City;
use App\Models\Cv;
use App\Models\Department;

test('to array', function () {
    $birthInfo = BirthInfo::factory()->create()->fresh();

    expect(array_keys($birthInfo->toArray()))->toEqual([
        'id',
        'birthdate',
        'check',
        'department_id',
        'city_id',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a department', function () {
    $birthInfo = BirthInfo::factory()->create();

    expect($birthInfo->department)->toBeInstanceOf(Department::class);
});

it('belongs to a city', function () {
    $birthInfo = BirthInfo::factory()->create();

    expect($birthInfo->city)->toBeInstanceOf(City::class);
});

it('belongs to a cv', function () {
    $birthInfo = BirthInfo::factory()->create();

    expect($birthInfo->cv)->toBeInstanceOf(Cv::class);
});
