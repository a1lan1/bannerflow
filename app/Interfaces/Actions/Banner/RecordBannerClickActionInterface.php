<?php

declare(strict_types=1);

namespace App\Interfaces\Actions\Banner;

use App\Data\Banner\BannerContext;
use App\Models\Banner;
use App\Models\BannerEvent;
use App\Models\BannerPlacement;

interface RecordBannerClickActionInterface
{
    public function execute(Banner $banner, BannerPlacement $placement, BannerContext $context): BannerEvent;
}
