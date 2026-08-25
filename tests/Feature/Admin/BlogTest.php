<?php

declare(strict_types=1);

use App\Models\Blog;
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

test('admin can view blogs index', function (): void {
    Blog::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.index'))
        ->assertSuccessful()
        ->assertSee('Manage Blogs');
});

test('non-admin cannot view blogs index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.blogs.index'))
        ->assertForbidden();
});

test('guest cannot view blogs index', function (): void {
    $this->get(route('admin.blogs.index'))
        ->assertRedirect(route('login'));
});

test('admin can view create blog page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.blogs.create'))
        ->assertSuccessful();
});

test('admin can create a blog', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.blogs.store'), [
            'title' => 'Test Blog Post',
            'content' => 'Blog post content',
            'excerpt' => 'Short teaser text',
            'author_name' => 'Admin Author',
            'status' => 'draft',
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', 'Blog "Test Blog Post" created successfully.');

    $this->assertDatabaseHas('blogs', [
        'title' => 'Test Blog Post',
        'slug' => 'test-blog-post',
        'status' => 'draft',
    ]);
});

test('published_at is set automatically when publishing without a date', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.blogs.store'), [
            'title' => 'Published Right Away',
            'content' => 'Content',
            'excerpt' => 'Short teaser text',
            'author_name' => 'Admin Author',
            'status' => 'published',
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success');

    $blog = Blog::query()->where('title', 'Published Right Away')->first();
    assert($blog !== null);

    expect($blog->published_at)->not->toBeNull();
});

test('published_at is set automatically when updating to published without a date', function (): void {
    $blog = Blog::factory()->draft()->create();

    $this->actingAs($this->admin)
        ->put(route('admin.blogs.update', $blog), [
            'title' => $blog->title,
            'slug' => $blog->slug,
            'content' => $blog->content,
            'status' => 'published',
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success');

    $blog->refresh();
    expect($blog->published_at)->not->toBeNull();
});

test('admin can create a blog with featured image', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.blogs.store'), [
            'title' => 'Blog With Image',
            'content' => 'Content',
            'excerpt' => 'Short teaser text',
            'author_name' => 'Admin Author',
            'status' => 'draft',
            'featured_image' => UploadedFile::fake()->image('cover.jpg'),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success');

    $blog = Blog::query()->where('title', 'Blog With Image')->first();
    assert($blog !== null);

    expect($blog->featured_image)->toStartWith('blogs/featured-images/');
    Storage::disk('public')->assertExists((string) $blog->featured_image);
});

test('admin cannot create a blog without required fields', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.blogs.store'), [])
        ->assertSessionHasErrors(['title', 'content', 'status']);
});

test('admin cannot create a blog with an invalid status', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.blogs.store'), [
            'title' => 'Bad Status',
            'content' => 'Content',
            'excerpt' => 'Short teaser text',
            'author_name' => 'Admin Author',
            'status' => 'archived',
        ])
        ->assertSessionHasErrors('status');
});

test('admin can view a blog', function (): void {
    $blog = Blog::factory()->create(['title' => 'Showcase Blog']);

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.show', $blog))
        ->assertSuccessful()
        ->assertSee('Showcase Blog');
});

test('admin can view edit blog page', function (): void {
    $blog = Blog::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.edit', $blog))
        ->assertSuccessful()
        ->assertSee($blog->title);
});

