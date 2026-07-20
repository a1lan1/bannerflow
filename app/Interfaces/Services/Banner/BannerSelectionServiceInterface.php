<?php

declare(strict_types=1);

namespace App\Interfaces\Services\Banner;

use App\Enums\Banner\RotationStrategyEnum;
use App\Models\Banner;
use Illuminate\Support\Collection;

interface BannerSelectionServiceInterface
{
    public function select(Collection $banners, RotationStrategyEnum $strategy): ?Banner;
}
