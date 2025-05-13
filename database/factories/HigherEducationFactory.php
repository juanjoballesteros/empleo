<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
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
            'type' => fake()->randomElement(['TC', 'TL', 'TE', 'UN', 'ES', 'MG', 'DOC']),
            'semester' => fake()->numberBetween('1', '12'),
            'date_semester' => fake()->date(),
            'licensed' => fake()->randomElement(['Si', 'No']),
            'program' => fake()->word(),
            'department_id' => fake()->randomElement(Department::all('id')),
            'city_id' => fake()->randomElement(City::all('id')),
            'cv_id' => Cv::factory(),
        ];
    }
}
