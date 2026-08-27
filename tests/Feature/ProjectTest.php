<?php

declare(strict_types=1);

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('projects index page displays published projects', function (): void {
    Project::factory()->published()->create(['title' => 'Published Project']);
    Project::factory()->draft()->create(['title' => 'Draft Project']);

    $response = $this->get(route('projects.index'));

    $response->assertStatus(200)
        ->assertSee('Published Project')
        ->assertDontSee('Draft Project');
});

test('project show page displays project details', function (): void {
    $project = Project::factory()->published()->create([
        'title' => 'Test Project',
        'description' => 'Test Description',
        'content' => 'Test Content',
        'location' => 'Test Location',
        'beneficiaries_count' => 100,
        'budget' => 5000.00,
    ]);

    $response = $this->get(route('projects.show', $project));

    $response->assertStatus(200)
        ->assertSee('Test Project')
        ->assertSee('Test Description')
        ->assertSee('Test Content')
        ->assertSee('Test Location')
        ->assertSee('100')
        ->assertSee('$5,000');
});

test('project show page returns 404 for draft projects', function (): void {
    $project = Project::factory()->draft()->create();

    $response = $this->get(route('projects.show', $project));

    $response->assertStatus(404);
});

test('projects can be filtered by search term', function (): void {
    Project::factory()->published()->create([
        'title' => 'Water Project',
        'description' => 'Clean water access for communities.',
        'content' => 'Project details about water supply.',
        'location' => 'Kigali, Rwanda',
    ]);
    Project::factory()->published()->create([
        'title' => 'Education Initiative',
        'description' => 'School construction program.',
        'content' => 'Project details about education.',
        'location' => 'Nairobi, Kenya',
    ]);

    $response = $this->get(route('projects.index', ['search' => 'Water']));

    $response->assertStatus(200)
        ->assertSee('Water Project');
});

test('projects can be filtered by location', function (): void {
    Project::factory()->published()->create(['location' => 'Kigali, Rwanda']);
    Project::factory()->published()->create(['location' => 'Nairobi, Kenya']);

    $response = $this->get(route('projects.index', ['location' => 'Kigali']));

    $response->assertStatus(200)
        ->assertSee('Kigali, Rwanda')
        ->assertDontSee('Nairobi, Kenya');
});

test('project show page displays related projects from the same category', function (): void {
    $project = Project::factory()->published()->cdsp()->create();
    Project::factory()->published()->cdsp()->create(['title' => 'Related Project']);

    $response = $this->get(route('projects.show', $project));

    $response->assertStatus(200)
        ->assertSee('Related Projects')
        ->assertSee('Related Project')
        ->assertDontSee('Unrelated Project');
});

test('featured projects are marked appropriately', function (): void {
    Project::factory()->featured()->create(['title' => 'Featured Project']);

    $response = $this->get(route('projects.index'));

    $response->assertStatus(200)
        ->assertSee('Featured Project');
});

test('project model scopes work correctly', function (): void {
    Project::factory()->published()->create(['is_featured' => false]);
    Project::factory()->draft()->create(['is_featured' => false]);
    Project::factory()->archived()->create(['is_featured' => false]);
    Project::factory()->featured()->create();

    expect(Project::query()->published()->count())->toBe(2)
        ->and(Project::query()->draft()->count())->toBe(1)
        ->and(Project::query()->archived()->count())->toBe(1)
        ->and(Project::query()->featured()->count())->toBe(1); // published + featured
});

test('project search scope works correctly', function (): void {
    Project::factory()->create(['title' => 'Water Project', 'description' => 'Clean water initiative']);
    Project::factory()->create(['title' => 'Education Program', 'content' => 'Teaching children']);

    $results = Project::query()->search('water')->get();
    expect($results)->toHaveCount(1);
    $firstResult = $results->first();
    assert($firstResult !== null);
    expect($firstResult->title)->toBe('Water Project');
});

test('project image URL helpers work correctly', function (): void {
    // Test with storage path
    $project = Project::factory()->create([
        'featured_image' => 'projects/featured/test.jpg',
        'gallery_images' => ['projects/gallery/test1.jpg', 'projects/gallery/test2.jpg'],
    ]);

    expect($project->featured_image_url)->toBe(asset('storage/projects/featured/test.jpg'))
        ->and($project->gallery_image_urls)->toBe([
            asset('storage/projects/gallery/test1.jpg'),
            asset('storage/projects/gallery/test2.jpg'),
        ]);

    // Test with HTTP URL (from factory)
    $projectWithUrl = Project::factory()->create([
        'featured_image' => 'https://example.com/image.jpg',
        'gallery_images' => ['https://example.com/gallery1.jpg'],
    ]);

    expect($projectWithUrl->featured_image_url)->toBe('https://example.com/image.jpg')
        ->and($projectWithUrl->gallery_image_urls)->toBe(['https://example.com/gallery1.jpg']);

    // Test with null values
    $projectWithoutImages = Project::factory()->create([
        'featured_image' => null,
        'gallery_images' => null,
    ]);

    expect($projectWithoutImages->featured_image_url)->toBeNull()
        ->and($projectWithoutImages->gallery_image_urls)->toBe([]);
});
