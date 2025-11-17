<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

final class AboutUsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $teams = Team::select('name', 'position', 'image', 'email')
            ->orderBy('created_at', 'desc')->get();

        return view('about-us', compact('teams'));
    }
}
