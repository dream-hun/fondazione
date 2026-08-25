<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a failed login attempt runs the login rate limiter', function (): void {
    $user = User::factory()->create([
        'email' => 'throttled@example.com',
        'password' => Illuminate\Support\Facades\Hash::make('correct-password'),
    ]);

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');
});

test('the two factor rate limiter is registered', function (): void {
    expect(Illuminate\Support\Facades\RateLimiter::limiter('two-factor'))->not->toBeNull()
        ->and(Illuminate\Support\Facades\RateLimiter::limiter('login'))->not->toBeNull();
});
