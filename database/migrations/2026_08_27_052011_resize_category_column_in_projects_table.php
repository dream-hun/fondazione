<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            if (Schema::hasIndex('projects', 'projects_status_category_created_at_index')) {
                $table->dropIndex('projects_status_category_created_at_index');
            }

            if (Schema::hasIndex('projects', 'projects_is_featured_status_index')) {
                $table->dropIndex('projects_is_featured_status_index');
            }

            $table->string('category', 20)->default('cdsp')->change();
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->index(['status', 'category', 'created_at']);
            $table->index(['is_featured', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            if (Schema::hasIndex('projects', 'projects_status_category_created_at_index')) {
                $table->dropIndex('projects_status_category_created_at_index');
            }

            if (Schema::hasIndex('projects', 'projects_is_featured_status_index')) {
                $table->dropIndex('projects_is_featured_status_index');
            }

            $table->string('category')->default('cdsp')->change();
        });
    }
};
