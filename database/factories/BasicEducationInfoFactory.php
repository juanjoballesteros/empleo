<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BasicEducationInfo;
use App\Models\Cv;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BasicEducationInfo>
 */
final class BasicEducationInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'level' => fake()->numberBetween(1, 11),
            'program' => 'BACHILLER',
            'end_date' => fake()->date(),
            'cv_id' => Cv::factory(),
        ];
    }
}
