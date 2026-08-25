<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 */
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
                $raw = $model->getAttribute($sourceCol);
                $sourceValue = is_scalar($raw) ? (string) $raw : '';
                $base = Str::slug($sourceValue) ?: ($model->getTable().'-'.time());
                $model->{$slugCol} = static::buildUniqueSlug($base);
            }
        });

        static::updating(function (self $model): void {
            $slugCol = $model->slugColumn();
            $sourceCol = $model->slugSourceColumn();

            if ($model->isDirty($sourceCol) && empty($model->{$slugCol})) {
                $raw = $model->getAttribute($sourceCol);
                $sourceValue = is_scalar($raw) ? (string) $raw : '';
                $key = $model->getKey();
                $keyStr = is_scalar($key) ? (string) $key : '';
                $base = Str::slug($sourceValue) ?: ($model->getTable().'-'.$keyStr);
                $model->{$slugCol} = static::buildUniqueSlug($base, $model->getKey());
            }
        });
    }

    protected static function buildUniqueSlug(string $base, mixed $excludeId = null): string
    {
        $slug = $base;
        $counter = 1;

        while (static::query()
            ->where((new static)->slugColumn(), $slug)
            ->when($excludeId !== null, fn (Builder $q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
