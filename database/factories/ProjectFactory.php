<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
final class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => fake()->paragraph(3),
            'content' => fake()->paragraphs(5, true),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'start_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'end_date' => fake()->optional(0.7)->dateTimeBetween('now', '+2 years'),
            'budget' => fake()->optional(0.8)->randomFloat(2, 1000, 100000),
            'location' => fake()->optional(0.9)->city().', '.fake()->country(),
            'beneficiaries_count' => fake()->optional(0.8)->numberBetween(10, 5000),
            'featured_image' => fake()->optional(0.9)->imageUrl(800, 600, 'projects'),
            'gallery_images' => fake()->optional(0.6)->randomElements([
                fake()->imageUrl(800, 600, 'projects'),
                fake()->imageUrl(800, 600, 'projects'),
                fake()->imageUrl(800, 600, 'projects'),
            ], fake()->numberBetween(1, 3)),
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
        ];
    }

    /**
     * Indicate that the project is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the project is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    /**
     * Indicate that the project is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }

    /**
     * Indicate that the project is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'status' => 'published', // Featured projects should be published
        ]);
    }

    /**
     * Indicate that the project is ongoing (no end date).
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => null,
        ]);
    }

    /**
     * Indicate that the project is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
