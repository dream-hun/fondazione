<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::query()->published()
            ->when($request->search, fn ($query, $search) => $query->search($search))
            ->when($request->location, fn ($query, string $location) => $query->where('location', 'like', sprintf('%%%s%%', $location)))
            ->latest()
            ->paginate(12);

        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project): View
    {
        // Only show published projects
        abort_unless($project->is_active, 404);

        // Get related projects
        $relatedProjects = Project::query()->published()
            ->where('id', '!=', $project->id)
            ->when($project->location, fn ($query, string $location) => $query->where('location', 'like', sprintf('%%%s%%', $location))
            )
            ->latest()
            ->limit(3)
            ->get();

        return view('projects.show', ['project' => $project, 'relatedProjects' => $relatedProjects]);
    }
}
