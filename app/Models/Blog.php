<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'published_at',
        'featured_image',
        'author_name',
        'author_email',
        'tags',
        'is_featured',
        'reading_time',
    ];

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search): void {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('tags', 'like', "%{$search}%");
        });
    }

    public function scopeByTag(Builder $query, string $tag): Builder
    {
        return $query->where('tags', 'like', "%{$tag}%");
    }

    // Accessors
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Published',
            default => 'Unknown',
        };
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        if (str_starts_with($this->featured_image, 'http')) {
            return $this->featured_image;
        }

        return asset('storage/'.$this->featured_image);
    }

    public function getTagsArrayAttribute(): array
    {
        if (! $this->tags) {
            return [];
        }

        return array_map('trim', explode(',', $this->tags));
    }

    public function getReadingTimeAttribute(): int
    {
        if ($this->attributes['reading_time']) {
            return $this->attributes['reading_time'];
        }

        // Calculate reading time based on content (average 200 words per minute)
        $wordCount = str_word_count(strip_tags($this->content ?? ''));

        return max(1, (int) ceil($wordCount / 200));
    }

    // Helper methods
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function makeFeatured(): bool
    {
        return $this->update(['is_featured' => true]);
    }

    public function removeFeatured(): bool
    {
        return $this->update(['is_featured' => false]);
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (Blog $blog): void {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        self::updating(function (Blog $blog): void {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'reading_time' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
