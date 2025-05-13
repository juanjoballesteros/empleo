<?php

declare(strict_types=1);

use App\Models\Cv;
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
        'description',
        'check',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a cv', function () {
    $personalInfo = PersonalInfo::factory()->create();

    expect($personalInfo->cv)->toBeInstanceOf(Cv::class);
});
