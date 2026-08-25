<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\BulkTeamAction;
use App\Actions\DeleteTeamAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class TeamController extends Controller
{
    public function index(Request $request): View
    {
        $query = Team::query();

        if ($search = $request->string('search')->toString()) {
            $query->where(function (Builder $q) use ($search): void {
                $q->where('name', 'like', sprintf('%%%s%%', $search))
                    ->orWhere('position', 'like', sprintf('%%%s%%', $search))
                    ->orWhere('email', 'like', sprintf('%%%s%%', $search));
            });
        }

        $sortBy = $request->string('sort', 'created_at')->toString();
        $sortDirection = $request->string('direction', 'desc')->toString() === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sortBy, $sortDirection);

        $teams = $query->paginate(15)->withQueryString();

        return view('admin.teams.index', ['teams' => $teams]);
    }

    public function create(): View
    {
        return view('admin.teams.create');
    }

    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        $team = Team::query()->create($validated);

        $message = 'Team member created successfully.';

        if ($request->has('save_and_continue')) {
            return to_route('admin.teams.edit', $team)->with('success', $message);
        }

        return to_route('admin.teams.index')->with('success', $message);
    }

    public function show(Team $team): View
    {
        return view('admin.teams.show', ['team' => $team]);
    }

    public function edit(Team $team): View
    {
        return view('admin.teams.edit', ['team' => $team]);
    }

    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->boolean('remove_image') && $team->image) {
            Storage::disk('public')->delete($team->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }

            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        unset($validated['remove_image']);

        $team->update($validated);

        $message = 'Team member updated successfully.';

        if ($request->has('save_and_continue')) {
            return to_route('admin.teams.edit', $team)->with('success', $message);
        }

        return to_route('admin.teams.index')->with('success', $message);
    }

    public function destroy(Team $team, DeleteTeamAction $action): RedirectResponse
    {
        $action->execute($team);

        return to_route('admin.teams.index')->with('success', 'Team member deleted successfully.');
    }

    public function bulkAction(Request $request, BulkTeamAction $bulkAction): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete'],
            'selected_teams' => ['required', 'array', 'min:1'],
            'selected_teams.*' => ['exists:teams,id'],
        ]);

        $message = $bulkAction->execute(
            $request->string('action')->value(),
            array_values((array) $request->input('selected_teams'))
        );

        return to_route('admin.teams.index')->with('success', $message);
    }
}
