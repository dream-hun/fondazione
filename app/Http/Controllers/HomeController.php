<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Notice;
use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    public function __invoke(Request $request): Factory|View
    {
        $projects = Project::query()->published()->latest()->limit(3)->get();
        $posts = Blog::query()->published()->latest('published_at')->limit(3)->get();
        $notices = Notice::query()->latest()->limit(3)->get();

        return view('home', compact('projects', 'posts', 'notices'));
    }
}
