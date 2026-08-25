<?php

declare(strict_types=1);

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => Hash::make('current-password'),
    ]);
});

test('it creates a new user with a hashed password', function (): void {
    $user = (new CreateNewUser)->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'super-secret-123',
        'password_confirmation' => 'super-secret-123',
    ]);

    expect($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com')
        ->and(Hash::check('super-secret-123', $user->password))->toBeTrue();
});

test('registration fails when the email is already taken', function (): void {
    (new CreateNewUser)->create([
        'name' => 'Impostor',
        'email' => 'jane@example.com',
        'password' => 'super-secret-123',
        'password_confirmation' => 'super-secret-123',
    ]);
})->throws(ValidationException::class);

test('registration fails when the password is not confirmed', function (): void {
    (new CreateNewUser)->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'super-secret-123',
        'password_confirmation' => 'different-value',
    ]);
})->throws(ValidationException::class);

test('registration fails when the password is too short', function (): void {
    (new CreateNewUser)->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'short',
        'password_confirmation' => 'short',
    ]);
})->throws(ValidationException::class);

test('a forgotten password can be reset', function (): void {
    $oldHash = $this->user->password;

    (new ResetUserPassword)->reset($this->user, [
        'password' => 'brand-new-password',
        'password_confirmation' => 'brand-new-password',
    ]);

    expect($this->user->fresh()->password)->not->toBe($oldHash)
        ->and(Hash::check('brand-new-password', $this->user->fresh()->password))->toBeTrue();
});

test('password reset rejects an unconfirmed password', function (): void {
    (new ResetUserPassword)->reset($this->user, [
        'password' => 'brand-new-password',
        'password_confirmation' => 'nope',
    ]);
})->throws(ValidationException::class);

test('the password can be updated with the correct current password', function (): void {
    $this->actingAs($this->user);

    (new UpdateUserPassword)->update($this->user, [
        'current_password' => 'current-password',
        'password' => 'updated-password-1',
        'password_confirmation' => 'updated-password-1',
    ]);

    expect(Hash::check('updated-password-1', $this->user->fresh()->password))->toBeTrue();
});

test('password update rejects a wrong current password into the updatePassword bag', function (): void {
    $this->actingAs($this->user);

    try {
        (new UpdateUserPassword)->update($this->user, [
            'current_password' => 'wrong-password',
            'password' => 'updated-password-1',
            'password_confirmation' => 'updated-password-1',
        ]);

        $this->fail('ValidationException was not thrown.');
    } catch (ValidationException $exception) {
        expect($exception->errorBag)->toBe('updatePassword')
            ->and($exception->errors())->toHaveKey('current_password');
    }
});

test('profile information can be updated', function (): void {
    (new UpdateUserProfileInformation)->update($this->user, [
        'name' => 'Jane Updated',
        'email' => 'jane.updated@example.com',
    ]);

    expect($this->user->fresh()->name)->toBe('Jane Updated')
        ->and($this->user->fresh()->email)->toBe('jane.updated@example.com');
});

test('profile update ignores the current email uniqueness for the same user', function (): void {
    (new UpdateUserProfileInformation)->update($this->user, [
        'name' => 'Jane Same Email',
        'email' => 'jane@example.com',
    ]);

    expect($this->user->fresh()->email)->toBe('jane@example.com')
        ->and($this->user->fresh()->name)->toBe('Jane Same Email');
});

test('profile update rejects an email used by another account', function (): void {
    User::factory()->create(['email' => 'taken@example.com']);

    try {
        (new UpdateUserProfileInformation)->update($this->user, [
            'name' => 'Jane Clash',
            'email' => 'taken@example.com',
        ]);

        $this->fail('ValidationException was not thrown.');
    } catch (ValidationException $exception) {
        expect($exception->errorBag)->toBe('updateProfileInformation')
            ->and($exception->errors())->toHaveKey('email');
    }
});
