<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::query()->published()->latest('published_at');

        $search = $request->string('search')->toString() ?: null;
        $tag = $request->string('tag')->toString() ?: null;

        if ($search !== null) {
            $query->search($search);
        }

        if ($tag !== null) {
            $query->byTag($tag);
        }

        $isFiltering = filled($search) || filled($tag);

        $blogs = $query->paginate(15);
        $featuredBlogs = $isFiltering
            ? collect()
            : Cache::remember('blog_featured', 300, fn () => Blog::query()->published()->featured()->latest('published_at')->take(3)->get());

        return view('blog.index', [
            'blogs' => $blogs,
            'featuredBlogs' => $featuredBlogs,
            'isFiltering' => $isFiltering,
        ]);
    }

    public function show(Blog $blog): View
    {
        abort_unless($blog->is_active, 404);

        $relatedBlogs = Cache::remember(
            sprintf('blog_related_%s', $blog->id),
            300,
            fn () => Blog::query()->published()
                ->where('id', '!=', $blog->id)
                ->latest('published_at')
                ->take(3)
                ->get()
        );

        return view('blog.show', ['blog' => $blog, 'relatedBlogs' => $relatedBlogs]);
    }
}
