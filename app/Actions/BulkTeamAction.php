<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Team;
use Illuminate\Support\Facades\Storage;

final class BulkTeamAction
{
    /**
     * @param  array<mixed>  $teamIds
     */
    public function execute(string $action, array $teamIds): string
    {
        $count = count($teamIds);

        if ($action === 'delete') {
            return $this->deleteTeams($teamIds, $count);
        }

        return 'Invalid action selected.';
    }

    /**
     * @param  array<mixed>  $teamIds
     */
    private function deleteTeams(array $teamIds, int $count): string
    {
        Team::query()->whereIn('id', $teamIds)->each(function (Team $team): void {
            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
            }

            $team->delete();
        });

        return $count.' team member(s) deleted successfully.';
    }
}
