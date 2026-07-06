<?php

declare(strict_types=1);

namespace App\Enums\Banner;

enum RotationStrategyEnum: string
{
    case RANDOM = 'random';
    case WEIGHTED = 'weighted';
    case SEQUENTIAL = 'sequential';

    public function label(): string
    {
        return match ($this) {
            self::RANDOM => 'Random',
            self::WEIGHTED => 'Weighted',
            self::SEQUENTIAL => 'Sequential',
        };
    }
}
