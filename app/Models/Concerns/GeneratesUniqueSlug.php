<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait GeneratesUniqueSlug
{
    public function slugColumn(): string
    {
        return 'slug';
    }

    public function slugSourceColumn(): string
    {
        return 'title';
    }

    protected static function bootGeneratesUniqueSlug(): void
    {
        static::creating(function (self $model): void {
            $slugCol = $model->slugColumn();
            $sourceCol = $model->slugSourceColumn();

            if (empty($model->{$slugCol})) {
                $base = Str::slug($model->{$sourceCol}) ?: (static::getTable().'-'.time());
                $model->{$slugCol} = static::buildUniqueSlug($base);
            }
        });

        static::updating(function (self $model): void {
            $slugCol = $model->slugColumn();
            $sourceCol = $model->slugSourceColumn();

            if ($model->isDirty($sourceCol) && empty($model->{$slugCol})) {
                $base = Str::slug($model->{$sourceCol}) ?: (static::getTable().'-'.$model->id);
                $model->{$slugCol} = static::buildUniqueSlug($base, $model->id);
            }
        });
    }

    protected static function buildUniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = $base;
        $counter = 1;

        while (static::query()
            ->where((new static)->slugColumn(), $slug)
            ->when($excludeId, fn (Builder $q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
