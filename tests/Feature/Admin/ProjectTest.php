<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

test('admin can view projects index', function (): void {
    Project::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.projects.index'))
        ->assertSuccessful()
        ->assertSee('Projects')
        ->assertSee('Create');
});

test('non-admin cannot view projects index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.projects.index'))
        ->assertForbidden();
});

test('admin can view create project page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.projects.create'))
        ->assertSuccessful()
        ->assertSee('Create New Project')
        ->assertSee('Project Title');
});

test('admin can create a project', function (): void {
    $projectData = [
        'title' => 'Test Project',
        'description' => 'Test Description',
        'content' => 'Test Content',
        'status' => 'published',
        'location' => 'Kigali, Rwanda',
        'beneficiaries_count' => 100,
        'budget' => 10000.00,
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), $projectData)
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'title' => 'Test Project',
        'location' => 'Kigali, Rwanda',
    ]);
});

test('admin can create a project with save and continue', function (): void {
    $projectData = [
        'title' => 'Test Project',
        'description' => 'Test Description',
        'content' => 'Test Content',
        'status' => 'published',
    ];

    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), array_merge($projectData, ['save_and_continue' => true]))
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', ['title' => 'Test Project']);
});

test('admin cannot create project without required fields', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [])
        ->assertSessionHasErrors(['title', 'description', 'content', 'status']);
});

test('admin can view edit project page', function (): void {
    $project = Project::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.projects.edit', $project))
        ->assertSuccessful()
        ->assertSee('Edit Project')
        ->assertSee($project->title);
});

test('admin can update a project', function (): void {
    $project = Project::factory()->create([
        'title' => 'Original Title',
        'status' => 'draft',
    ]);

    $updatedData = [
        'title' => 'Updated Title',
        'description' => $project->description,
        'content' => $project->content,
        'status' => 'published',
    ];

    $this->actingAs($this->admin)
        ->patch(route('admin.projects.update', $project), $updatedData)
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Updated Title',
        'status' => 'published',
    ]);
});

test('admin can update project with save and continue', function (): void {
    $project = Project::factory()->create();

    $this->actingAs($this->admin)
        ->patch(route('admin.projects.update', $project), [
            'title' => $project->title,
            'description' => $project->description,
            'content' => $project->content,
            'status' => 'published',
            'save_and_continue' => true,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
});

test('admin can delete a project', function (): void {
    $project = Project::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.projects.destroy', $project))
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});

test('admin can view a project', function (): void {
    $project = Project::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.projects.show', $project))
        ->assertSuccessful()
        ->assertSee($project->title);
});

test('admin can search projects', function (): void {
    Project::factory()->create(['title' => 'Water Project']);
    Project::factory()->create(['title' => 'Education Project']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.projects.index', ['search' => 'Water']));

    $response->assertSuccessful()
        ->assertSee('Water Project')
        ->assertDontSee('Education Project');
});

test('admin can filter projects by status', function (): void {
    Project::factory()->published()->create(['title' => 'Published Project']);
    Project::factory()->draft()->create(['title' => 'Draft Project']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.projects.index', ['status' => 'published']));

    $response->assertSuccessful()
        ->assertSee('Published Project')
        ->assertDontSee('Draft Project');
});

test('admin can filter projects by featured', function (): void {
    Project::factory()->featured()->create(['title' => 'Featured Project']);
    Project::factory()->create(['title' => 'Regular Project']);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.projects.index', ['featured' => '1']));

    $response->assertSuccessful()
        ->assertSee('Featured Project')
        ->assertDontSee('Regular Project');
});

test('admin can perform bulk publish action', function (): void {
    $projects = Project::factory()->draft()->count(3)->create();

    $ids = $projects->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.projects.bulk-action'), [
            'action' => 'publish',
            'selected_projects' => $ids,
        ])
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('projects', [
        'id' => $ids[0],
        'status' => 'draft',
    ]);
});

test('admin can perform bulk unpublish action', function (): void {
    $projects = Project::factory()->published()->count(3)->create();

    $ids = $projects->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.projects.bulk-action'), [
            'action' => 'unpublish',
            'selected_projects' => $ids,
        ])
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'id' => $ids[0],
        'status' => 'draft',
    ]);
});

test('admin can perform bulk archive action', function (): void {
    $projects = Project::factory()->published()->count(3)->create();

    $ids = $projects->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.projects.bulk-action'), [
            'action' => 'archive',
            'selected_projects' => $ids,
        ])
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'id' => $ids[0],
        'status' => 'archived',
    ]);
});

test('admin can perform bulk feature action', function (): void {
    $projects = Project::factory()->count(3)->create(['is_featured' => false]);

    $ids = $projects->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.projects.bulk-action'), [
            'action' => 'feature',
            'selected_projects' => $ids,
        ])
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'id' => $ids[0],
        'is_featured' => true,
    ]);
});

test('admin can perform bulk unfeature action', function (): void {
    $projects = Project::factory()->featured()->count(3)->create();

    $ids = $projects->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.projects.bulk-action'), [
            'action' => 'unfeature',
            'selected_projects' => $ids,
        ])
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'id' => $ids[0],
        'is_featured' => false,
    ]);
});

test('admin can perform bulk delete action', function (): void {
    $projects = Project::factory()->count(3)->create();

    $ids = $projects->pluck('id')->toArray();

    $this->actingAs($this->admin)
        ->post(route('admin.projects.bulk-action'), [
            'action' => 'delete',
            'selected_projects' => $ids,
        ])
        ->assertRedirect(route('admin.projects.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('projects', ['id' => $ids[0]]);
});

test('project slug is auto-generated from title if not provided', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [
            'title' => 'My Test Project',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'status' => 'published',
        ]);

    $this->assertDatabaseHas('projects', [
        'title' => 'My Test Project',
        'slug' => 'my-test-project',
    ]);
});

test('project slug is unique when auto-generated', function (): void {
    Project::factory()->create(['title' => 'Test Project', 'slug' => 'test-project']);

    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'status' => 'published',
        ]);

    $this->assertDatabaseHas('projects', [
        'title' => 'Test Project',
        'slug' => 'test-project-1',
    ]);
});

test('validates end_date is after start_date', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'status' => 'published',
            'start_date' => '2024-12-31',
            'end_date' => '2024-01-01',
        ])
        ->assertSessionHasErrors('end_date');
});

test('validates budget is non-negative', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'status' => 'published',
            'budget' => -100,
        ])
        ->assertSessionHasErrors('budget');
});

test('validates beneficiaries_count is non-negative', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'status' => 'published',
            'beneficiaries_count' => -10,
        ])
        ->assertSessionHasErrors('beneficiaries_count');
});

test('validates unique slug', function (): void {
    Project::factory()->create(['slug' => 'existing-project']);

    $this->actingAs($this->admin)
        ->post(route('admin.projects.store'), [
            'title' => 'Test Project',
            'slug' => 'existing-project',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'status' => 'published',
        ])
        ->assertSessionHasErrors('slug');
});

test('allows updating slug to same value for same project', function (): void {
    $project = Project::factory()->create(['slug' => 'my-project']);

    $this->actingAs($this->admin)
        ->patch(route('admin.projects.update', $project), [
            'title' => $project->title,
            'slug' => 'my-project',
            'description' => $project->description,
            'content' => $project->content,
            'status' => $project->status,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
});
