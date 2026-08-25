<?php

declare(strict_types=1);

use App\Models\Notice;
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

test('admin can view notices index', function (): void {
    Notice::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.notices.index'))
        ->assertSuccessful()
        ->assertSee('Manage Notices');
});

test('non-admin cannot view notices index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.notices.index'))
        ->assertForbidden();
});

test('guest cannot view notices index', function (): void {
    $this->get(route('admin.notices.index'))
        ->assertRedirect(route('login'));
});

test('admin can view create notice page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.notices.create'))
        ->assertSuccessful();
});

test('admin can create a notice', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.notices.store'), [
            'title' => 'Important Notice',
            'body' => 'Notice body content',
            'status' => 'Published',
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', 'Notice "Important Notice" created successfully.');

    $notice = Notice::query()->where('title', 'Important Notice')->first();
    assert($notice !== null);

    expect($notice->slug)->toBe('important-notice')
        ->and($notice->uuid)->not->toBeNull();
});

test('admin can create a notice with an attachment', function (): void {
    $file = UploadedFile::fake()->create('circular.pdf', 300, 'application/pdf');

    $this->actingAs($this->admin)
        ->post(route('admin.notices.store'), [
            'title' => 'Notice With File',
            'body' => 'Body',
            'status' => 'Published',
            'attachment' => $file,
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success');

    $notice = Notice::query()->where('title', 'Notice With File')->first();
    assert($notice !== null);

    expect($notice->hasAttachment())->toBeTrue();
    Storage::disk('public')->assertExists((string) $notice->attachment);
});

test('admin cannot create a notice without required fields', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.notices.store'), [])
        ->assertSessionHasErrors(['title', 'body', 'status']);
});

test('admin cannot create a notice with an invalid status', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.notices.store'), [
            'title' => 'Bad Status',
            'body' => 'Body',
            'status' => 'archived',
        ])
        ->assertSessionHasErrors('status');
});

test('admin cannot upload an attachment with a disallowed type', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.notices.store'), [
            'title' => 'Bad Attachment',
            'body' => 'Body',
            'status' => 'Published',
            'attachment' => UploadedFile::fake()->create('virus.exe', 100),
        ])
        ->assertSessionHasErrors('attachment');
});

test('admin can view a notice', function (): void {
    $notice = Notice::factory()->create(['title' => 'Visible Notice']);

    $this->actingAs($this->admin)
        ->get(route('admin.notices.show', $notice))
        ->assertSuccessful()
        ->assertSee('Visible Notice');
});

test('admin can view edit notice page', function (): void {
    $notice = Notice::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.notices.edit', $notice))
        ->assertSuccessful()
        ->assertSee($notice->title);
});

test('admin can update a notice', function (): void {
    $notice = Notice::factory()->draft()->create(['title' => 'Old Title']);

    $this->actingAs($this->admin)
        ->put(route('admin.notices.update', $notice), [
            'title' => 'New Title',
            'slug' => $notice->slug,
            'body' => $notice->body,
            'status' => 'Published',
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', 'Notice "New Title" updated successfully.');

    $this->assertDatabaseHas('notices', [
        'id' => $notice->id,
        'title' => 'New Title',
        'status' => 'Published',
    ]);
});

test('updating a notice with a new attachment deletes the old one', function (): void {
    $oldPath = 'notices/attachments/old.pdf';
    Storage::disk('public')->put($oldPath, 'dummy');

    $notice = Notice::factory()->create(['attachment' => $oldPath]);

    $this->actingAs($this->admin)
        ->put(route('admin.notices.update', $notice), [
            'title' => $notice->title,
            'slug' => $notice->slug,
            'body' => $notice->body,
            /** @phpstan-ignore property.nonObject */
            'status' => $notice->status->value,
            'attachment' => UploadedFile::fake()->create('new.pdf', 100, 'application/pdf'),
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success');

    $notice->refresh();

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists((string) $notice->attachment);
});

test('admin can delete a notice and its attachment', function (): void {
    $attachmentPath = 'notices/attachments/gone.pdf';
    Storage::disk('public')->put($attachmentPath, 'dummy');

    $notice = Notice::factory()->create([
        'title' => 'Doomed Notice',
        'attachment' => $attachmentPath,
    ]);

    $this->actingAs($this->admin)
        ->delete(route('admin.notices.destroy', $notice))
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', 'Notice "Doomed Notice" deleted successfully.');

    $this->assertDatabaseMissing('notices', ['id' => $notice->id]);
    Storage::disk('public')->assertMissing($attachmentPath);
});

test('admin can search notices', function (): void {
    Notice::factory()->published()->create([
        'title' => 'Water Advisory',
        'body' => 'Important water notice for residents.',
    ]);
    Notice::factory()->published()->create([
        'title' => 'Road Closure',
        'body' => 'Road repair scheduled this weekend.',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.notices.index', ['search' => 'Water']))
        ->assertSuccessful()
        ->assertSee('Water Advisory')
        ->assertDontSee('Road Closure');
});

test('admin can filter notices by status', function (): void {
    Notice::factory()->published()->create(['title' => 'Live Notice']);
    Notice::factory()->draft()->create(['title' => 'Draft Notice']);

    $this->actingAs($this->admin)
        ->get(route('admin.notices.index', ['status' => 'Draft']))
        ->assertSuccessful()
        ->assertSee('Draft Notice')
        ->assertDontSee('Live Notice');
});

test('admin can bulk publish notices', function (): void {
    $notices = Notice::factory()->draft()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.notices.bulk-action'), [
            'action' => 'publish',
            'selected_notices' => $notices->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', '2 notice(s) published successfully.');

    $first = $notices->first();
    assert($first !== null);

    $this->assertDatabaseHas('notices', [
        'id' => $first->id,
        'status' => 'Published',
    ]);
});

test('admin can bulk unpublish notices', function (): void {
    $notices = Notice::factory()->published()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.notices.bulk-action'), [
            'action' => 'unpublish',
            'selected_notices' => $notices->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', '2 notice(s) unpublished successfully.');

    $first = $notices->first();
    assert($first !== null);

    $this->assertDatabaseHas('notices', [
        'id' => $first->id,
        'status' => 'Unpublished',
    ]);
});

test('admin can bulk move notices to draft', function (): void {
    $notices = Notice::factory()->published()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.notices.bulk-action'), [
            'action' => 'draft',
            'selected_notices' => $notices->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', '2 notice(s) moved to draft successfully.');

    $first = $notices->first();
    assert($first !== null);

    $this->assertDatabaseHas('notices', [
        'id' => $first->id,
        'status' => 'Draft',
    ]);
});

test('admin can bulk delete notices along with attachments', function (): void {
    $attachmentPath = 'notices/attachments/bulk-gone.pdf';
    Storage::disk('public')->put($attachmentPath, 'dummy');

    $notices = Notice::factory()->count(2)->create(['attachment' => $attachmentPath]);

    $this->actingAs($this->admin)
        ->post(route('admin.notices.bulk-action'), [
            'action' => 'delete',
            'selected_notices' => $notices->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.notices.index'))
        ->assertSessionHas('success', '2 notice(s) deleted successfully.');

    $notices->each(fn (Notice $notice) => $this->assertDatabaseMissing('notices', ['id' => $notice->id]));
    Storage::disk('public')->assertMissing($attachmentPath);
});
