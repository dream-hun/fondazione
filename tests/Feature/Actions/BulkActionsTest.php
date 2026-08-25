<?php

declare(strict_types=1);

use App\Actions\BulkTeamAction;
use App\Actions\BulkUserAction;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Pest\Mixins\Expectation;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Storage::fake('public');
});

test('bulk team action deletes members along with their images', function (): void {
    $imagePath = 'teams/bulk.jpg';
    Storage::disk('public')->put($imagePath, 'dummy');

    $teams = Team::factory()->count(3)->create(['image' => $imagePath]);

    $message = (new BulkTeamAction)->execute('delete', $teams->pluck('id')->toArray());

    expect($message)->toBe('3 team member(s) deleted successfully.');

    $teams->each(fn (Team $team) => $this->assertDatabaseMissing('teams', ['id' => $team->id]));
    Storage::disk('public')->assertMissing($imagePath);
});

test('bulk team action rejects unknown actions', function (): void {
    $teams = Team::factory()->count(2)->create();

    $message = (new BulkTeamAction)->execute('publish', $teams->pluck('id')->toArray());

    expect($message)->toBe('Invalid action selected.');
    expect(Team::query()->count())->toBe(2);
});

test('bulk user action deletes users other than the actor', function (): void {
    $actor = User::factory()->create();
    $targets = User::factory()->count(2)->create();

    $message = (new BulkUserAction)->execute('delete', $targets->pluck('id')->toArray(), $actor->id);

    expect($message)->toBe('2 user(s) deleted successfully.')
        ->and(User::query()->whereKey($actor->id)->exists())->toBeTrue()
        ->and(User::query()->whereKey($targets[0]->id)->exists())->toBeFalse();
});

test('bulk user action refuses to delete the acting user', function (): void {
    $actor = User::factory()->create();

    $message = (new BulkUserAction)->execute('delete', [$actor->id], $actor->id);

    expect($message)->toBe('You cannot delete yourself.')
        ->and(User::query()->whereKey($actor->id)->exists())->toBeTrue();
});

test('bulk user action grants admin privileges', function (): void {
    $users = User::factory()->count(2)->create(['is_admin' => false]);

    $message = (new BulkUserAction)->execute('make_admin', $users->pluck('id')->toArray(), 999);

    expect($message)->toBe('2 user(s) granted admin privileges.');

    $users->each(fn (User $user): Expectation => expect($user->fresh()->is_admin)->toBeTrue());
});

test('bulk user action removes admin privileges from others', function (): void {
    $actor = User::factory()->create(['is_admin' => true]);
    $other = User::factory()->create(['is_admin' => true]);

    $message = (new BulkUserAction)->execute('remove_admin', [$other->id], $actor->id);

    expect($message)->toBe('1 user(s) removed from admin privileges.')
        ->and($other->fresh()->is_admin)->toBeFalse()
        ->and($actor->fresh()->is_admin)->toBeTrue();
});

test('bulk user action refuses to remove own admin privileges', function (): void {
    $actor = User::factory()->create(['is_admin' => true]);

    $message = (new BulkUserAction)->execute('remove_admin', [$actor->id], $actor->id);

    expect($message)->toBe('You cannot remove admin privileges from yourself.')
        ->and($actor->fresh()->is_admin)->toBeTrue();
});

test('bulk user action rejects unknown actions', function (): void {
    $user = User::factory()->create();

    $message = (new BulkUserAction)->execute('promote', [$user->id], $user->id);

    expect($message)->toBe('Invalid action selected.');
});
