<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerStatistics\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BannerStatisticInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('banner.name')
                    ->label('Banner'),
                TextEntry::make('placement.name')
                    ->label('Placement'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('hour')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('impressions')
                    ->numeric(),
                TextEntry::make('clicks')
                    ->numeric(),
                TextEntry::make('ctr')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
