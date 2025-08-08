<?php

declare(strict_types=1);

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\PersonalInfo;

test('to array', function () {
    $personalInfo = PersonalInfo::factory()->create()->fresh();

    expect(array_keys($personalInfo->toArray()))->toEqual([
        'id',
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'sex',
        'document_type',
        'document_number',
        'birthdate',
        'description',
        'check',
        'department_id',
        'city_id',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a cv', function () {
    $personalInfo = PersonalInfo::factory()->create();

    expect($personalInfo->cv)->toBeInstanceOf(Cv::class);
});

test('belongs to a department', function () {
    $personalInfo = PersonalInfo::factory()->create();

    expect($personalInfo->department)->toBeInstanceOf(Department::class);
});

test('belongs to a city', function () {
    $personalInfo = PersonalInfo::factory()->create();

    expect($personalInfo->city)->toBeInstanceOf(City::class);
});
