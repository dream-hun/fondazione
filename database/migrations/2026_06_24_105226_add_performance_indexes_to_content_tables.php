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
            if (! Schema::hasIndex('blogs', 'blogs_status_published_at_index')) {
                $table->index(['status', 'published_at']);
            }
            if (! Schema::hasIndex('blogs', 'blogs_is_featured_published_at_index')) {
                $table->index(['is_featured', 'published_at']);
            }
        });

        Schema::table('projects', function (Blueprint $table): void {
            if (! Schema::hasIndex('projects', 'projects_status_category_created_at_index')) {
                $table->index(['status', 'category', 'created_at']);
            }
            if (! Schema::hasIndex('projects', 'projects_is_featured_status_index')) {
                $table->index(['is_featured', 'status']);
            }
        });

        Schema::table('notices', function (Blueprint $table): void {
            if (! Schema::hasIndex('notices', 'notices_status_created_at_index')) {
                $table->index(['status', 'created_at']);
            }
        });

        Schema::table('reports', function (Blueprint $table): void {
            if (! Schema::hasIndex('reports', 'reports_status_created_at_index')) {
                $table->index(['status', 'created_at']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table): void {
            if (Schema::hasIndex('blogs', 'blogs_status_published_at_index')) {
                $table->dropIndex('blogs_status_published_at_index');
            }
            if (Schema::hasIndex('blogs', 'blogs_is_featured_published_at_index')) {
                $table->dropIndex('blogs_is_featured_published_at_index');
            }
        });

        Schema::table('projects', function (Blueprint $table): void {
            if (Schema::hasIndex('projects', 'projects_status_category_created_at_index')) {
                $table->dropIndex('projects_status_category_created_at_index');
            }
            if (Schema::hasIndex('projects', 'projects_is_featured_status_index')) {
                $table->dropIndex('projects_is_featured_status_index');
            }
        });

        Schema::table('notices', function (Blueprint $table): void {
            if (Schema::hasIndex('notices', 'notices_status_created_at_index')) {
                $table->dropIndex('notices_status_created_at_index');
            }
        });

        Schema::table('reports', function (Blueprint $table): void {
            if (Schema::hasIndex('reports', 'reports_status_created_at_index')) {
                $table->dropIndex('reports_status_created_at_index');
            }
        });
    }
};
