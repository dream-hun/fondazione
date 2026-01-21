<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Blog;
use App\Models\Notice;
use App\Models\Project;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Factory|View
    {
        $projects = Project::query()->latest()->get()->take(3);
        $posts = Blog::query()->latest()->get()->take(3);
        $notices = Notice::query()->latest()->get()->take(3);

        return view('home', ['projects' => $projects, 'posts' => $posts, 'notices' => $notices]);
    }
}
