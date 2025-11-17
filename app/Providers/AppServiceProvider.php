<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        try {
            View::share('projects', Project::published()->limit(5)->get());
        } catch (Exception) {
            View::share('projects', collect([]));
        }
    }
}
