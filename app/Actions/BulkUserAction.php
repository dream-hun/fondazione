<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class BulkUserAction
{
    /**
     * Execute bulk actions on users
     */
    public function execute(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:delete,make_admin,remove_admin'],
            'selected_users' => ['required', 'array', 'min:1'],
            'selected_users.*' => ['exists:users,id'],
        ]);

        $userIds = $request->input('selected_users');
        $action = $request->input('action');
        $count = count($userIds);

        switch ($action) {
            case 'delete':
                // Prevent deleting yourself
                $userIds = array_filter($userIds, fn ($id) => (int) $id !== auth()->id());
                User::whereIn('id', $userIds)->delete();
                $message = count($userIds) > 0
                    ? count($userIds).' user(s) deleted successfully.'
                    : 'You cannot delete yourself.';
                break;

            case 'make_admin':
                User::whereIn('id', $userIds)->update(['is_admin' => true]);
                $message = "{$count} user(s) granted admin privileges.";
                break;

            case 'remove_admin':
                // Prevent removing admin from yourself
                $userIds = array_filter($userIds, fn ($id) => (int) $id !== auth()->id());
                User::whereIn('id', $userIds)->update(['is_admin' => false]);
                $message = count($userIds) > 0
                    ? count($userIds).' user(s) removed from admin privileges.'
                    : 'You cannot remove admin privileges from yourself.';
                break;

            default:
                $message = 'Invalid action selected.';
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}
