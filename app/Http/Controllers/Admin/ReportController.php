<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enum\Reports\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::query();

        if ($search = $request->get('search')) {
            $query->search($search);
        }

        if ($status = $request->get('status')) {
            $query->where('status', Status::from($status));
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
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
        $filePath = $request->file('file')->store('reports', 'public');

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

        $reportIds = $request->selected_reports;
        $action = $request->action;
        $count = count($reportIds);

        switch ($action) {
            case 'delete':
                Report::query()->whereIn('id', $reportIds)->each(function (Report $report): void {
                    Storage::disk('public')->delete($report->file_path);
                    $report->delete();
                });
                $message = $count.' report(s) deleted successfully.';
                break;

            case 'publish':
                Report::query()->whereIn('id', $reportIds)->update(['status' => Status::Published]);
                $message = $count.' report(s) published successfully.';
                break;

            case 'unpublish':
                Report::query()->whereIn('id', $reportIds)->update(['status' => Status::Unpublished]);
                $message = $count.' report(s) unpublished successfully.';
                break;

            case 'draft':
                Report::query()->whereIn('id', $reportIds)->update(['status' => Status::Draft]);
                $message = $count.' report(s) moved to draft.';
                break;

            default:
                $message = 'Unknown action.';
        }

        return to_route('admin.reports.index')->with('success', $message);
    }
}
