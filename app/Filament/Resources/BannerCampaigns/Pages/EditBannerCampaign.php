<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerCampaigns\Pages;

use App\Filament\Resources\BannerCampaigns\BannerCampaignResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditBannerCampaign extends EditRecord
{
    protected static string $resource = BannerCampaignResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
