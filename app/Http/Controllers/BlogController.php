<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::query()->published()->latest('published_at');

        $search = $request->get('search');
        $tag = $request->get('tag');

        if ($search) {
            $query->search($search);
        }

        if ($tag) {
            $query->byTag($tag);
        }

        $isFiltering = filled($search) || filled($tag);

        $blogs = $query->paginate(15);
        $featuredBlogs = $isFiltering
            ? collect()
            : Blog::query()->published()->featured()->latest('published_at')->take(3)->get();

        return view('blog.index', [
            'blogs' => $blogs,
            'featuredBlogs' => $featuredBlogs,
            'isFiltering' => $isFiltering,
        ]);
    }

    public function show(Blog $blog): View
    {
        abort_unless($blog->is_active, 404);

        $relatedBlogs = Blog::query()->published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', ['blog' => $blog, 'relatedBlogs' => $relatedBlogs]);
    }
}
