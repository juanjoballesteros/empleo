<?php

declare(strict_types=1);

use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;

test('redirect if cv is not completed', function () {
    $user = User::factory()->for(Candidate::factory()->has(Cv::factory()), 'userable')->create();

    $response = $this->actingAs($user)->get('/offers');

    $response->assertRedirect()
        ->assertSessionHas('error');
});
