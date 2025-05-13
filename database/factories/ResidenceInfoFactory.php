<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\ResidenceInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResidenceInfo>
 */
final class ResidenceInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => fake()->randomElement(Department::all('id')),
            'city_id' => fake()->randomElement(City::all('id')),
            'address' => fake()->address(),
            'cv_id' => Cv::factory(),
        ];
    }
}
