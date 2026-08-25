<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enum\Notices\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::query();

        if ($search = $request->string('search')->toString()) {
            $query->search($search);
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', Status::from($status));
        }

        $sortBy = $request->string('sort', 'created_at')->toString();
        $sortDirection = $request->string('direction', 'desc')->toString() === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $reports = $query->paginate(15)->withQueryString();

        return view('admin.reports.index', ['reports' => $reports]);
    }

    public function create(): View
    {
        return view('admin.reports.create');
    }

    public function store(StoreReportRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        assert($file instanceof UploadedFile);
        $filePath = $file->store('reports', 'public');

        $report = Report::query()->create([
            'title' => $request->validated()['title'],
            'file_path' => $filePath,
            'status' => $request->validated()['status'],
        ]);

        return to_route('admin.reports.index')
            ->with('success', 'Report "'.$report->title.'" created successfully.');
    }

    public function show(Report $report): View
    {
        return view('admin.reports.show', ['report' => $report]);
    }

    public function edit(Report $report): View
    {
        return view('admin.reports.edit', ['report' => $report]);
    }

    public function update(UpdateReportRequest $request, Report $report): RedirectResponse
    {
        $data = [
            'title' => $request->validated()['title'],
            'status' => $request->validated()['status'],
        ];

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($report->file_path);
            $data['file_path'] = $request->file('file')->store('reports', 'public');
        }

        $report->update($data);

        return to_route('admin.reports.index')
            ->with('success', 'Report "'.$report->title.'" updated successfully.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        $title = $report->title;
        Storage::disk('public')->delete($report->file_path);
        $report->delete();

        return to_route('admin.reports.index')
            ->with('success', 'Report "'.$title.'" deleted successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,publish,unpublish,draft'],
            'selected_reports' => ['required', 'array', 'min:1'],
            'selected_reports.*' => ['exists:reports,id'],
        ]);

        /** @var list<int|string> $reportIds */
        $reportIds = (array) $request->input('selected_reports');
        $action = $request->string('action')->value();
        $count = count($reportIds);

        $message = match ($action) {
            'delete' => $this->bulkDelete($reportIds, $count),
            'publish' => Report::query()->whereIn('id', $reportIds)->update(['status' => Status::Published])
                ? $count.' report(s) published successfully.'
                : '0 report(s) published successfully.',
            'unpublish' => Report::query()->whereIn('id', $reportIds)->update(['status' => Status::Unpublished])
                ? $count.' report(s) unpublished successfully.'
                : '0 report(s) unpublished successfully.',
            'draft' => Report::query()->whereIn('id', $reportIds)->update(['status' => Status::Draft])
                ? $count.' report(s) moved to draft.'
                : '0 report(s) moved to draft.',
            default => '',
        };

        return to_route('admin.reports.index')->with('success', $message);
    }

    /** @param list<int|string> $reportIds */
    private function bulkDelete(array $reportIds, int $count): string
    {
        Report::query()->whereIn('id', $reportIds)->each(function (Report $report): void {
            Storage::disk('public')->delete($report->file_path);
            $report->delete();
        });

        return $count.' report(s) deleted successfully.';
    }
}
