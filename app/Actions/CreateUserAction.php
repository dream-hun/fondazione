<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class CreateUserAction
{
    /**
     * Execute the action to create a new user.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): User
    {
        $userData = [
            'name' => is_scalar($data['name'] ?? null) ? (string) $data['name'] : '',
            'email' => is_scalar($data['email'] ?? null) ? (string) $data['email'] : '',
            'password' => Hash::make(is_scalar($data['password'] ?? null) ? (string) $data['password'] : ''),
            'is_admin' => (bool) ($data['is_admin'] ?? false),
        ];

        return User::query()->create($userData);
    }
}
