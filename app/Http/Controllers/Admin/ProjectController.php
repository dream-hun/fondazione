<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enum\Projects\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class ProjectController extends Controller
{
    public function index(): Factory|View
    {
        $projects = Project::query()
            ->when(request('search'), function ($query, $search): void {
                $query->search($search);
            })
            ->when(request('status'), function ($query, $status): void {
                $query->where('status', $status);
            })
            ->when(request('featured') === '1', function ($query): void {
                $query->featured();
            })
            ->when(request('category'), function ($query, $categoryValue): void {
                $category = Category::tryFrom($categoryValue);
                if ($category !== null) {
                    $query->category($category);
                }
            })
            ->orderBy(request('sort', 'created_at'), 'desc')
            ->paginate(15);

        return view('admin.projects.index', ['projects' => $projects]);
    }

    public function create(): Factory|View
    {
        return view('admin.projects.create');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('projects/featured', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $validated['gallery_images'] = collect($request->file('gallery_images'))
                ->map(fn ($image) => $image->store('projects/gallery', 'public'))
                ->values()
                ->all();
        }

        $project = Project::query()->create($validated);

        if ($request->has('save_and_continue')) {
            return to_route('admin.projects.edit', $project)->with('success', 'Project created successfully.');
        }

        return to_route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project): Factory|View
    {
        return view('admin.projects.show', ['project' => $project]);
    }

    public function edit(Project $project): Factory|View
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();
        $currentGallery = $project->gallery_images ?? [];
        $galleryUpdated = false;

        if ($request->boolean('remove_featured_image') && $project->featured_image) {
            Storage::disk('public')->delete($project->featured_image);
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')->store('projects/featured', 'public');
        }

        if ($request->filled('remove_gallery_images') && $currentGallery) {
            foreach ($request->input('remove_gallery_images', []) as $index) {
                if (isset($currentGallery[$index])) {
                    Storage::disk('public')->delete($currentGallery[$index]);
                    unset($currentGallery[$index]);
                    $galleryUpdated = true;
                }
            }

            $currentGallery = array_values($currentGallery);
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $currentGallery[] = $image->store('projects/gallery', 'public');
            }

            $currentGallery = array_values($currentGallery);
            $galleryUpdated = true;
        }

        if ($galleryUpdated) {
            $validated['gallery_images'] = $currentGallery;
        }

        unset($validated['remove_featured_image'], $validated['remove_gallery_images']);

        $project->update($validated);

        if ($request->has('save_and_continue')) {
            return to_route('admin.projects.edit', $project)->with('success', 'Project updated successfully.');
        }

        return to_route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->featured_image) {
            Storage::disk('public')->delete($project->featured_image);
        }

        foreach ($project->gallery_images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $project->delete();

        return to_route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:publish,unpublish,archive,feature,unfeature,delete'],
            'selected_projects' => ['required', 'array', 'min:1'],
            'selected_projects.*' => ['exists:projects,id'],
        ]);

        $projectIds = $request->input('selected_projects');
        $action = $request->input('action');

        $count = match ($action) {
            'publish' => Project::query()->whereIn('id', $projectIds)->update(['status' => 'published']),
            'unpublish' => Project::query()->whereIn('id', $projectIds)->update(['status' => 'draft']),
            'archive' => Project::query()->whereIn('id', $projectIds)->update(['status' => 'archived']),
            'feature' => Project::query()->whereIn('id', $projectIds)->update(['is_featured' => true]),
            'unfeature' => Project::query()->whereIn('id', $projectIds)->update(['is_featured' => false]),
            'delete' => $this->bulkDelete($projectIds),
        };

        $actionText = match ($action) {
            'publish' => 'published',
            'unpublish' => 'unpublished',
            'archive' => 'archived',
            'feature' => 'marked as featured',
            'unfeature' => 'removed from featured',
            'delete' => 'deleted',
        };

        return to_route('admin.projects.index')
            ->with('success', sprintf('%s project(s) %s successfully.', $count, $actionText));
    }

    /** @param list<int|string> $projectIds */
    private function bulkDelete(array $projectIds): int
    {
        $count = 0;

        Project::query()->whereIn('id', $projectIds)->each(function (Project $project) use (&$count): void {
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }

            foreach ($project->gallery_images ?? [] as $image) {
                Storage::disk('public')->delete($image);
            }

            $project->delete();
            $count++;
        });

        return $count;
    }
}
