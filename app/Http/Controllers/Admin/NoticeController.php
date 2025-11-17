<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enum\Notices\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class NoticeController extends Controller
{
    /**
     * Display a listing of notices with search and pagination
     */
    public function index(Request $request): View
    {
        $query = Notice::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->get('status')) {
            $query->where('status', Status::from($status));
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $notices = $query->paginate(15)->withQueryString();

        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new notice
     */
    public function create(): View
    {
        return view('admin.notices.create');
    }

    /**
     * Store a newly created notice
     */
    public function store(StoreNoticeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')
                ->store('notices/attachments', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Notice::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        // Generate UUID if not provided
        if (empty($validated['uuid'])) {
            $validated['uuid'] = (string) Str::uuid();
        }

        $notice = Notice::create($validated);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice "'.$notice->title.'" created successfully.');
    }

    /**
     * Display the specified notice
     */
    public function show(Notice $notice): View
    {
        return view('admin.notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified notice
     */
    public function edit(Notice $notice): View
    {
        return view('admin.notices.edit', compact('notice'));
    }

    /**
     * Update the specified notice
     */
    public function update(UpdateNoticeRequest $request, Notice $notice): RedirectResponse
    {
        $validated = $request->validated();

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
                Storage::disk('public')->delete($notice->attachment);
            }

            $validated['attachment'] = $request->file('attachment')
                ->store('notices/attachments', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure unique slug (excluding current notice)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Notice::where('slug', $validated['slug'])->where('id', '!=', $notice->id)->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        $notice->update($validated);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice "'.$notice->title.'" updated successfully.');
    }

    /**
     * Remove the specified notice
     */
    public function destroy(Notice $notice): RedirectResponse
    {
        $title = $notice->title;

        // Delete attachment if exists
        if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
            Storage::disk('public')->delete($notice->attachment);
        }

        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice "'.$title.'" deleted successfully.');
    }

    /**
     * Handle bulk actions on selected notices
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,publish,unpublish,draft',
            'selected_notices' => 'required|array|min:1',
            'selected_notices.*' => 'exists:notices,id',
        ]);

        $noticeIds = $request->selected_notices;
        $action = $request->action;
        $count = count($noticeIds);

        switch ($action) {
            case 'delete':
                $notices = Notice::whereIn('id', $noticeIds)->get();
                foreach ($notices as $notice) {
                    // Delete attachments
                    if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
                        Storage::disk('public')->delete($notice->attachment);
                    }
                }
                Notice::whereIn('id', $noticeIds)->delete();
                $message = "{$count} notice(s) deleted successfully.";
                break;

            case 'publish':
                Notice::whereIn('id', $noticeIds)->update(['status' => Status::Published]);
                $message = "{$count} notice(s) published successfully.";
                break;

            case 'unpublish':
                Notice::whereIn('id', $noticeIds)->update(['status' => Status::Unpublished]);
                $message = "{$count} notice(s) unpublished successfully.";
                break;

            case 'draft':
                Notice::whereIn('id', $noticeIds)->update(['status' => Status::Draft]);
                $message = "{$count} notice(s) moved to draft.";
                break;
        }

        return redirect()->route('admin.notices.index')->with('success', $message);
    }
}
