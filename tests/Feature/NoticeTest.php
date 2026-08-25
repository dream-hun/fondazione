<?php

declare(strict_types=1);

use App\Models\Notice;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('announcements index only shows published notices', function (): void {
    $published = Notice::factory()->published()->create(['title' => 'Published Announcement']);
    Notice::factory()->draft()->create(['title' => 'Draft Announcement']);
    Notice::factory()->unpublished()->create(['title' => 'Unpublished Announcement']);

    $this->get(route('notices.index'))
        ->assertSuccessful()
        ->assertSee($published->title)
        ->assertDontSee('Draft Announcement')
        ->assertDontSee('Unpublished Announcement');
});

test('announcements index can search by title', function (): void {
    Notice::factory()->published()->create([
        'title' => 'Water Project Launch',
        'body' => 'Details about the new water initiative.',
    ]);
    Notice::factory()->published()->create([
        'title' => 'Annual Meeting',
        'body' => "Schedule for this year's gathering.",
    ]);

    $this->get(route('notices.index', ['search' => 'Water']))
        ->assertSuccessful()
        ->assertSee('Water Project Launch')
        ->assertDontSee('Annual Meeting');
});

test('announcements index can search by body', function (): void {
    $matching = Notice::factory()->published()->create([
        'title' => 'Community Update',
        'body' => 'The cooperative training begins next month.',
        'excerpt' => 'Training program announcement.',
    ]);
    Notice::factory()->published()->create([
        'title' => 'Other Update',
        'body' => 'Nothing relevant here.',
        'excerpt' => 'General notice for residents.',
    ]);

    $this->get(route('notices.index', ['search' => 'cooperative']))
        ->assertSuccessful()
        ->assertSee($matching->title)
        ->assertDontSee('Other Update');
});

test('announcements index can search by excerpt', function (): void {
    $matching = Notice::factory()->published()->create([
        'title' => 'Scholarship News',
        'excerpt' => 'Applications open for scholarships.',
    ]);

    $this->get(route('notices.index', ['search' => 'Applications open']))
        ->assertSuccessful()
        ->assertSee($matching->title);
});

test('announcement show page renders a published notice by slug', function (): void {
    $notice = Notice::factory()->published()->create(['title' => 'New Office Hours']);

    $this->get(route('notices.show', $notice))
        ->assertSuccessful()
        ->assertSee('New Office Hours');
});
