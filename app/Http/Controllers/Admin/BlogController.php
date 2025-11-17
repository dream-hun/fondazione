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
use Illuminate\Support\Str;
use Illuminate\View\View;

final class BlogController extends Controller
{
    /**
     * Display a listing of blogs with search and pagination
     */
    public function index(Request $request): View
    {
        $query = Blog::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        // Status filter
        if ($status = $request->get('status')) {
            if ($status === 'published') {
                $query->published();
            } elseif ($status === 'draft') {
                $query->draft();
            }
        }

        // Featured filter
        if ($request->get('featured') === '1') {
            $query->featured();
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $blogs = $query->paginate(15)->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create(): View
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog
     */
    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs/featured-images', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Blog::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        $blog = Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog "'.$blog->title.'" created successfully.');
    }

    /**
     * Display the specified blog
     */
    public function show(Blog $blog): View
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit(Blog $blog): View
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog
     */
    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $validated['featured_image'] = $request->file('featured_image')
                ->store('blogs/featured-images', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure unique slug (excluding current blog)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Blog::where('slug', $validated['slug'])->where('id', '!=', $blog->id)->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog "'.$blog->title.'" updated successfully.');
    }

    /**
     * Remove the specified blog (soft delete)
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        $title = $blog->title;

        // Delete featured image if exists
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog "'.$title.'" deleted successfully.');
    }

    /**
     * Handle bulk actions on selected blogs
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,publish,unpublish,feature,unfeature',
            'selected_blogs' => 'required|array|min:1',
            'selected_blogs.*' => 'exists:blogs,id',
        ]);

        $blogIds = $request->selected_blogs;
        $action = $request->action;
        $count = count($blogIds);

        switch ($action) {
            case 'delete':
                $blogs = Blog::whereIn('id', $blogIds)->get();
                foreach ($blogs as $blog) {
                    // Delete featured images
                    if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                        Storage::disk('public')->delete($blog->featured_image);
                    }
                }
                Blog::whereIn('id', $blogIds)->delete();
                $message = "{$count} blog(s) deleted successfully.";
                break;

            case 'publish':
                Blog::whereIn('id', $blogIds)->update([
                    'status' => 'published',
                    'published_at' => now(),
                ]);
                $message = "{$count} blog(s) published successfully.";
                break;

            case 'unpublish':
                Blog::whereIn('id', $blogIds)->update(['status' => 'draft']);
                $message = "{$count} blog(s) unpublished successfully.";
                break;

            case 'feature':
                Blog::whereIn('id', $blogIds)->update(['is_featured' => true]);
                $message = "{$count} blog(s) marked as featured.";
                break;

            case 'unfeature':
                Blog::whereIn('id', $blogIds)->update(['is_featured' => false]);
                $message = "{$count} blog(s) removed from featured.";
                break;
        }

        return redirect()->route('admin.blogs.index')->with('success', $message);
    }
}
