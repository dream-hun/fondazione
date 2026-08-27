<?php

declare(strict_types=1);

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

uses(RefreshDatabase::class);

test('sitemap uses date-only last modification values', function (): void {
    Cache::forget('sitemap.xml');

    $updatedAt = Date::create(2026, 8, 27, 14, 30);
    $project = Project::factory()->published()->create([
        'updated_at' => $updatedAt,
    ]);

    $response = $this->get(route('sitemap'));

    $response->assertOk()
        ->assertSee('<lastmod>2026-08-27</lastmod>', false)
        ->assertDontSee($updatedAt->toIso8601String());
});
