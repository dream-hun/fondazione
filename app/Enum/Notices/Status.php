<?php

declare(strict_types=1);

namespace App\Enum\Notices;

enum Status: string
{
    case Draft = 'Draft';
    case Published = 'Published';
    case Unpublished = 'Unpublished';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Published => 'success',
            self::Unpublished => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Draft => 'heroicon-o-newspaper',
            self::Published => 'heroicon-o-check-badge',
            self::Unpublished => 'heroicon-o-times-circle',
        };
    }
}
