<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobOffer>
 */
final class JobOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraph(),
            'requirements' => fake()->paragraph(),
            'salary' => fake()->numberBetween(1500000, 10000000),
            'type' => fake()->randomElement(['Indefinido', 'Temporal', 'Por Proyecto']),
            'location' => 'Remoto',
            'company_id' => Company::factory(),
        ];
    }

    public function presencial(): self
    {
        return $this->state(fn (array $attributes): array => [
            'location' => 'Presencial',
            'department_id' => Department::all()->random(),
            'city_id' => fn (array $attributes) => City::query()
                ->where('department_id', $attributes['department_id'])
                ->inRandomOrder()
                ->first(),
        ]);
    }
}
