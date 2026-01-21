<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'status',
        'start_date',
        'end_date',
        'budget',
        'location',
        'beneficiaries_count',
        'featured_image',
        'gallery_images',
        'is_featured',
    ];

    // Scopes
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    #[Scope]
    protected function archived(Builder $query): Builder
    {
        return $query->where('status', 'archived');
    }

    #[Scope]
    protected function featured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search): void {
            $q->where('title', 'like', sprintf('%%%s%%', $search))
                ->orWhere('description', 'like', sprintf('%%%s%%', $search))
                ->orWhere('content', 'like', sprintf('%%%s%%', $search))
                ->orWhere('location', 'like', sprintf('%%%s%%', $search));
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
            default => 'Unknown',
        };
    }

    protected function getIsActiveAttribute(): bool
    {
        return $this->status === 'published';
    }

    // Helper methods
    public function publish(): bool
    {
        return $this->update(['status' => 'published']);
    }

    protected function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        // Handle string or common array shapes from uploaders
        $featured = $this->featured_image;
        if (is_array($featured)) {
            $featured = $featured['url']
                ?? $featured['path']
                ?? $featured['name']
                ?? $featured['filename']
                ?? null;
        }

        if (! is_string($featured) || $featured === '') {
            return null;
        }

        if (str_starts_with($featured, 'http')) {
            return $featured;
        }

        // Otherwise, return the storage URL
        return asset('storage/'.$featured);
    }

    protected function getGalleryImageUrlsAttribute(): array
    {
        if (! $this->gallery_images || ! is_array($this->gallery_images)) {
            return [];
        }

        $normalized = array_map(function ($image): ?string {
            // Normalize possible array shapes into a path/url string
            if (is_array($image)) {
                $image = $image['url']
                    ?? $image['path']
                    ?? $image['name']
                    ?? $image['filename']
                    ?? null;
            }

            if (! is_string($image) || $image === '') {
                return null;
            }

            // If it's already a full URL (from factory), return as is
            if (str_starts_with($image, 'http')) {
                return $image;
            }

            // Otherwise, return the storage URL
            return asset('storage/'.$image);
        }, $this->gallery_images);

        // Remove any nulls produced by unrecognized shapes
        return array_values(array_filter($normalized, fn ($v): bool => is_string($v) && $v !== ''));
    }

    public function archive(): bool
    {
        return $this->update(['status' => 'archived']);
    }

    public function makeFeatured(): bool
    {
        return $this->update(['is_featured' => true]);
    }

    public function removeFeatured(): bool
    {
        return $this->update(['is_featured' => false]);
    }

    /**
     * Generate a unique slug for the project
     */
    public function generateUniqueSlug(string $baseSlug, ?int $excludeId = null): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while (self::query()->where('slug', $slug)
            ->when($excludeId, fn ($query) => $query->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (Project $project): void {
            if (empty($project->slug)) {
                $baseSlug = Str::slug($project->title) ?: 'project-'.time();
                $project->slug = $project->generateUniqueSlug($baseSlug);
            }
        });

        self::updating(function (Project $project): void {
            if ($project->isDirty('title') && empty($project->slug)) {
                $baseSlug = Str::slug($project->title) ?: 'project-'.$project->id;
                $project->slug = $project->generateUniqueSlug($baseSlug, $project->id);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'budget' => 'decimal:2',
            'gallery_images' => 'array',
            'is_featured' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
