<?php

declare(strict_types=1);

namespace App\Models;

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
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->where('status', 'archived');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search): void {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        });
    }


    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
            default => 'Unknown',
        };
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'published';
    }

    // Helper methods
    public function publish(): bool
    {
        return $this->update(['status' => 'published']);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }


        if (str_starts_with($this->featured_image, 'http')) {
            return $this->featured_image;
        }

        // Otherwise, return the storage URL
        return asset('storage/'.$this->featured_image);
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        if (! $this->gallery_images || ! is_array($this->gallery_images)) {
            return [];
        }

        return array_map(function ($image) {
            // If it's already a full URL (from factory), return as is
            if (str_starts_with($image, 'http')) {
                return $image;
            }

            // Otherwise, return the storage URL
            return asset('storage/'.$image);
        }, $this->gallery_images);
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

        while (self::where('slug', $slug)
            ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (Project $project): void {
            if (empty($project->slug)) {
                $baseSlug = Str::slug($project->title) ?: 'project-' . time();
                $project->slug = $project->generateUniqueSlug($baseSlug);
            }
        });

        self::updating(function (Project $project): void {
            if ($project->isDirty('title') && empty($project->slug)) {
                $baseSlug = Str::slug($project->title) ?: 'project-' . $project->id;
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
