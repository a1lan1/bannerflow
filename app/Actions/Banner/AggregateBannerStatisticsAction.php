<?php

declare(strict_types=1);

namespace App\Actions\Banner;

use App\Enums\Banner\BannerEventTypeEnum;
use App\Interfaces\Actions\Banner\AggregateBannerStatisticsActionInterface;
use App\Models\BannerEvent;
use App\Models\BannerStatistic;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

final readonly class AggregateBannerStatisticsAction implements AggregateBannerStatisticsActionInterface
{
    public function execute(?Carbon $date = null): void
    {
        $date ??= today();

        /** @var Collection<int, BannerEvent&object{hour: int, impressions: int, clicks: int}> $rows */
        $rows = BannerEvent::query()
            ->whereDate('created_at', $date)
            ->selectRaw('
                banner_id,
                placement_id,
                HOUR(created_at) as hour,
                SUM(type = ?) as impressions,
                SUM(type = ?) as clicks
            ', [
                BannerEventTypeEnum::IMPRESSION->value,
                BannerEventTypeEnum::CLICK->value,
            ])
            ->groupBy(
                'banner_id',
                'placement_id',
                'hour',
            )
            ->get();

        foreach ($rows as $row) {
            BannerStatistic::updateOrCreate(
                [
                    'banner_id' => $row->banner_id,
                    'placement_id' => $row->placement_id,
                    'date' => $date,
                    'hour' => $row->hour,
                ],
                [
                    'impressions' => $row->impressions,
                    'clicks' => $row->clicks,
                    'ctr' => $row->impressions > 0
                        ? round(($row->clicks / $row->impressions) * 100, 2)
                        : 0,
                ],
            );
        }
    }
}
