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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($search = $request->string('search')->toString()) {
            $query->where(function (Builder $q) use ($search): void {
                $q->where('name', 'like', sprintf('%%%s%%', $search))
                    ->orWhere('email', 'like', sprintf('%%%s%%', $search));
            });
        }

        if ($request->get('admin') === '1') {
            $query->where('is_admin', true);
        } elseif ($request->get('admin') === '0') {
            $query->where('is_admin', false);
        }

        $sortBy = $request->string('sort', 'created_at')->toString();
        $sortDirection = $request->string('direction', 'desc')->toString() === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', ['users' => $users]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request, CreateUserAction $action): RedirectResponse
    {
        $validated = $request->validated();
        $user = $action->execute($validated);

        return to_route('admin.users.index')
            ->with('success', 'User "'.$user->name.'" created successfully.');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action): RedirectResponse
    {
        $validated = $request->validated();
        $user = $action->execute($user, $validated);

        return to_route('admin.users.index')
            ->with('success', 'User "'.$user->name.'" updated successfully.');
    }

    public function destroy(User $user, DeleteUserAction $action): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return to_route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $action->execute($user);

        return to_route('admin.users.index')
            ->with('success', 'User "'.$name.'" deleted successfully.');
    }

    public function bulkAction(Request $request, BulkUserAction $action): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,make_admin,remove_admin'],
            'selected_users' => ['required', 'array', 'min:1'],
            'selected_users.*' => ['exists:users,id'],
        ]);

        $actingUserId = (int) auth()->id();

        $message = $action->execute(
            $request->string('action')->value(),
            array_values((array) $request->input('selected_users')),
            $actingUserId
        );

        return to_route('admin.users.index')->with('success', $message);
    }
}
