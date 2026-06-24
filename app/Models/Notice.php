<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Notices\Status;
use App\Models\Concerns\GeneratesUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Notice extends Model
{
    use GeneratesUniqueSlug;
    use HasFactory;

    protected $table = 'notices';

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'excerpt',
        'body',
        'attachment',
        'status',
    ];

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
        return $this->created_at->format('M j, Y');
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
