<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cv;
use App\Models\PersonalInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PersonalInfo>
 */
final class PersonalInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'second_name' => fake()->firstName(),
            'first_surname' => fake()->lastName(),
            'second_surname' => fake()->lastName(),
            'sex' => fake()->randomElement(['Femenino', 'Masculino']),
            'document_type' => fake()->randomElement(['CC', 'CE', 'PAS']),
            'document_number' => fake()->randomNumber(9),
            'description' => fake()->text(),
            'cv_id' => Cv::factory(),
        ];
    }
}
