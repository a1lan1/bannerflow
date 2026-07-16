<?php

declare(strict_types=1);

namespace App\Actions\Banner;

use App\Data\Banner\BannerContext;
use App\Enums\Banner\BannerEventTypeEnum;
use App\Models\Banner;
use App\Models\BannerEvent;
use App\Models\BannerPlacement;

final readonly class RecordBannerImpressionAction
{
    public function execute(
        Banner $banner,
        BannerPlacement $placement,
        BannerContext $context,
    ): BannerEvent {
        return BannerEvent::create([
            'banner_id' => $banner->id,
            'placement_id' => $placement->id,
            'type' => BannerEventTypeEnum::IMPRESSION,
            ...$context->toDatabaseArray(),
        ]);
    }
}
