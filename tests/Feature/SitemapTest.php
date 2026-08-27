<?php

declare(strict_types=1);

use App\Models\Blog;
use App\Models\Notice;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

uses(RefreshDatabase::class);

test('sitemap uses date-only last modification values', function (): void {
    Cache::forget('sitemap.xml');

    $updatedAt = Date::create(2026, 8, 27, 14, 30);
    Project::factory()->published()->create([
        'slug' => 'water-project',
        'updated_at' => $updatedAt,
    ]);
    Blog::factory()->published()->create([
        'slug' => 'community-health',
        'updated_at' => $updatedAt,
    ]);
    Notice::factory()->published()->create([
        'slug' => 'rainy-season-alert',
        'updated_at' => $updatedAt,
    ]);
    Report::factory()->published()->create([
        'id' => 42,
        'updated_at' => $updatedAt,
    ]);

    $response = $this->get(route('sitemap'));

    $response->assertOk()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee('<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">', false)
        ->assertSee('https://fmorwanda.org/projects/water-project', false)
        ->assertSee('https://fmorwanda.org/blog/community-health', false)
        ->assertSee('https://fmorwanda.org/announcements/rainy-season-alert', false)
        ->assertSee('https://fmorwanda.org/reports/42', false)
        ->assertSee('<lastmod>2026-08-27</lastmod>', false)
        ->assertDontSee($updatedAt->toIso8601String());
});
