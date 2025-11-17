<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Team extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'position',
        'image',
        'email',
    ];

    public static function boot(): void
    {
        parent::boot();

        self::creating(function ($model): void {
            $model->uuid = $model->uuid ?? (string) Str::uuid();
        });
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        // If it's already a full URL, return as is
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // Otherwise, return the storage URL
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
