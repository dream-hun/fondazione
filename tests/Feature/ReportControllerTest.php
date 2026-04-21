<?php

declare(strict_types=1);

use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    Storage::fake('public');
});

test('public reports page is accessible', function (): void {
    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('Reports');
});

test('public reports page only shows published reports', function (): void {
    Report::factory()->published()->create(['title' => 'Public Report']);
    Report::factory()->draft()->create(['title' => 'Draft Report']);
    Report::factory()->unpublished()->create(['title' => 'Unpublished Report']);

    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('Public Report')
        ->assertDontSee('Draft Report')
        ->assertDontSee('Unpublished Report');
});

test('public reports page shows empty state when no published reports', function (): void {
    Report::factory()->draft()->count(3)->create();

    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('No reports available');
});

test('public reports page shows download links', function (): void {
    Report::factory()->published()->create(['title' => 'Test Report']);

    $this->get(route('reports.index'))
        ->assertSuccessful()
        ->assertSee('Test Report')
        ->assertSee('Download');
});
