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
        $query = Blog::published()->latest('published_at');
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        $blogs = $query->paginate(15);

        return view('blog.index', ['blogs' => $blogs]);
    }

    public function show(Blog $blog): View
    {
        if (! $blog->is_active) {
            abort(404);
        }

        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', ['blog' => $blog, 'relatedBlogs' => $relatedBlogs]);
    }
}
