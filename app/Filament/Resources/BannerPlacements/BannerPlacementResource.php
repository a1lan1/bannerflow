<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerPlacements;

use App\Filament\Resources\BannerPlacements\Pages\CreateBannerPlacement;
use App\Filament\Resources\BannerPlacements\Pages\EditBannerPlacement;
use App\Filament\Resources\BannerPlacements\Pages\ListBannerPlacements;
use App\Filament\Resources\BannerPlacements\Pages\ViewBannerPlacement;
use App\Filament\Resources\BannerPlacements\Schemas\BannerPlacementForm;
use App\Filament\Resources\BannerPlacements\Schemas\BannerPlacementInfolist;
use App\Filament\Resources\BannerPlacements\Tables\BannerPlacementsTable;
use App\Models\BannerPlacement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class BannerPlacementResource extends Resource
{
    protected static ?string $model = BannerPlacement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return BannerPlacementForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return BannerPlacementInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return BannerPlacementsTable::configure($table);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListBannerPlacements::route('/'),
            'create' => CreateBannerPlacement::route('/create'),
            'view' => ViewBannerPlacement::route('/{record}'),
            'edit' => EditBannerPlacement::route('/{record}/edit'),
        ];
    }
}
