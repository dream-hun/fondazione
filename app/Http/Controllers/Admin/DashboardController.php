<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Notice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(): View
    {
        $stats = $this->getDashboardStats();

        return view('admin.dashboard.index', ['stats' => $stats]);
    }

    /**
     * Get dashboard statistics (API endpoint)
     */
    public function getStats(): JsonResponse
    {
        $stats = $this->getDashboardStats();

        return response()->json($stats);
    }

    /**
     * Compile dashboard statistics
     */
    private function getDashboardStats(): array
    {
        return [
            'totals' => [
                'blogs' => Blog::query()->count(),
                'projects' => Project::query()->count(),
                'notices' => Notice::query()->count(),
                'users' => User::query()->count(),
            ],
            'published' => [
                'blogs' => Blog::query()->where('status', 'published')->count(),
                'projects' => Project::query()->where('status', 'published')->count(),
                'notices' => Notice::query()->where('status', 'Published')->count(),
            ],
            'drafts' => [
                'blogs' => Blog::query()->where('status', 'draft')->count(),
                'projects' => Project::query()->where('status', 'draft')->count(),
                'notices' => Notice::query()->where('status', 'Draft')->count(),
            ],
            'recent_activity' => [
                'blogs' => Blog::query()->latest()->take(5)->get(['id', 'title', 'status', 'created_at']),
                'projects' => Project::query()->latest()->take(5)->get(['id', 'title', 'status', 'created_at']),
                'notices' => Notice::query()->latest()->take(5)->get(['id', 'title', 'status', 'created_at']),
            ],
            'monthly_trends' => $this->getMonthlyTrends(),
        ];
    }

    /**
     * Get monthly content creation trends for current year
     */
    private function getMonthlyTrends(): array
    {
        $currentYear = now()->year;
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $months[] = [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'blogs' => Blog::query()->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'projects' => Project::query()->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'notices' => Notice::query()->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count(),
            ];
        }

        return $months;
    }
}
