<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
final class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'nit' => fake()->randomNumber(9),
            'department_id' => Department::all()->random(),
            'city_id' => fn (array $attributes) => City::query()
                ->where('department_id', $attributes['department_id'])
                ->inRandomOrder()
                ->first(),
        ];
    }
}
