<?php

declare(strict_types=1);

use App\Enum\Reports\Status;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Storage::fake('public');
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->user = User::factory()->create(['is_admin' => false]);
});

test('admin can view reports index', function (): void {
    Report::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.reports.index'))
        ->assertSuccessful()
        ->assertSee('Manage Reports')
        ->assertSee('New Report');
});

test('non-admin cannot access reports index', function (): void {
    $this->actingAs($this->user)
        ->get(route('admin.reports.index'))
        ->assertForbidden();
});

test('guest cannot access reports index', function (): void {
    $this->get(route('admin.reports.index'))
        ->assertRedirect(route('login'));
});

test('admin can view create report page', function (): void {
    $this->actingAs($this->admin)
        ->get(route('admin.reports.create'))
        ->assertSuccessful()
        ->assertSee('Create New Report');
});

test('admin can create a report', function (): void {
    $file = UploadedFile::fake()->create('annual-report-2025.pdf', 500, 'application/pdf');

    $this->actingAs($this->admin)
        ->post(route('admin.reports.store'), [
            'title' => 'Annual Report 2025',
            'file' => $file,
            'status' => 'Published',
        ])
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('reports', [
        'title' => 'Annual Report 2025',
        'status' => 'Published',
    ]);

    $report = Report::query()->where('title', 'Annual Report 2025')->first();
    Storage::disk('public')->assertExists($report->file_path);
});

test('store validates required title', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.reports.store'), [
            'file' => UploadedFile::fake()->create('report.pdf', 100, 'application/pdf'),
            'status' => 'Draft',
        ])
        ->assertSessionHasErrors('title');
});

test('store validates required file', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.reports.store'), [
            'title' => 'My Report',
            'status' => 'Draft',
        ])
        ->assertSessionHasErrors('file');
});

test('store validates file must be pdf', function (): void {
    $this->actingAs($this->admin)
        ->post(route('admin.reports.store'), [
            'title' => 'My Report',
            'file' => UploadedFile::fake()->create('report.docx', 100, 'application/msword'),
            'status' => 'Draft',
        ])
        ->assertSessionHasErrors('file');
});

test('admin can view a report', function (): void {
    $report = Report::factory()->create(['title' => 'Test Report']);

    $this->actingAs($this->admin)
        ->get(route('admin.reports.show', $report))
        ->assertSuccessful()
        ->assertSee('Test Report');
});

test('admin can view edit report page', function (): void {
    $report = Report::factory()->create(['title' => 'Test Report']);

    $this->actingAs($this->admin)
        ->get(route('admin.reports.edit', $report))
        ->assertSuccessful()
        ->assertSee('Edit Report');
});

test('admin can update a report without changing file', function (): void {
    $report = Report::factory()->create();
    $originalFilePath = $report->file_path;

    $this->actingAs($this->admin)
        ->put(route('admin.reports.update', $report), [
            'title' => 'Updated Report Title',
            'status' => 'Published',
        ])
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('reports', [
        'id' => $report->id,
        'title' => 'Updated Report Title',
        'file_path' => $originalFilePath,
        'status' => 'Published',
    ]);
});

test('admin can update a report with a new file', function (): void {
    $report = Report::factory()->create();
    $newFile = UploadedFile::fake()->create('updated.pdf', 200, 'application/pdf');

    $this->actingAs($this->admin)
        ->put(route('admin.reports.update', $report), [
            'title' => 'Updated Report Title',
            'file' => $newFile,
            'status' => 'Published',
        ])
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $report->refresh();
    $this->assertDatabaseHas('reports', [
        'id' => $report->id,
        'title' => 'Updated Report Title',
        'status' => 'Published',
    ]);
    Storage::disk('public')->assertExists($report->file_path);
});

test('admin can delete a report', function (): void {
    $report = Report::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.reports.destroy', $report))
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('reports', ['id' => $report->id]);
});

test('admin can bulk delete reports', function (): void {
    $reports = Report::factory()->count(3)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.reports.bulk-action'), [
            'action' => 'delete',
            'selected_reports' => $reports->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $reports->each(fn ($r) => $this->assertDatabaseMissing('reports', ['id' => $r->id]));
});

test('admin can bulk publish reports', function (): void {
    $reports = Report::factory()->draft()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.reports.bulk-action'), [
            'action' => 'publish',
            'selected_reports' => $reports->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $reports->each(fn ($r) => $this->assertDatabaseHas('reports', [
        'id' => $r->id,
        'status' => Status::Published->value,
    ]));
});

test('admin can bulk unpublish reports', function (): void {
    $reports = Report::factory()->published()->count(2)->create();

    $this->actingAs($this->admin)
        ->post(route('admin.reports.bulk-action'), [
            'action' => 'unpublish',
            'selected_reports' => $reports->pluck('id')->toArray(),
        ])
        ->assertRedirect(route('admin.reports.index'))
        ->assertSessionHas('success');

    $reports->each(fn ($r) => $this->assertDatabaseHas('reports', [
        'id' => $r->id,
        'status' => Status::Unpublished->value,
    ]));
});

test('admin can search reports', function (): void {
    Report::factory()->create(['title' => 'Annual Financial Report']);
    Report::factory()->create(['title' => 'Project Summary']);

    $this->actingAs($this->admin)
        ->get(route('admin.reports.index', ['search' => 'Annual']))
        ->assertSuccessful()
        ->assertSee('Annual Financial Report')
        ->assertDontSee('Project Summary');
});

test('admin can filter reports by status', function (): void {
    Report::factory()->published()->create(['title' => 'Published Report']);
    Report::factory()->draft()->create(['title' => 'Draft Report']);

    $this->actingAs($this->admin)
        ->get(route('admin.reports.index', ['status' => 'Published']))
        ->assertSuccessful()
        ->assertSee('Published Report')
        ->assertDontSee('Draft Report');
});
