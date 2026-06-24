<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Department::query();

        if ($search = $request->get('search')) {
            $query->search($search);
        }

        if ($request->get('status') === 'active') {
            $query->active();
        } elseif ($request->get('status') === 'inactive') {
            $query->inactive();
        }

        $sortBy = $request->get('sort', 'display_order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $departments = $query->paginate(15)->withQueryString();

        return view('admin.departments.index', ['departments' => $departments]);
    }

    public function create(): View
    {
        return view('admin.departments.create');
    }

    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        $department = Department::query()->create($request->validated());

        return to_route('admin.departments.index')
            ->with('success', 'Department "'.$department->name.'" created successfully.');
    }

    public function show(Department $department): View
    {
        return view('admin.departments.show', ['department' => $department]);
    }

    public function edit(Department $department): View
    {
        return view('admin.departments.edit', ['department' => $department]);
    }

    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());

        return to_route('admin.departments.index')
            ->with('success', 'Department "'.$department->name.'" updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $name = $department->name;
        $department->delete();

        return to_route('admin.departments.index')
            ->with('success', 'Department "'.$name.'" deleted successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,activate,deactivate'],
            'selected_departments' => ['required', 'array', 'min:1'],
            'selected_departments.*' => ['exists:departments,id'],
        ]);

        $departmentIds = $request->input('selected_departments');
        $action = $request->input('action');
        $count = count($departmentIds);

        match ($action) {
            'delete' => Department::query()->whereIn('id', $departmentIds)->delete(),
            'activate' => Department::query()->whereIn('id', $departmentIds)->update(['is_active' => true]),
            'deactivate' => Department::query()->whereIn('id', $departmentIds)->update(['is_active' => false]),
        };

        $message = match ($action) {
            'delete' => $count.' department(s) deleted successfully.',
            'activate' => $count.' department(s) activated successfully.',
            'deactivate' => $count.' department(s) deactivated successfully.',
        };

        return to_route('admin.departments.index')->with('success', $message);
    }
}
