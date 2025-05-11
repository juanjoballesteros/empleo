<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\City;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Candidate>
 */
final class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::query()->inRandomOrder()->first(),
            'city_id' => fn (array $attributes) => City::query()
                ->where('department_id', $attributes['department_id'])
                ->inRandomOrder()
                ->first(),
        ];
    }
}
