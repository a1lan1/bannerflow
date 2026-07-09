<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Banner;
use App\Models\BannerCampaign;
use App\Models\BannerStatistic;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Override;

class BannerStatsWidget extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $pollingInterval = '15s';

    #[Override]
    protected function getStats(): array
    {
        return [
            Stat::make('Total Campaigns', BannerCampaign::count())
                ->description('All banner campaigns')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Banners', Banner::count())
                ->description('All banners')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Impressions', BannerStatistic::sum('impressions'))
                ->description('Total banner impressions')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Clicks', BannerStatistic::sum('clicks'))
                ->description('Total banner clicks')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
