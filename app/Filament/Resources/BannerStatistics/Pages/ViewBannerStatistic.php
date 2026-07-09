<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerStatistics\Pages;

use App\Filament\Resources\BannerStatistics\BannerStatisticResource;
use Filament\Resources\Pages\ViewRecord;
use Override;

class ViewBannerStatistic extends ViewRecord
{
    protected static string $resource = BannerStatisticResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
