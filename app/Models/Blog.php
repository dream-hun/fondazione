<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Blogs\Status;
use App\Models\Concerns\GeneratesUniqueSlug;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Blog extends Model
{
    use GeneratesUniqueSlug;
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

    // Accessors
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Helper methods
    public function publish(): bool
    {
        return $this->update([
            'status' => Status::Published->value,
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

    // Scopes
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', Status::Published->value)
            ->where('published_at', '<=', now());
    }

    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', Status::Draft->value);
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
                ->orWhere('excerpt', 'like', sprintf('%%%s%%', $search))
                ->orWhere('content', 'like', sprintf('%%%s%%', $search))
                ->orWhere('tags', 'like', sprintf('%%%s%%', $search));
        });
    }

    #[Scope]
    protected function byTag(Builder $query, string $tag): Builder
    {
        return $query->where('tags', 'like', sprintf('%%%s%%', $tag));
    }

    protected function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Published',
            default => 'Unknown',
        };
    }

    protected function getIsActiveAttribute(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    protected function getFeaturedImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        if (str_starts_with($this->featured_image, 'http')) {
            return $this->featured_image;
        }

        return asset('storage/'.$this->featured_image);
    }

    protected function getTagsArrayAttribute(): array
    {
        if (! $this->tags) {
            return [];
        }

        return array_map(trim(...), explode(',', $this->tags));
    }

    protected function getReadingTimeAttribute(): int
    {
        if ($this->attributes['reading_time']) {
            return $this->attributes['reading_time'];
        }

        $wordCount = str_word_count(strip_tags($this->content ?? ''));

        return max(1, (int) ceil($wordCount / 200));
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
