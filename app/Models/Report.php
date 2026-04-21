<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Reports\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopePublished(Builder $query): void
    {
        $query->where('status', Status::Published);
    }

    public function scopeDraft(Builder $query): void
    {
        $query->where('status', Status::Draft);
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('title', 'like', sprintf('%%%s%%', $search));
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }
}
