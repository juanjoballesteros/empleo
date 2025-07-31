<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Models\Candidate;
use App\Models\User;

test('cv is created', function () {
    $user = User::factory()->for(Candidate::factory(), 'userable')->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get('cv/personal-info');

    $response->assertOk();
    $this->assertDatabaseHas('cvs', [
        'user_id' => $user->id,
        'candidate_id' => $user->userable->id,
    ]);
});
