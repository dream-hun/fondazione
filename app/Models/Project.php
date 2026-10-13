<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Projects\Category;
use App\Enum\Projects\Status;
use App\Models\Concerns\GeneratesUniqueSlug;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Category $category
 * @property list<string>|null $gallery_images
 * @property string $status_label
 * @property string|null $featured_image_url
 * @property list<string> $gallery_image_urls
 */
#[Fillable([
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
])]
#[RouteKey('slug')]
final class Project extends Model
{
    use GeneratesUniqueSlug;

    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

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

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => match ($this->status) {
                'draft' => 'Draft',
                'published' => 'Published',
                default => 'Archived',
            }
        );
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->status === 'published'
        );
    }

    protected function featuredImageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                $featured = $this->featured_image;
                if (! is_string($featured) || $featured === '') {
                    return null;
                }

                if (str_starts_with($featured, 'http')) {
                    return $featured;
                }

                return asset('storage/'.$featured);
            }
        );
    }

    protected function galleryImageUrls(): Attribute
    {
        return Attribute::make(
            get: function (): array {
                // gallery_images is cast to array; raw attribute may be null
                $galleryImages = $this->attributes['gallery_images'] ?? null;
                if ($galleryImages === null) {
                    return [];
                }

                /** @var array<mixed> $decoded */
                $decoded = is_string($galleryImages) ? (json_decode($galleryImages, true) ?? []) : (array) $galleryImages;
                $normalized = array_map(function (mixed $image): ?string {
                    if (! is_string($image) || $image === '') {
                        return null;
                    }

                    if (str_starts_with($image, 'http')) {
                        return $image;
                    }

                    return asset('storage/'.$image);
                }, $decoded);

                /** @var list<string> */
                return array_values(array_filter($normalized, fn (?string $v): bool => $v !== null && $v !== ''));
            }
        );
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', Status::Published->value);
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', Status::Draft->value);
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    #[Scope]
    protected function archived(Builder $query): Builder
    {
        return $query->where('status', Status::Archived->value);
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    #[Scope]
    protected function featured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    #[Scope]
    protected function category(Builder $query, Category $category): Builder
    {
        return $query->where('category', $category->value);
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
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
