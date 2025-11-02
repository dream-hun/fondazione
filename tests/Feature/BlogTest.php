<?php

declare(strict_types=1);

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('blog index page displays published blogs', function (): void {
    // Create some published and draft blogs
    $publishedBlogs = Blog::factory()->published()->count(3)->create();
    $draftBlogs = Blog::factory()->draft()->count(2)->create();

    $response = $this->get(route('blog.index'));

    $response->assertStatus(200);

    // Should see published blogs
    foreach ($publishedBlogs as $blog) {
        $response->assertSee($blog->title);
        $response->assertSee($blog->excerpt);
    }

    // Should not see draft blogs
    foreach ($draftBlogs as $blog) {
        $response->assertDontSee($blog->title);
    }
});

test('blog show page displays published blog', function (): void {
    $blog = Blog::factory()->published()->create();

    $response = $this->get(route('blog.show', $blog));

    $response->assertStatus(200);
    $response->assertSee($blog->title);
    $response->assertSee($blog->excerpt);
    $response->assertSee(mb_substr($blog->content, 0, 100)); // Check first 100 characters
    $response->assertSee($blog->author_name);
});

test('blog show page returns 404 for draft blog', function (): void {
    $blog = Blog::factory()->draft()->create();

    $response = $this->get(route('blog.show', $blog));

    $response->assertStatus(404);
});

test('blog search functionality works', function (): void {
    $blog1 = Blog::factory()->published()->create(['title' => 'Laravel Development Tips']);
    $blog2 = Blog::factory()->published()->create(['title' => 'Vue.js Best Practices']);
    $blog3 = Blog::factory()->published()->create(['title' => 'PHP Performance Optimization']);

    $response = $this->get(route('blog.index', ['search' => 'Laravel']));

    $response->assertStatus(200);
    $response->assertSee($blog1->title);
    $response->assertDontSee($blog2->title);
    $response->assertDontSee($blog3->title);
});

test('blog tag filtering works', function (): void {
    $blog1 = Blog::factory()->published()->create(['tags' => 'laravel, php, web development']);
    $blog2 = Blog::factory()->published()->create(['tags' => 'vue, javascript, frontend']);
    $blog3 = Blog::factory()->published()->create(['tags' => 'php, backend, api']);

    $response = $this->get(route('blog.index', ['tag' => 'php']));

    $response->assertStatus(200);
    $response->assertSee($blog1->title);
    $response->assertDontSee($blog2->title);
    $response->assertSee($blog3->title);
});

test('featured blogs are displayed on index page', function (): void {
    $featuredBlog = Blog::factory()->published()->featured()->create();
    $regularBlog = Blog::factory()->published()->create();

    $response = $this->get(route('blog.index'));

    $response->assertStatus(200);
    $response->assertSee('Featured Stories');
    $response->assertSee($featuredBlog->title);
});

test('blog model scopes work correctly', function (): void {
    $publishedBlog = Blog::factory()->published()->create();
    $draftBlog = Blog::factory()->draft()->create();
    $featuredBlog = Blog::factory()->published()->featured()->create();

    expect(Blog::published()->count())->toBe(2);
    expect(Blog::draft()->count())->toBe(1);
    expect(Blog::featured()->count())->toBe(1);
});

test('blog model generates reading time correctly', function (): void {
    $shortContent = str_repeat('word ', 100); // ~100 words
    $longContent = str_repeat('word ', 1000); // ~1000 words

    $shortBlog = Blog::factory()->create(['content' => $shortContent, 'reading_time' => null]);
    $longBlog = Blog::factory()->create(['content' => $longContent, 'reading_time' => null]);

    expect($shortBlog->reading_time)->toBe(1); // Minimum 1 minute
    expect($longBlog->reading_time)->toBe(5); // ~1000 words / 200 words per minute
});
