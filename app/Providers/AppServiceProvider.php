<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.app', function (\Illuminate\View\View $view): void {
            $view->with('projects', $this->resolveNavProjects());
        });
    }

    /** @return EloquentCollection<int, Project> */
    private function resolveNavProjects(): EloquentCollection
    {
        try {
            return Cache::remember('nav_projects', 300, fn (): EloquentCollection => Project::query()->published()->limit(5)->get());
        } catch (Exception) {
            return new EloquentCollection;
        }
    }
}
