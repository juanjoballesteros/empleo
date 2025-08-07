<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cv>
 */
final class CvFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'candidate_id' => Candidate::factory(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'basic' => true,
            'high' => true,
            'work' => true,
            'lang' => true,
        ]);
    }
}
