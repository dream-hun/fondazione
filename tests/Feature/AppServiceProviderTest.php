<?php

declare(strict_types=1);

use App\Models\Notice;
use App\Models\Project;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

test('models accept attributes outside their fillable lists in every environment', function (string $environment): void {
    $originalEnvironment = $this->app['env'];
    $provider = new AppServiceProvider($this->app);

    try {
        $this->app['env'] = $environment;
        Model::reguard();
        $provider->boot();

        $notice = new Notice(['id' => 42, 'title' => 'Notice title']);
        $project = new Project(['id' => 43, 'title' => 'Project title']);

        expect($notice->id)->toBe(42);
        expect($notice->title)->toBe('Notice title');
        expect($project->id)->toBe(43);
        expect($project->title)->toBe('Project title');
    } finally {
        $this->app['env'] = $originalEnvironment;
        $provider->boot();
    }
})->with(['local', 'testing', 'production']);

test('lazy loading prevention is enabled only outside production', function (string $environment, bool $preventLazyLoading): void {
    $originalEnvironment = $this->app['env'];
    $provider = new AppServiceProvider($this->app);

    try {
        $this->app['env'] = $environment;
        $provider->boot();

        expect(Model::preventsLazyLoading())->toBe($preventLazyLoading);
    } finally {
        $this->app['env'] = $originalEnvironment;
        $provider->boot();
    }
})->with([
    'local' => ['local', true],
    'testing' => ['testing', true],
    'production' => ['production', false],
]);

test('view composer provides shared projects to the layout', function (): void {
    Project::factory()->published()->count(3)->create();

    $this->get(route('home'))
        ->assertSuccessful();
});

test('resolveNavProjects returns empty collection when query fails', function (): void {
    $provider = new AppServiceProvider($this->app);

    $reflection = new ReflectionMethod($provider, 'resolveNavProjects');

    Cache::shouldReceive('remember')
        ->once()
        ->with('nav_projects', 300, Mockery::type(Closure::class))
        ->andThrow(new RuntimeException('DB connection lost'));

    $result = $reflection->invoke($provider);

    expect($result)->toBeInstanceOf(EloquentCollection::class)
        ->toHaveCount(0);
});
