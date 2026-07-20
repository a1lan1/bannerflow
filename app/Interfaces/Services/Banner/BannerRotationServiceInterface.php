<?php

declare(strict_types=1);

namespace App\Interfaces\Services\Banner;

use App\Data\Banner\BannerContext;
use App\Models\Banner;

interface BannerRotationServiceInterface
{
    public function getBanner(BannerContext $context): ?Banner;
}
