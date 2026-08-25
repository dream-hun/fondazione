<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Notices\Status;
use App\Models\Concerns\GeneratesUniqueSlug;
use Database\Factories\NoticeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'uuid',
    'title',
    'slug',
    'excerpt',
    'body',
    'attachment',
    'status',
])]
#[Table(name: 'notices')]
final class Notice extends Model
{
    use GeneratesUniqueSlug;

    /** @use HasFactory<NoticeFactory> */
    use HasFactory;

    public function hasAttachment(): bool
    {
        return ! empty($this->attachment);
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (self $model): void {
            $model->uuid ??= (string) Str::uuid();
        });
    }

    protected function getFormattedDateAttribute(): string
    {
        return $this->created_at?->format('M j, Y') ?? '';
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
