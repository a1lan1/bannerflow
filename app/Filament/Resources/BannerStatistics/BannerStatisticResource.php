<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerStatistics;

use App\Filament\Resources\BannerStatistics\Pages\ListBannerStatistics;
use App\Filament\Resources\BannerStatistics\Pages\ViewBannerStatistic;
use App\Filament\Resources\BannerStatistics\Schemas\BannerStatisticInfolist;
use App\Filament\Resources\BannerStatistics\Tables\BannerStatisticsTable;
use App\Models\BannerStatistic;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class BannerStatisticResource extends Resource
{
    protected static ?string $model = BannerStatistic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return BannerStatisticInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return BannerStatisticsTable::configure($table);
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
            'index' => ListBannerStatistics::route('/'),
            'view' => ViewBannerStatistic::route('/{record}'),
        ];
    }
}
