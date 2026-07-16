<?php

declare(strict_types=1);

namespace App\Actions\Banner;

use App\Data\Banner\ScheduleData;
use App\Models\Banner;
use Spatie\LaravelData\DataCollection;

final readonly class SyncBannerScheduleAction
{
    /**
     * @param  DataCollection<int, ScheduleData>  $schedule
     */
    public function execute(
        Banner $banner,
        DataCollection $schedule,
    ): void {
        $banner->schedule()->delete();

        $banner->schedule()->createMany(
            $schedule
                ->toCollection()
                ->map(fn (ScheduleData $item): array => $item->toArray())
                ->all()
        );
    }
}
