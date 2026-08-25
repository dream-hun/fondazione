<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Blogs\Status;
use App\Models\Concerns\GeneratesUniqueSlug;
use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
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
])]
final class Blog extends Model
{
    use GeneratesUniqueSlug;

    /** @use HasFactory<BlogFactory> */
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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

    /**
     * @param  Builder<Blog>  $query
     * @return Builder<Blog>
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', Status::Published->value)
            ->where('published_at', '<=', now());
    }

    /**
     * @param  Builder<Blog>  $query
     * @return Builder<Blog>
     */
    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', Status::Draft->value);
    }

    /**
     * @param  Builder<Blog>  $query
     * @return Builder<Blog>
     */
    #[Scope]
    protected function featured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * @param  Builder<Blog>  $query
     * @return Builder<Blog>
     */
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

    /**
     * @param  Builder<Blog>  $query
     * @return Builder<Blog>
     */
    #[Scope]
    protected function byTag(Builder $query, string $tag): Builder
    {
        return $query->where('tags', 'like', sprintf('%%%s%%', $tag));
    }

    protected function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            Status::Draft->value => 'Draft',
            default => 'Published',
        };
    }

    protected function getIsActiveAttribute(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        $raw = $this->attributes['published_at'] ?? null;
        if ($raw === null) {
            return false;
        }

        return $this->asDateTime($raw)->lte(now());
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

    /**
     * @return list<string>
     */
    protected function getTagsArrayAttribute(): array
    {
        if (! $this->tags) {
            return [];
        }

        /** @var list<string> */
        return array_map(trim(...), explode(',', (string) $this->tags));
    }

    protected function getReadingTimeAttribute(): int
    {
        $stored = $this->attributes['reading_time'] ?? null;
        if (! in_array($stored, [null, false, '', 0], true)) {
            return is_scalar($stored) ? (int) $stored : 1;
        }

        $raw = $this->attributes['content'] ?? null;
        $content = is_scalar($raw) ? (string) $raw : '';
        $wordCount = str_word_count(strip_tags($content));

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
