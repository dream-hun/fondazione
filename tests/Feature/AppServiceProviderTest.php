<?php

declare(strict_types=1);

use App\Models\Project;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

test('view composer provides shared projects to the layout', function (): void {
    Project::factory()->published()->count(3)->create();

    $this->get(route('home'))
        ->assertSuccessful();
});

test('resolveNavProjects returns empty collection when query fails', function (): void {
    $provider = new AppServiceProvider($this->app);

    $reflection = new ReflectionMethod($provider, 'resolveNavProjects');
    $reflection->setAccessible(true);

    Cache::shouldReceive('remember')
        ->once()
        ->with('nav_projects', 300, Mockery::type(Closure::class))
        ->andThrow(new RuntimeException('DB connection lost'));

    $result = $reflection->invoke($provider);

    expect($result)->toBeInstanceOf(EloquentCollection::class)
        ->toHaveCount(0);
});
