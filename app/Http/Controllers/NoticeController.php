<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\Notices\Status;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class NoticeController extends Controller
{
    public function index(Request $request): View
    {
        $notices = Notice::query()
            ->where('status', Status::Published)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('notices.index', ['notices' => $notices]);
    }

    public function show(Notice $notice): View
    {
        return view('notices.show', ['notice' => $notice]);
    }
}
