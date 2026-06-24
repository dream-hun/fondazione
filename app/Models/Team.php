<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'position',
        'image',
        'email',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (self $model): void {
            $model->uuid ??= (string) Str::uuid();
        });
    }

    protected function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/'.$this->image);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
