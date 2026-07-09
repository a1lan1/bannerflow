<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerPlacements\Pages;

use App\Filament\Resources\BannerPlacements\BannerPlacementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

class ListBannerPlacements extends ListRecords
{
    protected static string $resource = BannerPlacementResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
