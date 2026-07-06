<?php

declare(strict_types=1);

namespace App\Enums\Banner;

enum BannerEventTypeEnum: string
{
    case IMPRESSION = 'impression';
    case CLICK = 'click';

    public function label(): string
    {
        return match ($this) {
            self::IMPRESSION => 'Impression',
            self::CLICK => 'Click',
        };
    }
}
