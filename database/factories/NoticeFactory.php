<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enum\Notices\Status;
use App\Models\Notice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notice>
 */
final class NoticeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4, true),
            'slug' => null,
            'excerpt' => fake()->paragraph(1, true),
            'body' => fake()->paragraphs(3, true),
            'attachment' => null,
            'status' => Status::Published,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Status::Draft,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Status::Unpublished,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Status::Published,
        ]);
    }
}
