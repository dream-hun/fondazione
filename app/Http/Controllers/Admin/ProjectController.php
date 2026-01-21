<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
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
            ->orderBy(request('sort', 'created_at'), 'desc')
            ->paginate(15);

        return view('admin.projects.index', ['projects' => $projects]);
    }

    public function create(): Factory|View
    {
        return view('admin.projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('projects/featured', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $image->store('projects/gallery', 'public');
            }

            $validated['gallery_images'] = $galleryImages;
        }

        $project = Project::query()->create($validated);

        $message = 'Project created successfully.';

        if ($request->has('save_and_continue')) {
            return to_route('admin.projects.edit', $project)->with('success', $message);
        }

        return to_route('admin.projects.index')->with('success', $message);
    }

    public function show(Project $project): Factory|View
    {
        return view('admin.projects.show', ['project' => $project]);
    }

    public function edit(Project $project): Factory|View
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $currentGallery = $project->gallery_images ?? [];
        $galleryUpdated = false;

        // Handle featured image removal
        if ($request->boolean('remove_featured_image') && $project->featured_image) {
            Storage::disk('public')->delete($project->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old featured image if exists
            if ($project->featured_image) {
                Storage::disk('public')->delete($project->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')->store('projects/featured', 'public');
        }

        // Handle gallery images removal
        if ($request->filled('remove_gallery_images') && $currentGallery) {
            $indicesToRemove = $request->input('remove_gallery_images', []);

            foreach ($indicesToRemove as $index) {
                if (isset($currentGallery[$index])) {
                    Storage::disk('public')->delete($currentGallery[$index]);
                    unset($currentGallery[$index]);
                    $galleryUpdated = true;
                }
            }

            $currentGallery = array_values($currentGallery);
        }

        // Handle new gallery images upload
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

        // Remove fields that are not in the database
        unset($validated['remove_featured_image'], $validated['remove_gallery_images']);

        $project->update($validated);

        $message = 'Project updated successfully.';

        if ($request->has('save_and_continue')) {
            return to_route('admin.projects.edit', $project)->with('success', $message);
        }

        return to_route('admin.projects.index')->with('success', $message);
    }

    public function destroy(Project $project)
    {
        // Delete associated images
        if ($project->featured_image) {
            Storage::disk('public')->delete($project->featured_image);
        }

        if ($project->gallery_images) {
            foreach ($project->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $project->delete();

        return to_route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => ['required', 'in:publish,unpublish,archive,feature,unfeature,delete'],
            'selected_projects' => ['required', 'array', 'min:1'],
            'selected_projects.*' => ['exists:projects,id'],
        ]);

        $projectIds = $request->input('selected_projects');
        $action = $request->input('action');
        $count = 0;

        switch ($action) {
            case 'publish':
                $count = Project::query()->whereIn('id', $projectIds)->update(['status' => 'published']);
                break;

            case 'unpublish':
                $count = Project::query()->whereIn('id', $projectIds)->update(['status' => 'draft']);
                break;

            case 'archive':
                $count = Project::query()->whereIn('id', $projectIds)->update(['status' => 'archived']);
                break;

            case 'feature':
                $count = Project::query()->whereIn('id', $projectIds)->update(['is_featured' => true]);
                break;

            case 'unfeature':
                $count = Project::query()->whereIn('id', $projectIds)->update(['is_featured' => false]);
                break;

            case 'delete':
                $projects = Project::query()->whereIn('id', $projectIds)->get();

                foreach ($projects as $project) {
                    // Delete associated images
                    if ($project->featured_image) {
                        Storage::disk('public')->delete($project->featured_image);
                    }

                    if ($project->gallery_images) {
                        foreach ($project->gallery_images as $image) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                }

                $count = Project::query()->whereIn('id', $projectIds)->delete();
                break;
        }

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
}
