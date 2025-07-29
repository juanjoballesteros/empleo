<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
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
            'birthdate' => fake()->dateTimeBetween(now()->subYears(50), now()->subYears(18)),
            'description' => fake()->text(),
            'department_id' => Department::query()->inRandomOrder()->first(),
            'city_id' => fn (array $attributes) => City::query()->where('department_id', $attributes['department_id'])
                ->inRandomOrder()
                ->first(),
            'cv_id' => Cv::factory(),
        ];
    }
}
