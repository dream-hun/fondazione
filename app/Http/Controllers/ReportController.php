<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\View\View;

final class ReportController extends Controller
{
    public function __invoke(): View
    {
        $reports = Report::query()
            ->published()
            ->orderByDesc('created_at')
            ->get();

        return view('reports.index', ['reports' => $reports]);
    }
}
