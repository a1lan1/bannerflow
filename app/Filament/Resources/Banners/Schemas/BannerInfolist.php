<?php

declare(strict_types=1);

namespace App\Filament\Resources\Banners\Schemas;

use App\Enums\MediaCollection;
use App\Models\Banner;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BannerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Banner Details')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Banner Information')
                                            ->schema([
                                                TextEntry::make('name'),
                                                TextEntry::make('slug'),
                                                TextEntry::make('link')
                                                    ->url(fn (Banner $record): string => $record->link)
                                                    ->openUrlInNewTab(),
                                                TextEntry::make('target')
                                                    ->badge(),
                                                TextEntry::make('alt')
                                                    ->placeholder('-'),
                                                TextEntry::make('status')
                                                    ->badge(),
                                                TextEntry::make('priority')
                                                    ->numeric(),
                                                TextEntry::make('weight')
                                                    ->numeric(),
                                                TextEntry::make('sort_order')
                                                    ->numeric(),
                                                TextEntry::make('campaign.name')
                                                    ->label('Campaign')
                                                    ->placeholder('-'),
                                            ]),
                                        Section::make('Image')
                                            ->schema([
                                                SpatieMediaLibraryImageEntry::make('banner_image')
                                                    ->collection(MediaCollection::BannerImage->value)
                                                    ->label('Banner Image')
                                                    ->width('100%')
                                                    ->height('auto'),
                                            ]),
                                    ]),
                                Section::make('Limits and Schedule')
                                    ->schema([
                                        TextEntry::make('max_impressions')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('max_clicks')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('daily_impressions_limit')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('daily_clicks_limit')
                                            ->numeric()
                                            ->placeholder('-'),
                                        TextEntry::make('starts_at')
                                            ->dateTime()
                                            ->placeholder('-'),
                                        TextEntry::make('ends_at')
                                            ->dateTime()
                                            ->placeholder('-'),
                                    ]),
                            ]),
                        Tab::make('Placements')
                            ->schema([
                                RepeatableEntry::make('placements')
                                    ->schema([
                                        TextEntry::make('name'),
                                        TextEntry::make('slug'),
                                    ])
                                    ->columns(2)
                                    ->hidden(fn (Banner $record): bool => $record->placements->isEmpty()),
                                TextEntry::make('no_placements')
                                    ->label('No Placements Assigned')
                                    ->hidden(fn (Banner $record): bool => $record->placements->isNotEmpty()),
                            ]),
                        Tab::make('Schedule')
                            ->schema([
                                ViewEntry::make('schedule_overview')
                                    ->view('filament.infolists.components.banner-schedule-overview')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Statistics')
                            ->schema([
                                ViewEntry::make('statistics_chart')
                                    ->view('filament.infolists.components.banner-stats-chart')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
