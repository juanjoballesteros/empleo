<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\BasicEducationInfo;
use App\Models\Cv;

test('to array', function () {
    $basicEducationInfo = BasicEducationInfo::factory()->create()->fresh();

    expect(array_keys($basicEducationInfo->toArray()))->toEqual([
        'id',
        'level',
        'program',
        'end_date',
        'check',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a cv', function () {
    $basicEducationInfo = BasicEducationInfo::factory()->create();

    expect($basicEducationInfo->cv)->toBeInstanceOf(Cv::class);
});
