<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Notices\Status;
use Database\Factories\ReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'file_path', 'status'])]
final class Report extends Model
{
    /** @use HasFactory<ReportFactory> */
    use HasFactory;

    /**
     * @param  Builder<Report>  $query
     * @return Builder<Report>
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', Status::Published);
    }

    /**
     * @param  Builder<Report>  $query
     * @return Builder<Report>
     */
    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('status', Status::Draft);
    }

    /**
     * @param  Builder<Report>  $query
     * @return Builder<Report>
     */
    #[Scope]
    protected function unpublished(Builder $query): Builder
    {
        return $query->where('status', Status::Unpublished);
    }

    /**
     * @param  Builder<Report>  $query
     * @return Builder<Report>
     */
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
