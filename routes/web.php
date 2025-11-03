<?php

declare(strict_types=1);

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TvetController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about-us', AboutUsController::class)->name('about-us');
Route::get('/our-team', TeamController::class)->name('team');
Route::get('/resources', ResourceController::class)->name('resources');
Route::get('/tvet-training-center', TvetController::class)->name('tvet');
Route::get('/donate', DonateController::class)->name('donate');
// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');

// Project routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

// Notice routes
Route::get('/announcements', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/announcements/{notice:slug}', [NoticeController::class, 'show'])->name('notices.show');
// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Blog management
    Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);
    Route::post('blogs/bulk-action', [App\Http\Controllers\Admin\BlogController::class, 'bulkAction'])->name('blogs.bulk-action');

    // Project management
    Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);
    Route::post('projects/bulk-action', [App\Http\Controllers\Admin\ProjectController::class, 'bulkAction'])->name('projects.bulk-action');

    // Notice management
    Route::resource('notices', App\Http\Controllers\Admin\NoticeController::class);
    Route::post('notices/bulk-action', [App\Http\Controllers\Admin\NoticeController::class, 'bulkAction'])->name('notices.bulk-action');

    // User management
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('users/bulk-action', [App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulk-action');

    // Team management
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);
    Route::post('teams/bulk-action', [App\Http\Controllers\Admin\TeamController::class, 'bulkAction'])->name('teams.bulk-action');

    // Department management
    Route::resource('departments', App\Http\Controllers\Admin\DepartmentController::class);
    Route::post('departments/bulk-action', [App\Http\Controllers\Admin\DepartmentController::class, 'bulkAction'])->name('departments.bulk-action');

    // API endpoints for dashboard
    Route::get('api/stats', [App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->name('api.stats');
});
