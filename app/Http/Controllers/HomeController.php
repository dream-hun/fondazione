<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Notice;

final class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $projects = Project::latest()->get()->take(3);
        $posts = Blog::latest()->get()->take(3);
        $notices = Notice::latest()->get()->take(3);

        return view('home', ['projects' => $projects, 'posts' => $posts, 'notices' => $notices]);
    }
}
