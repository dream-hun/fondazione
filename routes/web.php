<?php

declare(strict_types=1);

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TvetController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about-us', AboutUsController::class)->name('about-us');
Route::get('/our-team', TeamController::class)->name('team');
Route::get('/resources', ResourceController::class)->name('resources');
Route::get('/tvet-training-center', TvetController::class)->name('tvet');
Route::get('/donate', DonateController::class)->name('donate');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');

// Project routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

// Notice routes
Route::get('/announcements', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/announcements/{notice:slug}', [NoticeController::class, 'show'])->name('notices.show');

// Reports routes
Route::get('/reports', ReportController::class)->name('reports.index');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth', 'admin'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Blog management — bulk-action must be registered before resource to avoid {blog} wildcard capture
    Route::post('blogs/bulk-action', [AdminBlogController::class, 'bulkAction'])->name('blogs.bulk-action');
    Route::resource('blogs', AdminBlogController::class);

    // Project management
    Route::post('projects/bulk-action', [AdminProjectController::class, 'bulkAction'])->name('projects.bulk-action');
    Route::resource('projects', AdminProjectController::class);

    // Notice management
    Route::post('notices/bulk-action', [AdminNoticeController::class, 'bulkAction'])->name('notices.bulk-action');
    Route::resource('notices', AdminNoticeController::class);

    // User management
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    Route::resource('users', UserController::class);

    // Team management
    Route::post('teams/bulk-action', [AdminTeamController::class, 'bulkAction'])->name('teams.bulk-action');
    Route::resource('teams', AdminTeamController::class);

    // Department management
    Route::post('departments/bulk-action', [DepartmentController::class, 'bulkAction'])->name('departments.bulk-action');
    Route::resource('departments', DepartmentController::class);

    // Reports management
    Route::post('reports/bulk-action', [AdminReportController::class, 'bulkAction'])->name('reports.bulk-action');
    Route::resource('reports', AdminReportController::class);

    // API endpoints for dashboard
    Route::get('api/stats', [DashboardController::class, 'getStats'])->name('api.stats');
});
