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
            'date_start' => fake()->dateTimeBetween(),
            'actual' => fake()->randomElement(['Si', 'No']),
            'date_end' => fake()->dateTimeBetween(),
            'post' => fake()->word(),
            'email' => fake()->email(),
            'phone' => fake()->numerify('312#######'),
            'address' => fake()->address(),
            'department_id' => Department::query()->inRandomOrder()->first(),
            'city_id' => fn (array $attributes) => City::query()->where('department_id', $attributes['department_id'])
                ->inRandomOrder()
                ->first(),
            'cv_id' => Cv::factory(),
        ];
    }
}
