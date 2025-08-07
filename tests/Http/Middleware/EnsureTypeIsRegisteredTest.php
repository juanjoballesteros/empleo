<?php

declare(strict_types=1);

use App\Models\User;

test('can not access to the dashboard if the userable is not registered', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/dashboard')->assertRedirect('/select');
});
