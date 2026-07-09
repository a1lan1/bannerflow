<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerCampaigns\Pages;

use App\Filament\Resources\BannerCampaigns\BannerCampaignResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

class ViewBannerCampaign extends ViewRecord
{
    protected static string $resource = BannerCampaignResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
