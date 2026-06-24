<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table): void {
            $table->index(['status', 'published_at']);
            $table->index(['is_featured', 'published_at']);
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->index(['status', 'category', 'created_at']);
            $table->index(['is_featured', 'status']);
        });

        Schema::table('notices', function (Blueprint $table): void {
            $table->index(['status', 'created_at']);
        });

        Schema::table('reports', function (Blueprint $table): void {
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table): void {
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['is_featured', 'published_at']);
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropIndex(['status', 'category', 'created_at']);
            $table->dropIndex(['is_featured', 'status']);
        });

        Schema::table('notices', function (Blueprint $table): void {
            $table->dropIndex(['status', 'created_at']);
        });

        Schema::table('reports', function (Blueprint $table): void {
            $table->dropIndex(['status', 'created_at']);
        });
    }
};
