<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerPlacements\Pages;

use App\Filament\Resources\BannerPlacements\BannerPlacementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

class ViewBannerPlacement extends ViewRecord
{
    protected static string $resource = BannerPlacementResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
