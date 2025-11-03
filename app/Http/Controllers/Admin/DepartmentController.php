<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class DepartmentController extends Controller
{
    /**
     * Display a listing of departments with search and pagination
     */
    public function index(Request $request): View
    {
        $query = Department::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        // Status filter
        if ($request->get('status') === 'active') {
            $query->active();
        } elseif ($request->get('status') === 'inactive') {
            $query->inactive();
        }

        // Sort by
        $sortBy = $request->get('sort', 'display_order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $departments = $query->paginate(15)->withQueryString();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department
     */
    public function create(): View
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created department
     */
    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Department::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        $department = Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department "'.$department->name.'" created successfully.');
    }

    /**
     * Display the specified department
     */
    public function show(Department $department): View
    {
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified department
     */
    public function edit(Department $department): View
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified department
     */
    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $validated = $request->validated();

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure unique slug (excluding current department)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Department::where('slug', $validated['slug'])->where('id', '!=', $department->id)->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department "'.$department->name.'" updated successfully.');
    }

    /**
     * Remove the specified department (soft delete)
     */
    public function destroy(Department $department): RedirectResponse
    {
        $name = $department->name;
        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department "'.$name.'" deleted successfully.');
    }

    /**
     * Handle bulk actions on selected departments
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'selected_departments' => 'required|array|min:1',
            'selected_departments.*' => 'exists:departments,id',
        ]);

        $departmentIds = $request->selected_departments;
        $action = $request->action;
        $count = count($departmentIds);

        match ($action) {
            'delete' => $this->bulkDelete($departmentIds, $count),
            'activate' => $this->bulkActivate($departmentIds, $count),
            'deactivate' => $this->bulkDeactivate($departmentIds, $count),
        };

        return redirect()->route('admin.departments.index')->with('success', $this->getBulkActionMessage($action, $count));
    }

    private function bulkDelete(array $departmentIds, int $count): void
    {
        Department::whereIn('id', $departmentIds)->delete();
    }

    private function bulkActivate(array $departmentIds, int $count): void
    {
        Department::whereIn('id', $departmentIds)->update(['is_active' => true]);
    }

    private function bulkDeactivate(array $departmentIds, int $count): void
    {
        Department::whereIn('id', $departmentIds)->update(['is_active' => false]);
    }

    private function getBulkActionMessage(string $action, int $count): string
    {
        return match ($action) {
            'delete' => "{$count} department(s) deleted successfully.",
            'activate' => "{$count} department(s) activated successfully.",
            'deactivate' => "{$count} department(s) deactivated successfully.",
        };
    }
}
