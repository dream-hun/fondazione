<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UpdateUserAction
{
    /**
     * Execute the action to update a user.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(User $user, array $data): User
    {
        $userData = [
            'name' => is_scalar($data['name'] ?? null) ? (string) $data['name'] : '',
            'email' => is_scalar($data['email'] ?? null) ? (string) $data['email'] : '',
            'is_admin' => (bool) ($data['is_admin'] ?? false),
        ];

        $password = $data['password'] ?? null;
        if (! empty($password) && is_scalar($password)) {
            $userData['password'] = Hash::make((string) $password);
        }

        $user->update($userData);
        $user->refresh();

        return $user;
    }
}
