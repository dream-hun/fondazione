<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enum\Notices\Status as NoticeStatus;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Department;
use App\Models\Notice;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', ['stats' => $this->getDashboardStats()]);
    }

    public function getStats(): JsonResponse
    {
        return response()->json($this->getDashboardStats());
    }

    private function getDashboardStats(): array
    {
        return [
            'totals' => [
                'blogs' => Blog::query()->count(),
                'projects' => Project::query()->count(),
                'notices' => Notice::query()->count(),
                'users' => User::query()->count(),
                'departments' => Department::query()->count(),
                'teams' => Team::query()->count(),
            ],
            'published' => [
                'blogs' => Blog::query()->where('status', 'published')->count(),
                'projects' => Project::query()->where('status', 'published')->count(),
                'notices' => Notice::query()->where('status', NoticeStatus::Published)->count(),
            ],
            'drafts' => [
                'blogs' => Blog::query()->where('status', 'draft')->count(),
                'projects' => Project::query()->where('status', 'draft')->count(),
                'notices' => Notice::query()->where('status', NoticeStatus::Draft)->count(),
            ],
            'active' => [
                'departments' => Department::query()->where('is_active', true)->count(),
            ],
            'recent_activity' => [
                'blogs' => Blog::query()->latest()->limit(5)->get(['id', 'title', 'status', 'created_at']),
                'projects' => Project::query()->latest()->limit(5)->get(['id', 'title', 'status', 'created_at']),
                'notices' => Notice::query()->latest()->limit(5)->get(['id', 'title', 'status', 'created_at']),
                'users' => User::query()->latest()->limit(5)->get(['id', 'name', 'email', 'is_admin', 'created_at']),
            ],
            'monthly_trends' => $this->getMonthlyTrends(),
        ];
    }

    private function getMonthlyTrends(): array
    {
        $year = now()->year;

        $aggregate = fn (string $model): \Illuminate\Support\Collection => $model::query()
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $blogCounts = $aggregate(Blog::class);
        $projectCounts = $aggregate(Project::class);
        $noticeCounts = $aggregate(Notice::class);

        return collect(range(1, 12))
            ->map(fn (int $month): array => [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'blogs' => $blogCounts->get($month, 0),
                'projects' => $projectCounts->get($month, 0),
                'notices' => $noticeCounts->get($month, 0),
            ])
            ->values()
            ->all();
    }
}
