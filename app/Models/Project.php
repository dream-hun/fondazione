<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Projects\Category;
use App\Enum\Projects\Status;
use App\Models\Concerns\GeneratesUniqueSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Project extends Model
{
    use GeneratesUniqueSlug;
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
        'category',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Helper methods
    public function publish(): bool
    {
        return $this->update(['status' => Status::Published->value]);
    }

    public function archive(): bool
    {
        return $this->update(['status' => Status::Archived->value]);
    }

    public function makeFeatured(): bool
    {
        return $this->update(['is_featured' => true]);
    }

    public function removeFeatured(): bool
    {
        return $this->update(['is_featured' => false]);
    }

    // Scopes
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', Status::Published->value);
    }

    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', Status::Draft->value);
    }

    #[Scope]
    protected function archived(Builder $query): Builder
    {
        return $query->where('status', Status::Archived->value);
    }

    #[Scope]
    protected function featured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    #[Scope]
    protected function category(Builder $query, Category $category): Builder
    {
        return $query->where('category', $category->value);
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

    protected function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

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

        return asset('storage/'.$featured);
    }

    protected function getGalleryImageUrlsAttribute(): array
    {
        if (! $this->gallery_images || ! is_array($this->gallery_images)) {
            return [];
        }

        $normalized = array_map(function ($image): ?string {
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

            if (str_starts_with($image, 'http')) {
                return $image;
            }

            return asset('storage/'.$image);
        }, $this->gallery_images);

        return array_values(array_filter($normalized, fn ($v): bool => is_string($v) && $v !== ''));
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'budget' => 'decimal:2',
            'gallery_images' => 'array',
            'is_featured' => 'boolean',
            'category' => Category::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
