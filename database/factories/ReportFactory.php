<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enum\Reports\Status;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
final class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4, true),
            'file_path' => 'reports/fake-report-'.fake()->uuid().'.pdf',
            'status' => Status::Draft,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Status::Published,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Status::Unpublished,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Status::Draft,
        ]);
    }
}
