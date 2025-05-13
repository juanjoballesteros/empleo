<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\WorkExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkExperience>
 */
final class WorkExperienceFactory extends Factory
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
            'type' => fake()->randomElement(['Publica', 'Privada']),
            'email' => fake()->email(),
            'phone_number' => fake()->numberBetween(3000000000, 3999999999),
            'date_start' => fake()->dateTimeBetween(),
            'actual' => fake()->randomElement(['Si', 'No']),
            'date_end' => fake()->dateTimeBetween(),
            'cause' => fake()->word(),
            'post' => fake()->word(),
            'dependency' => fake()->word(),
            'address' => fake()->address(),
            'department_id' => fake()->randomElement(Department::all('id')),
            'city_id' => fake()->randomElement(City::all('id')),
            'cv_id' => Cv::factory(),
        ];
    }
}
