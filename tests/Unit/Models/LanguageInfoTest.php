<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Cv;
use App\Models\LanguageInfo;

test('to array', function () {
    $languageInfo = LanguageInfo::factory()->create()->fresh();

    expect(array_keys($languageInfo->toArray()))->toEqual([
        'id',
        'name',
        'write',
        'speak',
        'read',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a cv', function () {
    $languageInfo = LanguageInfo::factory()->create();

    expect($languageInfo->cv)->toBeInstanceOf(Cv::class);
});
