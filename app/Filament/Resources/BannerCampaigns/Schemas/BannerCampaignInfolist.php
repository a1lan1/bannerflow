<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerCampaigns\Schemas;

use App\Models\BannerCampaign;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BannerCampaignInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campaign Details')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('slug'),
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('starts_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('ends_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn (BannerCampaign $record): bool => $record->trashed()),
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
                            ->hidden(fn (BannerCampaign $record): bool => $record->banners->isEmpty()),
                        TextEntry::make('no_banners')
                            ->label('No Banners Assigned')
                            ->hidden(fn (BannerCampaign $record): bool => $record->banners->isNotEmpty()),
                    ]),
            ]);
    }
}
