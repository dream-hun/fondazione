<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class AboutUsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Factory|View
    {
        $teams = Team::query()->select('name', 'position', 'image', 'email')->latest()->get();

        return view('about-us', ['teams' => $teams]);
    }
}
