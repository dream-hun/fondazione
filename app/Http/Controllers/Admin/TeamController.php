<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\BulkTeamAction;
use App\Actions\DeleteTeamAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class TeamController extends Controller
{
    /**
     * Display a listing of team members with search and pagination
     */
    public function index(Request $request): View
    {
        $query = Team::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $teams = $query->paginate(15)->withQueryString();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team member
     */
    public function create(): View
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created team member
     */
    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        Team::create($validated);

        $message = 'Team member created successfully.';

        if ($request->has('save_and_continue')) {
            $team = Team::latest()->first();

            return redirect()->route('admin.teams.edit', $team)->with('success', $message);
        }

        return redirect()->route('admin.teams.index')->with('success', $message);
    }

    /**
     * Display the specified team member
     */
    public function show(Team $team): View
    {
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team member
     */
    public function edit(Team $team): View
    {
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified team member
     */
    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $validated = $request->validated();

        // Handle image removal
        if ($request->boolean('remove_image') && $team->image) {
            Storage::disk('public')->delete($team->image);
            $validated['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        // Remove fields that are not in the database
        unset($validated['remove_image']);

        $team->update($validated);

        $message = 'Team member updated successfully.';

        if ($request->has('save_and_continue')) {
            return redirect()->route('admin.teams.edit', $team)->with('success', $message);
        }

        return redirect()->route('admin.teams.index')->with('success', $message);
    }

    /**
     * Remove the specified team member
     */
    public function destroy(Team $team): RedirectResponse
    {
        $action = new DeleteTeamAction();
        $action->execute($team);

        return redirect()->route('admin.teams.index')->with('success', 'Team member deleted successfully.');
    }

    /**
     * Handle bulk actions on team members
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $action = new BulkTeamAction();

        return $action->execute($request);
    }
}
