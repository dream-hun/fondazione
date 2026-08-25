<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\Projects\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString() ?: null;
        $location = $request->string('location')->toString() ?: null;
        $isFiltering = filled($search) || filled($location);

        if ($isFiltering) {
            $baseQuery = Project::query()->published()
                ->when($search, fn (Builder $query, string $term) => $query->search($term))
                ->when($location, fn (Builder $query, string $loc) => $query->where('location', 'like', sprintf('%%%s%%', $loc)))
                ->latest();

            $cdspProjects = (clone $baseQuery)->category(Category::Cdsp)->get();
            $wdpProjects = (clone $baseQuery)->category(Category::Wdp)->get();
        } else {
            $cdspProjects = Cache::remember('projects_cdsp', 300, fn () => Project::query()->published()->category(Category::Cdsp)->latest()->get());
            $wdpProjects = Cache::remember('projects_wdp', 300, fn () => Project::query()->published()->category(Category::Wdp)->latest()->get());
        }

        return view('projects.index', ['cdspProjects' => $cdspProjects, 'wdpProjects' => $wdpProjects]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_active, 404);

        $relatedProjects = Cache::remember(
            sprintf('project_related_%s', $project->id),
            300,
            fn () => Project::query()->published()
                ->where('id', '!=', $project->id)
                ->category($project->category)
                ->latest()
                ->limit(3)
                ->get()
        );

        return view('projects.show', ['project' => $project, 'relatedProjects' => $relatedProjects]);
    }
}
