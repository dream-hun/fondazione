<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final class DeleteUserAction
{
    /**
     * Execute the action to delete a user
     */
    public function execute(User $user): void
    {
        $user->delete();
    }
}
