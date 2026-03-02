<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\Projects\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Project::query()->published()
            ->when($request->search, fn ($query, $search) => $query->search($search))
            ->when($request->location, fn ($query, string $location) => $query->where('location', 'like', sprintf('%%%s%%', $location)))
            ->latest();

        $cdspProjects = (clone $baseQuery)->category(Category::Cdsp)->get();
        $wdpProjects = (clone $baseQuery)->category(Category::Wdp)->get();

        return view('projects.index', compact('cdspProjects', 'wdpProjects'));
    }

    public function show(Project $project): View
    {
        // Only show published projects
        abort_unless($project->is_active, 404);

        // Get related projects from the same category
        $relatedProjects = Project::query()->published()
            ->where('id', '!=', $project->id)
            ->category($project->category)
            ->latest()
            ->limit(3)
            ->get();

        return view('projects.show', ['project' => $project, 'relatedProjects' => $relatedProjects]);
    }
}
