<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chat>
 */
final class ChatFactory extends Factory
{
    protected $model = Chat::class;

    public function definition(): array
    {
        return [
            'state' => fake()->randomElement(['welcome', 'basic', 'high', 'work', 'lang', 'contact']),
            'phone' => fake()->unique()->numerify('310#######'),
            'user_id' => User::factory(),
        ];
    }
}
