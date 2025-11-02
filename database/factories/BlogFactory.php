<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
final class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);
        $content = fake()->paragraphs(8, true);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => fake()->paragraph(3),
            'content' => $content,
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-6 months', 'now'),
            'featured_image' => fake()->imageUrl(800, 600, 'nature', true),
            'author_name' => fake()->name(),
            'author_email' => fake()->safeEmail(),
            'tags' => implode(', ', fake()->words(fake()->numberBetween(2, 5))),
            'is_featured' => fake()->boolean(20),
            'reading_time' => fake()->numberBetween(2, 15),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
