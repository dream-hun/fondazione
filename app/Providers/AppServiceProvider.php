<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('components.layouts.app', function (\Illuminate\View\View $view): void {
            $view->with('sharedProjects', Cache::remember('nav_projects', 300, function (): \Illuminate\Database\Eloquent\Collection {
                try {
                    return Project::query()->published()->limit(5)->get();
                } catch (Exception) {
                    return collect();
                }
            }));
        });
    }
}
