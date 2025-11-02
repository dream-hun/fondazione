<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Notices\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Notice extends Model
{
    protected $table = 'notices';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => Status::class,
    ];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = $model->uuid ?? (string) Str::uuid();
            $model->slug = $model->slug ?? Str::slug($model->title);
        });
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M j, Y');
    }

    public function hasAttachment(): bool
    {
        return ! empty($this->attachment);
    }
}
