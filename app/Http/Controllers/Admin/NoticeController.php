<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enum\Notices\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;
use App\Models\Notice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class NoticeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Notice::query();

        if ($search = $request->string('search')->toString()) {
            $query->where(function (Builder $q) use ($search): void {
                $q->where('title', 'like', sprintf('%%%s%%', $search))
                    ->orWhere('body', 'like', sprintf('%%%s%%', $search));
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', Status::from($status));
        }

        $sortBy = $request->string('sort', 'created_at')->toString();
        $sortDirection = $request->string('direction', 'desc')->toString() === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $notices = $query->paginate(15)->withQueryString();

        return view('admin.notices.index', ['notices' => $notices]);
    }

    public function create(): View
    {
        return view('admin.notices.create');
    }

    public function store(StoreNoticeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')
                ->store('notices/attachments', 'public');
        }

        $notice = Notice::query()->create($validated);

        return to_route('admin.notices.index')
            ->with('success', 'Notice "'.$notice->title.'" created successfully.');
    }

    public function show(Notice $notice): View
    {
        return view('admin.notices.show', ['notice' => $notice]);
    }

    public function edit(Notice $notice): View
    {
        return view('admin.notices.edit', ['notice' => $notice]);
    }

    public function update(UpdateNoticeRequest $request, Notice $notice): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('attachment')) {
            if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
                Storage::disk('public')->delete($notice->attachment);
            }

            $validated['attachment'] = $request->file('attachment')
                ->store('notices/attachments', 'public');
        }

        $notice->update($validated);

        return to_route('admin.notices.index')
            ->with('success', 'Notice "'.$notice->title.'" updated successfully.');
    }

    public function destroy(Notice $notice): RedirectResponse
    {
        $title = $notice->title;

        if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
            Storage::disk('public')->delete($notice->attachment);
        }

        $notice->delete();

        return to_route('admin.notices.index')
            ->with('success', 'Notice "'.$title.'" deleted successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,publish,unpublish,draft'],
            'selected_notices' => ['required', 'array', 'min:1'],
            'selected_notices.*' => ['exists:notices,id'],
        ]);

        /** @var list<int|string> $noticeIds */
        $noticeIds = (array) $request->input('selected_notices');
        $action = $request->string('action')->value();
        $count = count($noticeIds);

        $message = match ($action) {
            'delete' => $this->bulkDelete($noticeIds, $count),
            'publish' => $this->bulkUpdateStatus($noticeIds, Status::Published, $count, 'published'),
            'unpublish' => $this->bulkUpdateStatus($noticeIds, Status::Unpublished, $count, 'unpublished'),
            default => $this->bulkUpdateStatus($noticeIds, Status::Draft, $count, 'moved to draft'),
        };

        return to_route('admin.notices.index')->with('success', $message);
    }

    /** @param list<int|string> $noticeIds */
    private function bulkDelete(array $noticeIds, int $count): string
    {
        Notice::query()->whereIn('id', $noticeIds)->each(function (Notice $notice): void {
            if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
                Storage::disk('public')->delete($notice->attachment);
            }

            $notice->delete();
        });

        return $count.' notice(s) deleted successfully.';
    }

    /** @param list<int|string> $noticeIds */
    private function bulkUpdateStatus(array $noticeIds, Status $status, int $count, string $verb): string
    {
        Notice::query()->whereIn('id', $noticeIds)->update(['status' => $status]);

        return $count.' notice(s) '.$verb.' successfully.';
    }
}
