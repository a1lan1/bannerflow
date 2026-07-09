<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerPlacements\Schemas;

use App\Models\BannerPlacement;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BannerPlacementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Placement Details')
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),
                        TextEntry::make('name'),
                        TextEntry::make('slug'),
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('rotation_strategy')
                            ->badge(),
                        IconEntry::make('is_active')
                            ->boolean(),
                        TextEntry::make('max_banners')
                            ->numeric(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Associated Banners')
                    ->schema([
                        RepeatableEntry::make('banners')
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('slug'),
                            ])
                            ->columns(2)
                            ->hidden(fn (BannerPlacement $record): bool => $record->banners->isEmpty()),
                        TextEntry::make('no_banners')
                            ->label('No Banners Assigned')
                            ->hidden(fn (BannerPlacement $record): bool => $record->banners->isNotEmpty()),
                    ]),
            ]);
    }
}
