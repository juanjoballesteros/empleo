<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cv;
use App\Models\HigherEducation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HigherEducation>
 */
final class HigherEducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program' => fake()->word(),
            'institution' => fake()->word(),
            'type' => fake()->randomElement(['TC', 'TL', 'TE', 'UN', 'ES', 'MG', 'DOC']),
            'date_start' => fake()->date(),
            'actual' => fake()->boolean(),
            'date_end' => fake()->date(),
            'cv_id' => Cv::factory(),
        ];
    }
}
