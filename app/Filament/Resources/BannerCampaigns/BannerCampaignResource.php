<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerCampaigns;

use App\Filament\Resources\BannerCampaigns\Pages\CreateBannerCampaign;
use App\Filament\Resources\BannerCampaigns\Pages\EditBannerCampaign;
use App\Filament\Resources\BannerCampaigns\Pages\ListBannerCampaigns;
use App\Filament\Resources\BannerCampaigns\Pages\ViewBannerCampaign;
use App\Filament\Resources\BannerCampaigns\Schemas\BannerCampaignForm;
use App\Filament\Resources\BannerCampaigns\Schemas\BannerCampaignInfolist;
use App\Filament\Resources\BannerCampaigns\Tables\BannerCampaignsTable;
use App\Models\BannerCampaign;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Override;

class BannerCampaignResource extends Resource
{
    protected static ?string $model = BannerCampaign::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return BannerCampaignForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return BannerCampaignInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return BannerCampaignsTable::configure($table);
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
            'index' => ListBannerCampaigns::route('/'),
            'create' => CreateBannerCampaign::route('/create'),
            'view' => ViewBannerCampaign::route('/{record}'),
            'edit' => EditBannerCampaign::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->with(['banners']);
    }
}
