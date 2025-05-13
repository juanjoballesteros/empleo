<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BirthInfo;
use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BirthInfo>
 */
final class BirthInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'birthdate' => fake()->dateTimeBetween(now()->subYears(50), now()->subYears(18)),
            'department_id' => fake()->randomElement(Department::all('id')),
            'city_id' => fake()->randomElement(City::all('id')),
            'cv_id' => Cv::factory(),
        ];
    }
}
