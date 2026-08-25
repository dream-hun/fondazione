<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::query();

        if ($search = $request->string('search')->toString()) {
            $query->search($search);
        }

        if ($status = $request->string('status')->toString()) {
            if ($status === 'published') {
                $query->published();
            } elseif ($status === 'draft') {
                $query->draft();
            }
        }

        if ($request->get('featured') === '1') {
            $query->featured();
        }

        $sortBy = $request->string('sort', 'created_at')->toString();
        $sortDirection = $request->string('direction', 'desc')->toString() === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $blogs = $query->paginate(15)->withQueryString();

        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    public function create(): View
    {
        return view('admin.blogs.create');
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs/featured-images', 'public');
        }

        $blog = Blog::query()->create($validated);

        return to_route('admin.blogs.index')
            ->with('success', 'Blog "'.$blog->title.'" created successfully.');
    }

    public function show(Blog $blog): View
    {
        return view('admin.blogs.show', ['blog' => $blog]);
    }

    public function edit(Blog $blog): View
    {
        return view('admin.blogs.edit', ['blog' => $blog]);
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs/featured-images', 'public');
        }

        $blog->update($validated);

        return to_route('admin.blogs.index')
            ->with('success', 'Blog "'.$blog->title.'" updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $title = $blog->title;

        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return to_route('admin.blogs.index')
            ->with('success', 'Blog "'.$title.'" deleted successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,publish,unpublish,feature,unfeature'],
            'selected_blogs' => ['required', 'array', 'min:1'],
            'selected_blogs.*' => ['exists:blogs,id'],
        ]);

        /** @var list<int|string> $blogIds */
        $blogIds = (array) $request->input('selected_blogs');
        $action = $request->string('action')->value();
        $count = count($blogIds);

        $message = match ($action) {
            'delete' => $this->bulkDelete($blogIds, $count),
            'publish' => $this->bulkPublish($blogIds, $count),
            'unpublish' => $this->bulkUnpublish($blogIds, $count),
            'feature' => $this->bulkFeature($blogIds, $count),
            'unfeature' => $this->bulkUnfeature($blogIds, $count),
        };

        return to_route('admin.blogs.index')->with('success', $message);
    }

    /** @param list<int|string> $blogIds */
    private function bulkDelete(array $blogIds, int $count): string
    {
        Blog::query()->whereIn('id', $blogIds)->each(function (Blog $blog): void {
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $blog->delete();
        });

        return $count.' blog(s) deleted successfully.';
    }

    /** @param list<int|string> $blogIds */
    private function bulkPublish(array $blogIds, int $count): string
    {
        Blog::query()->whereIn('id', $blogIds)->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return $count.' blog(s) published successfully.';
    }

    /** @param list<int|string> $blogIds */
    private function bulkUnpublish(array $blogIds, int $count): string
    {
        Blog::query()->whereIn('id', $blogIds)->update(['status' => 'draft']);

        return $count.' blog(s) unpublished successfully.';
    }

    /** @param list<int|string> $blogIds */
    private function bulkFeature(array $blogIds, int $count): string
    {
        Blog::query()->whereIn('id', $blogIds)->update(['is_featured' => true]);

        return $count.' blog(s) marked as featured.';
    }

    /** @param list<int|string> $blogIds */
    private function bulkUnfeature(array $blogIds, int $count): string
    {
        Blog::query()->whereIn('id', $blogIds)->update(['is_featured' => false]);

        return $count.' blog(s) removed from featured.';
    }
}
