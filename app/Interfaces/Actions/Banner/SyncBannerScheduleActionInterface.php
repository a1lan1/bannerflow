<?php

declare(strict_types=1);

namespace App\Interfaces\Actions\Banner;

use App\Models\Banner;
use Spatie\LaravelData\DataCollection;

interface SyncBannerScheduleActionInterface
{
    public function execute(Banner $banner, DataCollection $schedule): void;
}
