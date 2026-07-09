<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerStatistics\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BannerStatisticsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('banner.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('placement.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('hour')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('impressions')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('clicks')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ctr')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('banner_id')
                    ->relationship('banner', 'name')
                    ->label('Banner')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('placement_id')
                    ->relationship('placement', 'name')
                    ->label('Placement')
                    ->searchable()
                    ->preload(),
            ]);
    }
}
