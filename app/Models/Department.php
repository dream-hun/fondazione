<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\GeneratesUniqueSlug;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\RouteKey;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $status_label
 */
#[Fillable([
    'name',
    'slug',
    'description',
    'email',
    'phone',
    'location',
    'head_of_department',
    'mission',
    'key_responsibilities',
    'is_active',
    'display_order',
])]
#[RouteKey('slug')]
final class Department extends Model
{
    use GeneratesUniqueSlug;

    /** @use HasFactory<DepartmentFactory> */
    use HasFactory;

    public function slugSourceColumn(): string
    {
        return 'name';
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->is_active ? 'Active' : 'Inactive'
        );
    }

    /**
     * @param  Builder<Department>  $query
     * @return Builder<Department>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Department>  $query
     * @return Builder<Department>
     */
    #[Scope]
    protected function inactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }

    /**
     * @param  Builder<Department>  $query
     * @return Builder<Department>
     */
    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->where(function (Builder $q) use ($search): void {
            $q->where('name', 'like', sprintf('%%%s%%', $search))
                ->orWhere('description', 'like', sprintf('%%%s%%', $search))
                ->orWhere('head_of_department', 'like', sprintf('%%%s%%', $search))
                ->orWhere('location', 'like', sprintf('%%%s%%', $search));
        });
    }

    /**
     * @param  Builder<Department>  $query
     * @return Builder<Department>
     */
    #[Scope]
    protected function ordered(Builder $query): Builder
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'display_order' => 'integer',
            'key_responsibilities' => 'array',
        ];
    }
}
