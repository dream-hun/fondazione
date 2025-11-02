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
        $projects = Project::published()
            ->when($request->search, fn ($query, $search) => $query->search($search))
            ->when($request->location, fn ($query, $location) => $query->where('location', 'like', "%{$location}%"))
            ->latest()
            ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        // Only show published projects
        if (! $project->is_active) {
            abort(404);
        }

        // Get related projects
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->when($project->location, fn ($query, $location) => $query->where('location', 'like', "%{$location}%")
            )
            ->latest()
            ->limit(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
