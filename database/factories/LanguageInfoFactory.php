<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cv;
use App\Models\LanguageInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LanguageInfo>
 */
final class LanguageInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'write' => fake()->randomElement(['R', 'B', 'MB']),
            'speak' => fake()->randomElement(['R', 'B', 'MB']),
            'read' => fake()->randomElement(['R', 'B', 'MB']),
            'cv_id' => Cv::factory(),
        ];
    }
}
