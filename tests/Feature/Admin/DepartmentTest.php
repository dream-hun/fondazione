<?php

declare(strict_types=1);

use App\Models\Department;
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

test('admin can view departments index', function (): void {
    Department::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.departments.index'))
        ->assertSuccessful()
        ->assertSee('Manage Departments');
});

test('non-admin cannot view departments index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.departments.index'))
        ->assertForbidden();
});

test('guest cannot view departments index', function (): void {
    $this->get(route('admin.departments.index'))
        ->assertRedirect(route('login'));
});

test('admin can view create department page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.departments.create'))
        ->assertSuccessful();
});

test('admin can create a department', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.departments.store'), [
            'name' => 'Agriculture Department',
            'email' => 'agri@example.com',
            'is_active' => true,
        ])
        ->assertRedirect(route('admin.departments.index'))
        ->assertSessionHas('success', 'Department "Agriculture Department" created successfully.');

    $this->assertDatabaseHas('departments', [
        'name' => 'Agriculture Department',
        'slug' => 'agriculture-department',
    ]);
});

test('admin cannot create a department without a name', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.departments.store'), [])
        ->assertSessionHasErrors(['name']);
});

test('admin can view a department', function (): void {
    $department = Department::factory()->create(['name' => 'Finance Unit']);

    $this->actingAs($this->admin)
        ->get(route('admin.departments.show', $department))
        ->assertSuccessful()
        ->assertSee('Finance Unit');
});

test('admin can view edit department page', function (): void {
    $department = Department::factory()->create();

    $this->actingAs($this->admin)
        ->get(route('admin.departments.edit', $department))
        ->assertSuccessful();
});

test('admin can update a department', function (): void {
    $department = Department::factory()->create(['name' => 'Old Name']);

    $this->actingAs($this->admin)
        ->put(route('admin.departments.update', $department), [
            'name' => 'New Name',
            'slug' => $department->slug,
            'is_active' => false,
        ])
        ->assertRedirect(route('admin.departments.index'))
        ->assertSessionHas('success', 'Department "New Name" updated successfully.');

    $this->assertDatabaseHas('departments', [
        'id' => $department->id,
        'name' => 'New Name',
        'is_active' => false,
    ]);
});

test('updating a department keeps its slug when only the name changes', function (): void {
    $department = Department::factory()->create(['name' => 'Stable Name']);

    $this->actingAs($this->admin)
        ->put(route('admin.departments.update', $department), [
            'name' => 'Renamed Unit',
            'slug' => $department->slug,
            'is_active' => true,
        ]);

    expect($department->fresh()->slug)->toBe($department->slug);
});

test('admin can delete a department', function (): void {
    $department = Department::factory()->create(['name' => 'Doomed Department']);

    $this->actingAs($this->admin)
        ->delete(route('admin.departments.destroy', $department))
        ->assertRedirect(route('admin.departments.index'))
        ->assertSessionHas('success', 'Department "Doomed Department" deleted successfully.');

    $this->assertDatabaseMissing('departments', ['id' => $department->id]);
});

test('admin can search departments', function (): void {
    Department::factory()->create([
        'name' => 'Water Services',
        'description' => 'Clean water supply',
        'head_of_department' => 'Alice Smith',
        'location' => '123 Main St',
    ]);
    Department::factory()->create([
        'name' => 'Road Works',
        'description' => 'Road maintenance',
        'head_of_department' => 'Bob Jones',
        'location' => '456 Oak Ave',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.departments.index', ['search' => 'Water']))
        ->assertSuccessful()
        ->assertSee('Water Services')
        ->assertDontSee('Road Works');
});

test('admin can filter departments by active status', function (): void {
    Department::factory()->create(['name' => 'Active Unit', 'is_active' => true]);
    Department::factory()->inactive()->create(['name' => 'Sleeping Unit']);

    $this->actingAs($this->admin)
        ->get(route('admin.departments.index', ['status' => 'active']))
        ->assertSuccessful()
        ->assertSee('Active Unit')
        ->assertDontSee('Sleeping Unit');
});

test('admin can filter departments by inactive status', function (): void {
    Department::factory()->create(['name' => 'Awake Unit', 'is_active' => true]);
    Department::factory()->inactive()->create(['name' => 'Paused Unit']);

    $this->actingAs($this->admin)
        ->get(route('admin.departments.index', ['status' => 'inactive']))
        ->assertSuccessful()
        ->assertSee('Paused Unit')
        ->assertDontSee('Awake Unit');
});

test('admin can bulk delete departments', function (): void {
    $departments = Department::factory()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.departments.bulk-action'), [
            'action' => 'delete',
            'selected_departments' => $departments->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.departments.index'))
        ->assertSessionHas('success', '2 department(s) deleted successfully.');

    $departments->each(fn (Department $d) => $this->assertDatabaseMissing('departments', ['id' => $d->id]));
});

test('admin can bulk activate departments', function (): void {
    $departments = Department::factory()->inactive()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.departments.bulk-action'), [
            'action' => 'activate',
            'selected_departments' => $departments->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.departments.index'))
        ->assertSessionHas('success', '2 department(s) activated successfully.');

    $this->assertDatabaseHas('departments', [
        'id' => $departments[0]->id,
        'is_active' => true,
    ]);
});

test('admin can bulk deactivate departments', function (): void {
    $departments = Department::factory()->count(2)->create(['is_active' => true]);

    $this->actingAs($this->admin)
        ->post(route('admin.departments.bulk-action'), [
            'action' => 'deactivate',
            'selected_departments' => $departments->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.departments.index'))
        ->assertSessionHas('success', '2 department(s) deactivated successfully.');

    $this->assertDatabaseHas('departments', [
        'id' => $departments[0]->id,
        'is_active' => false,
    ]);
});
