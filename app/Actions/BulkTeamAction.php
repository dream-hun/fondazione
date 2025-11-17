<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class BulkTeamAction
{
    /**
     * Execute bulk actions on team members
     */
    public function execute(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete'],
            'selected_teams' => ['required', 'array', 'min:1'],
            'selected_teams.*' => ['exists:teams,id'],
        ]);

        $teamIds = $request->input('selected_teams');
        $action = $request->input('action');
        $count = count($teamIds);

        switch ($action) {
            case 'delete':
                $teams = Team::whereIn('id', $teamIds)->get();

                foreach ($teams as $team) {
                    // Delete associated images
                    if ($team->image && Storage::disk('public')->exists($team->image)) {
                        Storage::disk('public')->delete($team->image);
                    }
                }

                Team::whereIn('id', $teamIds)->delete();
                $message = "{$count} team member(s) deleted successfully.";
                break;

            default:
                $message = 'Invalid action selected.';
        }

        return redirect()->route('admin.teams.index')->with('success', $message);
    }
}
