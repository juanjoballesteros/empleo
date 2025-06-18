<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;

it('redirect if cv is not completed', function () {
    $user = User::factory()->for(Candidate::factory()->has(Cv::factory()), 'userable')->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get('/offers');

    $response->assertRedirect()
        ->assertSessionHas('error');
});
