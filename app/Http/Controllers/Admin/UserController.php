<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\BulkUserAction;
use App\Actions\CreateUserAction;
use App\Actions\DeleteUserAction;
use App\Actions\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class UserController extends Controller
{
    /**
     * Display a listing of users with search and pagination
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Admin filter
        if ($request->get('admin') === '1') {
            $query->where('is_admin', true);
        } elseif ($request->get('admin') === '0') {
            $query->where('is_admin', false);
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request, CreateUserAction $action): RedirectResponse
    {
        $validated = $request->validated();
        $user = $action->execute($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "'.$user->name.'" created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action): RedirectResponse
    {
        $validated = $request->validated();
        $user = $action->execute($user, $validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "'.$user->name.'" updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user, DeleteUserAction $action): RedirectResponse
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $action->execute($user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User "'.$name.'" deleted successfully.');
    }

    /**
     * Handle bulk actions on selected users
     */
    public function bulkAction(Request $request, BulkUserAction $action): RedirectResponse
    {
        return $action->execute($request);
    }
}
