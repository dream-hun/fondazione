<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
final class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => null,
            'description' => fake()->paragraphs(2, true),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'location' => fake()->address(),
            'head_of_department' => fake()->name(),
            'mission' => fake()->paragraphs(1, true),
            'key_responsibilities' => fake()->sentences(5),
            'is_active' => true,
            'display_order' => fake()->numberBetween(0, 100),
        ];
    }
}
