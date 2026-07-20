<?php

declare(strict_types=1);

namespace App\Interfaces\Services\Banner;

use App\Data\Banner\BannerContext;
use App\Models\Banner;
use App\Models\BannerPlacement;

interface BannerTrackingServiceInterface
{
    public function trackImpression(Banner $banner, BannerPlacement $placement, BannerContext $context): void;

    public function trackClick(Banner $banner, BannerPlacement $placement, BannerContext $context): void;
}
