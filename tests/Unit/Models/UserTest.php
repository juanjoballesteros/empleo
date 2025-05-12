<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toEqual([
        'id',
        'name',
        'email',
        'email_verified_at',
        'userable_id',
        'userable_type',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to a company', function () {
    $user = User::factory()->for(Company::factory(), 'userable')->create();

    expect($user->userable)->toBeInstanceOf(Company::class);
});

it('belongs to a candidate', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();

    expect($user->userable)->toBeInstanceOf(Candidate::class);
});
