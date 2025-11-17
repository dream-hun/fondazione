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

        return view('admin.dashboard.index', compact('stats'));
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
                'blogs' => Blog::count(),
                'projects' => Project::count(),
                'notices' => Notice::count(),
                'users' => User::count(),
            ],
            'published' => [
                'blogs' => Blog::where('status', 'published')->count(),
                'projects' => Project::where('status', 'published')->count(),
                'notices' => Notice::where('status', 'Published')->count(),
            ],
            'drafts' => [
                'blogs' => Blog::where('status', 'draft')->count(),
                'projects' => Project::where('status', 'draft')->count(),
                'notices' => Notice::where('status', 'Draft')->count(),
            ],
            'recent_activity' => [
                'blogs' => Blog::latest()->take(5)->get(['id', 'title', 'status', 'created_at']),
                'projects' => Project::latest()->take(5)->get(['id', 'title', 'status', 'created_at']),
                'notices' => Notice::latest()->take(5)->get(['id', 'title', 'status', 'created_at']),
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
                'blogs' => Blog::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'projects' => Project::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'notices' => Notice::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count(),
            ];
        }

        return $months;
    }
}
