<?php

declare(strict_types=1);

namespace App\Enums\Banner;

enum BannerTargetEnum: string
{
    case BLANK = '_blank';
    case SELF = '_self';

    public function label(): string
    {
        return match ($this) {
            self::BLANK => 'Blank',
            self::SELF => 'Self',
        };
    }
}
