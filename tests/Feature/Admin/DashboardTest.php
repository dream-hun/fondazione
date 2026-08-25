<?php

declare(strict_types=1);

use App\Models\Blog;
use App\Models\Department;
use App\Models\Notice;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Date;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->admin = User::factory()->create([
        'is_admin' => true,
        'email' => 'admin@example.com',
    ]);

    $this->user = User::factory()->create([
        'is_admin' => false,
        'email' => 'user@example.com',
    ]);
});

test('admin can view the dashboard', function (): void {
    Blog::factory()->count(2)->published()->create();
    Project::factory()->published()->create();
    Notice::factory()->published()->create();
    Department::factory()->count(2)->create();
    Team::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Dashboard');
});

test('non-admin cannot view the dashboard', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('guest is redirected to login from the dashboard', function (): void {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('stats endpoint returns dashboard statistics', function (): void {
    Blog::factory()->published()->create(['title' => 'Published Blog']);
    Blog::factory()->draft()->create();
    Project::factory()->published()->create();
    Notice::factory()->published()->create();
    Department::factory()->create();
    Team::factory()->create();

    $response = $this->actingAs($this->admin)
        ->getJson(route('admin.api.stats'))
        ->assertSuccessful()
        ->assertJsonStructure([
            'totals' => ['blogs', 'projects', 'notices', 'users', 'departments', 'teams'],
            'published' => ['blogs', 'projects', 'notices'],
            'drafts' => ['blogs', 'projects', 'notices'],
            'active' => ['departments'],
            'recent_activity',
            'monthly_trends',
        ]);

    $stats = $response->json();

    expect($stats['totals']['blogs'])->toBe(2)
        ->and($stats['totals']['projects'])->toBe(1)
        ->and($stats['totals']['notices'])->toBe(1)
        ->and($stats['totals']['departments'])->toBe(1)
        ->and($stats['totals']['teams'])->toBe(1)
        ->and($stats['published']['blogs'])->toBe(1)
        ->and($stats['drafts']['blogs'])->toBe(1)
        ->and($stats['active']['departments'])->toBe(1);
});

test('monthly trends cover all twelve months of the year', function (): void {
    $currentMonth = (int) now()->format('n');
    Blog::factory()->count(3)->create();

    $trends = $this->actingAs($this->admin)
        ->getJson(route('admin.api.stats'))
        ->json('monthly_trends');

    assert(is_array($trends));

    expect($trends)->toHaveCount(12)
        ->and($trends[$currentMonth - 1]['blogs'])->toBe(3);

    collect(range(0, 11))->each(function (int $index) use ($trends): void {
        expect($trends[$index]['month'])->toBe(Date::create(now()->year, $index + 1, 1)->format('M'));
    });
});

test('non-admin cannot access stats endpoint', function (): void {
    $this->actingAs($this->user)
        ->getJson(route('admin.api.stats'))
        ->assertForbidden();
});
