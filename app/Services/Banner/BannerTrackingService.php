<?php

declare(strict_types=1);

namespace App\Services\Banner;

use App\Data\Banner\BannerContext;
use App\Interfaces\Actions\Banner\RecordBannerClickActionInterface;
use App\Interfaces\Actions\Banner\RecordBannerImpressionActionInterface;
use App\Interfaces\Services\Banner\BannerTrackingServiceInterface;
use App\Models\Banner;
use App\Models\BannerPlacement;

final readonly class BannerTrackingService implements BannerTrackingServiceInterface
{
    public function __construct(
        private RecordBannerImpressionActionInterface $recordImpressionAction,
        private RecordBannerClickActionInterface $recordClickAction,
    ) {}

    public function trackImpression(Banner $banner, BannerPlacement $placement, BannerContext $context): void
    {
        $this->recordImpressionAction->execute($banner, $placement, $context);
    }

    public function trackClick(Banner $banner, BannerPlacement $placement, BannerContext $context): void
    {
        $this->recordClickAction->execute($banner, $placement, $context);
    }
}
