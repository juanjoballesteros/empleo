<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Cv;
use App\Models\HigherEducation;

test('to array', function () {
    $higherEducation = HigherEducation::factory()->create()->fresh();

    expect(array_keys($higherEducation->toArray()))->toEqual([
        'id',
        'program',
        'institution',
        'type',
        'date_start',
        'actual',
        'date_end',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a cv', function () {
    $higherEducation = HigherEducation::factory()->create();

    expect($higherEducation->cv)->toBeInstanceOf(Cv::class);
});
