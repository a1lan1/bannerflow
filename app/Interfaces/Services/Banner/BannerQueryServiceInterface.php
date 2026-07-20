<?php

declare(strict_types=1);

namespace App\Interfaces\Services\Banner;

use App\Models\BannerPlacement;
use Illuminate\Support\Collection;

interface BannerQueryServiceInterface
{
    public function getAvailableBannersForPlacement(BannerPlacement $placement): Collection;
}
