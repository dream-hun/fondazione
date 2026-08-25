<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Notice;
use App\Models\Project;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class HomeController extends Controller
{
    public function __invoke(Request $request): Factory|View
    {
        $projects = Cache::remember('home_projects', 300, fn () => Project::query()->published()->latest()->limit(3)->get());
        $posts = Cache::remember('home_posts', 300, fn () => Blog::query()->published()->latest('published_at')->limit(3)->get());
        $notices = Cache::remember('home_notices', 300, fn () => Notice::query()->latest()->limit(3)->get());

        return view('home', ['projects' => $projects, 'posts' => $posts, 'notices' => $notices]);
    }
}