test('admin can update a blog', function (): void {
    $blog = Blog::factory()->create(['title' => 'Original Title']);

    $this->actingAs($this->admin)
        ->put(route('admin.blogs.update', $blog), [
            'title' => 'Updated Title',
            'slug' => $blog->slug,
            'excerpt' => $blog->excerpt ?? '',
            'content' => $blog->content,
            'status' => $blog->status,
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('blogs', [
        'id' => $blog->id,
        'title' => 'Updated Title',
    ]);
});

test('updating a blog with a new image deletes the old one', function (): void {
    $oldPath = 'blogs/featured-images/old.jpg';
    Storage::disk('public')->put($oldPath, 'dummy');

    $blog = Blog::factory()->create(['featured_image' => $oldPath]);

    $this->actingAs($this->admin)
        ->put(route('admin.blogs.update', $blog), [
            'title' => $blog->title,
            'slug' => $blog->slug,
            'content' => $blog->content,
            'excerpt' => $blog->excerpt,
            'author_name' => $blog->author_name,
            'status' => $blog->status,
            'featured_image' => UploadedFile::fake()->image('new.jpg'),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success');

    $blog->refresh();

    Storage::disk('public')->assertMissing($oldPath);
    expect($blog->featured_image)->not->toBe($oldPath);
    Storage::disk('public')->assertExists((string) $blog->featured_image);
});

test('admin can delete a blog and its image', function (): void {
    $imagePath = 'blogs/featured-images/delete-me.jpg';
    Storage::disk('public')->put($imagePath, 'dummy');

    $blog = Blog::factory()->create([
        'title' => 'Doomed Blog',
        'featured_image' => $imagePath,
    ]);

    $this->actingAs($this->admin)
        ->delete(route('admin.blogs.destroy', $blog))
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', 'Blog "Doomed Blog" deleted successfully.');

    $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    Storage::disk('public')->assertMissing($imagePath);
});

test('admin can search blogs', function (): void {
    Blog::factory()->create([
        'title' => 'Water Conservation Tips',
        'excerpt' => 'How to save water at home.',
        'content' => 'Tips for reducing water usage.',
        'tags' => 'environment, sustainability',
    ]);
    Blog::factory()->create([
        'title' => 'Mountain Hiking',
        'excerpt' => 'Guide to mountain trails.',
        'content' => 'Best routes for hiking.',
        'tags' => 'outdoors, adventure',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.index', ['search' => 'Water']))
        ->assertSuccessful()
        ->assertSee('Water Conservation Tips')
        ->assertDontSee('Mountain Hiking');
});

test('admin can filter blogs by published status', function (): void {
    Blog::factory()->published()->create(['title' => 'Live Post']);
    Blog::factory()->draft()->create(['title' => 'Hidden Post']);

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.index', ['status' => 'published']))
        ->assertSuccessful()
        ->assertSee('Live Post')
        ->assertDontSee('Hidden Post');
});

test('admin can filter blogs by draft status', function (): void {
    Blog::factory()->published()->create(['title' => 'Live Post']);
    Blog::factory()->draft()->create(['title' => 'Draft Post']);

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.index', ['status' => 'draft']))
        ->assertSuccessful()
        ->assertSee('Draft Post')
        ->assertDontSee('Live Post');
});

test('admin can filter blogs by featured', function (): void {
    Blog::factory()->featured()->create(['title' => 'Featured Post']);
    Blog::factory()->create(['title' => 'Plain Post', 'is_featured' => false]);

    $this->actingAs($this->admin)
        ->get(route('admin.blogs.index', ['featured' => '1']))
        ->assertSuccessful()
        ->assertSee('Featured Post')
        ->assertDontSee('Plain Post');
});

test('admin can sort blogs ascending', function (): void {
    Blog::factory()->create(['title' => 'First Blog']);
    Blog::factory()->create(['title' => 'Second Blog']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.blogs.index', ['sort' => 'created_at', 'direction' => 'asc']));

    $response->assertSuccessful();

    $titles = Blog::query()->orderBy('created_at')->pluck('title');
    expect($titles->first())->toBe('First Blog');
});

test('admin can bulk publish blogs', function (): void {
    $blogs = Blog::factory()->draft()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'publish',
            'selected_blogs' => $blogs->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', '2 blog(s) published successfully.');

    $blogs->each(fn (Blog $blog) => $this->assertDatabaseHas('blogs', [
        'id' => $blog->id,
        'status' => 'published',
    ]));
});

test('admin can bulk unpublish blogs', function (): void {
    $blogs = Blog::factory()->published()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'unpublish',
            'selected_blogs' => $blogs->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', '2 blog(s) unpublished successfully.');

    $this->assertDatabaseHas('blogs', [
        'id' => $blogs[0]->id,
        'status' => 'draft',
    ]);
});

test('admin can bulk feature blogs', function (): void {
    $blogs = Blog::factory()->count(2)->create(['is_featured' => false]);

    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'feature',
            'selected_blogs' => $blogs->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', '2 blog(s) marked as featured.');

    $this->assertDatabaseHas('blogs', [
        'id' => $blogs[0]->id,
        'is_featured' => true,
    ]);
});

test('admin can bulk unfeature blogs', function (): void {
    $blogs = Blog::factory()->featured()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'unfeature',
            'selected_blogs' => $blogs->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', '2 blog(s) removed from featured.');

    $this->assertDatabaseHas('blogs', [
        'id' => $blogs[0]->id,
        'is_featured' => false,
    ]);
});

test('admin can bulk delete blogs along with their images', function (): void {
    $imagePath = 'blogs/featured-images/bulk-delete.jpg';
    Storage::disk('public')->put($imagePath, 'dummy');

    $blogs = Blog::factory()->count(2)->create(['featured_image' => $imagePath]);

    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'delete',
            'selected_blogs' => $blogs->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.blogs.index'))
        ->assertSessionHas('success', '2 blog(s) deleted successfully.');

    $blogs->each(fn (Blog $blog) => $this->assertDatabaseMissing('blogs', ['id' => $blog->id]));
    Storage::disk('public')->assertMissing($imagePath);
});

test('bulk action validates the action value', function (): void {
    $blogs = Blog::factory()->count(1)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'invalid-action',
            'selected_blogs' => $blogs->pluck('id')->toArray(),
        ])
        ->assertSessionHasErrors('action');
});

test('bulk action requires at least one selected blog', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.blogs.bulk-action'), [
            'action' => 'publish',
            'selected_blogs' => [],
        ])
        ->assertSessionHasErrors('selected_blogs');
});
