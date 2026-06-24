<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final class BulkUserAction
{
    /**
     * @param  list<int|string>  $userIds
     */
    public function execute(string $action, array $userIds, int $actingUserId): string
    {
        return match ($action) {
            'delete' => $this->deleteUsers($userIds, $actingUserId),
            'make_admin' => $this->setAdminStatus($userIds, true, count($userIds)),
            'remove_admin' => $this->removeAdmin($userIds, $actingUserId),
            default => 'Invalid action selected.',
        };
    }

    /**
     * @param  list<int|string>  $userIds
     */
    private function deleteUsers(array $userIds, int $actingUserId): string
    {
        $ids = array_values(array_filter($userIds, fn ($id): bool => (int) $id !== $actingUserId));

        if ($ids === []) {
            return 'You cannot delete yourself.';
        }

        User::query()->whereIn('id', $ids)->delete();

        return count($ids).' user(s) deleted successfully.';
    }

    /**
     * @param  list<int|string>  $userIds
     */
    private function setAdminStatus(array $userIds, bool $isAdmin, int $count): string
    {
        User::query()->whereIn('id', $userIds)->update(['is_admin' => $isAdmin]);

        return $isAdmin
            ? $count.' user(s) granted admin privileges.'
            : $count.' user(s) removed from admin privileges.';
    }

    /**
     * @param  list<int|string>  $userIds
     */
    private function removeAdmin(array $userIds, int $actingUserId): string
    {
        $ids = array_values(array_filter($userIds, fn ($id): bool => (int) $id !== $actingUserId));

        if ($ids === []) {
            return 'You cannot remove admin privileges from yourself.';
        }

        return $this->setAdminStatus($ids, false, count($ids));
    }
}
