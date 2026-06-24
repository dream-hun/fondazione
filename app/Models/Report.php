<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Notices\Status;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Report extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'file_path', 'status'];

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', Status::Published);
    }

    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', Status::Draft);
    }

    #[Scope]
    protected function unpublished(Builder $query): Builder
    {
        return $query->where('status', Status::Unpublished);
    }

    #[Scope]
    protected function search(Builder $query, string $search): Builder
    {
        return $query->where('title', 'like', sprintf('%%%s%%', $search));
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
