<?php

declare(strict_types=1);

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Storage::fake('public');

    $this->admin = User::factory()->create([
        'is_admin' => true,
        'email' => 'admin@example.com',
    ]);

    $this->user = User::factory()->create([
        'is_admin' => false,
        'email' => 'user@example.com',
    ]);
});

test('admin can view teams index', function (): void {
    Team::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.teams.index'))
        ->assertSuccessful()
        ->assertSee('Manage Team Members');
});

test('non-admin cannot view teams index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.teams.index'))
        ->assertForbidden();
});

test('guest cannot view teams index', function (): void {
    $this->get(route('admin.teams.index'))
        ->assertRedirect(route('login'));
});

test('admin can view create team page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.teams.create'))
        ->assertSuccessful();
});

test('admin can create a team member with an image', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.teams.store'), [
            'name' => 'Jane Doe',
            'position' => 'Program Lead',
            'email' => 'jane@example.com',
            'image' => UploadedFile::fake()->image('portrait.jpg'),
        ])
        ->assertRedirect(route('admin.teams.index'))
        ->assertSessionHas('success', 'Team member created successfully.');

    $team = Team::query()->where('name', 'Jane Doe')->first();
    assert($team !== null);

    expect($team->uuid)->not->toBeNull()
        ->and($team->image)->toStartWith('teams/');

    Storage::disk('public')->assertExists((string) $team->image);
});

test('creating a team member with save and continue redirects to edit', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.teams.store'), [
            'name' => 'Save Continue',
            'position' => 'Officer',
            'image' => UploadedFile::fake()->image('photo.jpg'),
            'save_and_continue' => true,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $team = Team::query()->where('name', 'Save Continue')->first();
    assert($team !== null);

    expect($this->followingRedirects()->get(route('admin.teams.edit', $team))->content())
        ->toContain('Save Continue');
});

test('image is required when creating a team member', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.teams.store'), [
            'name' => 'No Image',
            'position' => 'Officer',
        ])
        ->assertSessionHasErrors(['image']);
});

test('admin can view a team member', function (): void {
    $team = Team::factory()->create(['name' => 'Visible Member']);

    $this->actingAs($this->admin)
        ->get(route('admin.teams.show', $team))
        ->assertSuccessful()
        ->assertSee('Visible Member');
});

test('admin can view edit team page', function (): void {
    $team = Team::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.teams.edit', $team))
        ->assertSuccessful();
});

test('admin can update a team member', function (): void {
    $team = Team::factory()->create(['name' => 'Before Update']);

    $this->actingAs($this->admin)
        ->put(route('admin.teams.update', $team), [
            'name' => 'After Update',
            'position' => $team->position,
        ])
        ->assertRedirect(route('admin.teams.index'))
        ->assertSessionHas('success', 'Team member updated successfully.');

    $this->assertDatabaseHas('teams', [
        'id' => $team->id,
        'name' => 'After Update',
    ]);
});

test('updating a team member with save and continue redirects to edit', function (): void {
    $team = Team::factory()->create(['name' => 'Before Update']);

    $this->actingAs($this->admin)
        ->put(route('admin.teams.update', $team), [
            'name' => 'After Update',
            'position' => $team->position,
            'save_and_continue' => true,
        ])
        ->assertRedirect(route('admin.teams.edit', $team))
        ->assertSessionHas('success', 'Team member updated successfully.');

    $this->assertDatabaseHas('teams', [
        'id' => $team->id,
        'name' => 'After Update',
    ]);
});

test('updating a team member with a new image deletes the old one', function (): void {
    $oldPath = 'teams/old.jpg';
    Storage::disk('public')->put($oldPath, 'dummy');

    $team = Team::factory()->create(['image' => $oldPath]);

    $this->actingAs($this->admin)
        ->put(route('admin.teams.update', $team), [
            'name' => $team->name,
            'position' => $team->position,
            'image' => UploadedFile::fake()->image('new.jpg'),
        ])
        ->assertRedirect(route('admin.teams.index'));

    $team->refresh();

    Storage::disk('public')->assertMissing($oldPath);
    expect($team->image)->toStartWith('teams/');
    Storage::disk('public')->assertExists((string) $team->image);
});

test('remove image flag clears the stored image', function (): void {
    $imagePath = 'teams/remove-me.jpg';
    Storage::disk('public')->put($imagePath, 'dummy');

    $team = Team::factory()->create(['image' => $imagePath]);

    $this->actingAs($this->admin)
        ->put(route('admin.teams.update', $team), [
            'name' => $team->name,
            'position' => $team->position,
            'remove_image' => '1',
        ])
        ->assertRedirect(route('admin.teams.index'));

    $team->refresh();

    Storage::disk('public')->assertMissing($imagePath);
    expect($team->image)->toBeNull();
});

test('admin can delete a team member and its image', function (): void {
    $imagePath = 'teams/delete-me.jpg';
    Storage::disk('public')->put($imagePath, 'dummy');

    $team = Team::factory()->create(['image' => $imagePath]);

    $this->actingAs($this->admin)
        ->delete(route('admin.teams.destroy', $team))
        ->assertRedirect(route('admin.teams.index'))
        ->assertSessionHas('success', 'Team member deleted successfully.');

    $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    Storage::disk('public')->assertMissing($imagePath);
});

test('deleting a team member without an image succeeds', function (): void {
    $team = Team::factory()->create(['image' => null]);

    $this->actingAs($this->admin)
        ->delete(route('admin.teams.destroy', $team))
        ->assertRedirect(route('admin.teams.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('teams', ['id' => $team->id]);
});

test('admin can search team members', function (): void {
    Team::factory()->create([
        'name' => 'Alice Wonder',
        'position' => 'Engineer',
        'email' => 'alice@example.com',
    ]);
    Team::factory()->create([
        'name' => 'Bob Builder',
        'position' => 'Architect',
        'email' => 'bob@example.com',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.teams.index', ['search' => 'Alice']))
        ->assertSuccessful()
        ->assertSee('Alice Wonder')
        ->assertDontSee('Bob Builder');
});

test('admin can search team members by position', function (): void {
    Team::factory()->create([
        'name' => 'Person One',
        'position' => 'Accountant',
        'email' => 'person1@example.com',
    ]);
    Team::factory()->create([
        'name' => 'Person Two',
        'position' => 'Driver',
        'email' => 'person2@example.com',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.teams.index', ['search' => 'Accountant']))
        ->assertSuccessful()
        ->assertSee('Person One')
        ->assertDontSee('Person Two');
});

test('admin can bulk delete team members', function (): void {
    $imagePath = 'teams/bulk-delete.jpg';
    Storage::disk('public')->put($imagePath, 'dummy');

    $teams = Team::factory()->count(2)->create(['image' => $imagePath]);

    $this->actingAs($this->admin)
        ->post(route('admin.teams.bulk-action'), [
            'action' => 'delete',
            'selected_teams' => $teams->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.teams.index'))
        ->assertSessionHas('success', '2 team member(s) deleted successfully.');

    $teams->each(fn (Team $team) => $this->assertDatabaseMissing('teams', ['id' => $team->id]));
    Storage::disk('public')->assertMissing($imagePath);
});
