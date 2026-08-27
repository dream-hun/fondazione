<?php

declare(strict_types=1);

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

uses(RefreshDatabase::class);

test('the layout composer shares cached published projects', function (): void {
    $viewRoot = storage_path('framework/testing/composer-views');
    $layoutDirectory = $viewRoot.'/layouts';

    if (! is_dir($layoutDirectory)) {
        mkdir($layoutDirectory, 0777, true);
    }

    file_put_contents($layoutDirectory.'/app.blade.php', '<nav data-count="{{ $projects->count() }}"></nav>');

    /** @phpstan-ignore method.notFound */
    View::getFinder()->prependLocation($viewRoot);

    Project::factory()->count(3)->published()->create();
    Project::factory()->draft()->create();

    /** @phpstan-ignore argument.type */
    $html = view('layouts.app')->render();

    expect($html)->toContain('data-count="3"')
        ->and(Cache::has('nav_projects'))->toBeTrue();

    Cache::forget('nav_projects');
});
