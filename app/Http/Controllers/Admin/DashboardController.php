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
use Illuminate\Support\Facades\DB;
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

    /**
     * @return array<string, mixed>
     */
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

    /**
     * @return list<array{month: string, blogs: mixed, projects: mixed, notices: mixed}>
     */
    private function getMonthlyTrends(): array
    {
        $year = now()->year;
        $monthExpression = $this->monthExpression();

        $blogCounts = Blog::query()
            ->whereYear('created_at', $year)
            ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $projectCounts = Project::query()
            ->whereYear('created_at', $year)
            ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $noticeCounts = Notice::query()
            ->whereYear('created_at', $year)
            ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        /** @var list<array{month: string, blogs: mixed, projects: mixed, notices: mixed}> */
        return collect(range(1, 12))
            ->map(function (int $month) use ($blogCounts, $projectCounts, $noticeCounts): array {
                $ts = mktime(0, 0, 0, $month, 1);

                return [
                    'month' => $ts !== false ? date('M', $ts) : '',
                    'blogs' => $blogCounts->get($month, 0),
                    'projects' => $projectCounts->get($month, 0),
                    'notices' => $noticeCounts->get($month, 0),
                ];
            })
            ->values()
            ->all();
    }

    private function monthExpression(): string
    {
        return match (DB::connection()->getDriverName()) {
            'sqlite' => "CAST(strftime('%m', created_at) AS INTEGER)",
            default => 'MONTH(created_at)',
        };
    }
}
