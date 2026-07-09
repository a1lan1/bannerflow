<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerPlacements\Pages;

use App\Filament\Resources\BannerPlacements\BannerPlacementResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditBannerPlacement extends EditRecord
{
    protected static string $resource = BannerPlacementResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
