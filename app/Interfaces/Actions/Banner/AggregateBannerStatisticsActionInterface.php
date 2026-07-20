<?php

declare(strict_types=1);

namespace App\Interfaces\Actions\Banner;

use Carbon\Carbon;

interface AggregateBannerStatisticsActionInterface
{
    public function execute(?Carbon $date = null): void;
}
