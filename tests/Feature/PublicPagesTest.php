<?php

declare(strict_types=1);

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('about us page can be rendered', function (): void {
    $this->get(route('about-us'))
        ->assertSuccessful()
        ->assertSee('Our Core Values');
});

test('about us page displays team members', function (): void {
    $team = Team::factory()->create(['name' => 'Jane Worker', 'position' => 'Director']);

    $this->get(route('about-us'))
        ->assertSuccessful()
        ->assertSee('The People Behind Our Mission')
        ->assertSee($team->name)
        ->assertSee($team->position);
});

test('our team page can be rendered', function (): void {
    $this->get(route('team'))
        ->assertSuccessful();
});

test('resources page can be rendered', function (): void {
    $this->get(route('resources'))
        ->assertSuccessful();
});

test('tvet training center page can be rendered', function (): void {
    $this->get(route('tvet'))
        ->assertSuccessful()
        ->assertSee('800+')
        ->assertSee('64%');
});

test('donate page can be rendered', function (): void {
    $this->get(route('donate'))
        ->assertSuccessful();
});

test('login page renders through the guest layout', function (): void {
    $this->get('/login')
        ->assertSuccessful()
        ->assertSee('Sign in');
});
