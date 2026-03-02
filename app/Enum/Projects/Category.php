<?php

declare(strict_types=1);

namespace App\Enum\Projects;

enum Category: string
{
    case Cdsp = 'cdsp';
    case Wdp = 'wdp';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cdsp => 'CDSP',
            self::Wdp => 'WDP',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Cdsp => 'blue',
            self::Wdp => 'green',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Cdsp => 'heroicon-o-building-office-2',
            self::Wdp => 'heroicon-o-globe-alt',
        };
    }
}
