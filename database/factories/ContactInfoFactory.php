<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ContactInfo;
use App\Models\Cv;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactInfo>
 */
final class ContactInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_number' => fake()->numberBetween(3000000000, 3999999999),
            'email' => fake()->email(),
            'cv_id' => Cv::factory(),
        ];
    }
}
