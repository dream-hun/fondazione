<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Team;
use Illuminate\Support\Facades\Storage;

final class DeleteTeamAction
{
    /**
     * Execute the action to delete a team member and their associated image
     */
    public function execute(Team $team): void
    {
        // Delete associated image
        if ($team->image && Storage::disk('public')->exists($team->image)) {
            Storage::disk('public')->delete($team->image);
        }

        $team->delete();
    }
}
