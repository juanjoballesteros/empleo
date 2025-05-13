<?php

declare(strict_types=1);

namespace Tests\Models;

use App\Models\ContactInfo;
use App\Models\Cv;

test('to array', function () {
    $contactInfo = ContactInfo::factory()->create()->fresh();

    expect(array_keys($contactInfo->toArray()))->toEqual([
        'id',
        'phone_number',
        'email',
        'check',
        'cv_id',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a cv', function () {
    $contactInfo = ContactInfo::factory()->create();

    expect($contactInfo->cv)->toBeInstanceOf(Cv::class);
});
