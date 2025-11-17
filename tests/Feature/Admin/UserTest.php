<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->admin = User::factory()->create([
        'is_admin' => true,
        'email' => 'admin@example.com',
    ]);

    $this->user = User::factory()->create([
        'is_admin' => false,
        'email' => 'user@example.com',
    ]);
});

test('admin can view users index', function (): void {
    User::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.users.index'))
        ->assertSuccessful()
        ->assertSee('Manage Users')
        ->assertSee('New User');
});

test('non-admin cannot view users index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

test('admin can view create user page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.users.create'))
        ->assertSuccessful()
        ->assertSee('Create New User')
        ->assertSee('Name');
});

test('admin can create a user', function (): void {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'is_admin' => false,
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $userData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'is_admin' => false,
    ]);
});

test('admin can create an admin user', function (): void {
    $userData = [
        'name' => 'Admin User',
        'email' => 'adminuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'is_admin' => true,
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $userData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'name' => 'Admin User',
        'email' => 'adminuser@example.com',
        'is_admin' => true,
    ]);
});

test('admin cannot create user without required fields', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'password']);
});

test('admin cannot create user with invalid email', function (): void {
    $userData = [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $userData)
        ->assertSessionHasErrors(['email']);
});

test('admin cannot create user with duplicate email', function (): void {
    User::factory()->create(['email' => 'existing@example.com']);

    $userData = [
        'name' => 'John Doe',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $userData)
        ->assertSessionHasErrors(['email']);
});

test('admin cannot create user with mismatched passwords', function (): void {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different',
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $userData)
        ->assertSessionHasErrors(['password']);
});

test('admin can view edit user page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.users.edit', $user))
        ->assertSuccessful()
        ->assertSee('Edit User')
        ->assertSee($user->name);
});

test('admin can update a user', function (): void {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
        'is_admin' => false,
    ]);

    $updatedData = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'is_admin' => false,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
});

test('admin can update user password', function (): void {
    $user = User::factory()->create();

    $updatedData = [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
        'is_admin' => $user->is_admin,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $user->refresh();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});

test('admin can update user without changing password', function (): void {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $oldPassword = $user->password;

    $updatedData = [
        'name' => 'Updated Name',
        'email' => 'test@example.com',
        'is_admin' => false,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $user->refresh();
    expect($user->password)->toBe($oldPassword);
});

test('admin can grant admin privileges', function (): void {
    $user = User::factory()->create(['is_admin' => false]);

    $updatedData = [
        'name' => $user->name,
        'email' => $user->email,
        'is_admin' => true,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'is_admin' => true,
    ]);
});

test('admin can remove admin privileges', function (): void {
    $user = User::factory()->create(['is_admin' => true]);

    $updatedData = [
        'name' => $user->name,
        'email' => $user->email,
        'is_admin' => false,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'is_admin' => false,
    ]);
});

test('admin cannot update user with duplicate email', function (): void {
    $existingUser = User::factory()->create(['email' => 'existing@example.com']);
    $user = User::factory()->create(['email' => 'testuser@example.com']);

    $updatedData = [
        'name' => $user->name,
        'email' => 'existing@example.com',
        'is_admin' => $user->is_admin,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertSessionHasErrors(['email']);
});

test('admin can delete a user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('admin cannot delete themselves', function (): void {
    $this->actingAs($this->admin)
        ->delete(route('admin.users.destroy', $this->admin))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
});

test('admin can view a user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.users.show', $user))
        ->assertSuccessful()
        ->assertSee($user->name)
        ->assertSee($user->email);
});

test('admin can search users', function (): void {
    User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index', ['search' => 'John']));

    $response->assertSuccessful()
        ->assertSee('John Doe')
        ->assertDontSee('Jane Smith');
});

test('admin can filter users by admin status', function (): void {
    User::factory()->create(['name' => 'Admin User', 'is_admin' => true]);
    User::factory()->create(['name' => 'Regular User', 'is_admin' => false]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index', ['admin' => '1']));

    $response->assertSuccessful()
        ->assertSee('Admin User');
});

test('admin can perform bulk delete action', function (): void {
    $users = User::factory()->count(3)->create();

    $ids = $users->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'delete',
            'selected_users' => $ids,
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    foreach ($users as $user) {
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
});

test('admin cannot delete themselves in bulk action', function (): void {
    $otherUser = User::factory()->create();

    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'delete',
            'selected_users' => [$this->admin->id, $otherUser->id],
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    // Admin should still exist
    $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    // Other user should be deleted
    $this->assertDatabaseMissing('users', ['id' => $otherUser->id]);
});

test('admin can perform bulk make admin action', function (): void {
    $users = User::factory()->count(3)->create(['is_admin' => false]);

    $ids = $users->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'make_admin',
            'selected_users' => $ids,
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    foreach ($users as $user) {
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => true,
        ]);
    }
});

test('admin can perform bulk remove admin action', function (): void {
    $users = User::factory()->count(3)->create(['is_admin' => true]);

    $ids = $users->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'remove_admin',
            'selected_users' => $ids,
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    foreach ($users as $user) {
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => false,
        ]);
    }
});

test('admin cannot remove admin privileges from themselves in bulk action', function (): void {
    $otherAdmin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'remove_admin',
            'selected_users' => [$this->admin->id, $otherAdmin->id],
        ])
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('success');

    // Admin should still be admin
    $this->assertDatabaseHas('users', [
        'id' => $this->admin->id,
        'is_admin' => true,
    ]);
    // Other admin should be removed
    $this->assertDatabaseHas('users', [
        'id' => $otherAdmin->id,
        'is_admin' => false,
    ]);
});

test('bulk action requires valid action', function (): void {
    $user = User::factory()->create();

    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'invalid_action',
            'selected_users' => [$user->id],
        ])
        ->assertSessionHasErrors(['action']);
});

test('bulk action requires at least one selected user', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.users.bulk-action'), [
            'action' => 'delete',
            'selected_users' => [],
        ])
        ->assertSessionHasErrors(['selected_users']);
});

test('validates password is at least 8 characters', function (): void {
    $userData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'short',
        'password_confirmation' => 'short',
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.users.store'), $userData)
        ->assertSessionHasErrors(['password']);
});

test('validates unique email on update', function (): void {
    $existingUser = User::factory()->create(['email' => 'existing2@example.com']);
    $user = User::factory()->create(['email' => 'testuser2@example.com']);

    $updatedData = [
        'name' => $user->name,
        'email' => 'existing2@example.com',
        'is_admin' => $user->is_admin,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertSessionHasErrors(['email']);
});

test('allows updating email to same value for same user', function (): void {
    $user = User::factory()->create(['email' => 'testuser3@example.com']);

    $updatedData = [
        'name' => $user->name,
        'email' => 'testuser3@example.com',
        'is_admin' => $user->is_admin,
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.users.update', $user), $updatedData)
        ->assertRedirect()
        ->assertSessionHas('success');
});
