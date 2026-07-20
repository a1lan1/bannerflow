<?php

declare(strict_types=1);

namespace App\Filament\Resources\Banners\Schemas;

use App\Enums\Banner\BannerStatusEnum;
use App\Enums\Banner\BannerTargetEnum;
use App\Enums\MediaCollection;
use App\Filament\Forms\Components\SchedulePicker;
use App\Models\Banner;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Banner Tabs')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('General')->schema([
                        Grid::make(2)->schema([
                            Section::make('Banner Details')->schema([
                                Select::make('campaign_id')
                                    ->relationship('campaign', 'name')
                                    ->nullable()
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('link')
                                    ->required()
                                    ->url()
                                    ->maxLength(255),
                                Select::make('target')
                                    ->options(BannerTargetEnum::class)
                                    ->default(BannerTargetEnum::BLANK)
                                    ->required(),
                                TextInput::make('alt')
                                    ->maxLength(255)
                                    ->nullable(),
                                Select::make('status')
                                    ->options(BannerStatusEnum::class)
                                    ->required(),
                                TextInput::make('priority')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('weight')
                                    ->required()
                                    ->numeric()
                                    ->default(100),
                                TextInput::make('sort_order')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                            ]),
                            Section::make('Limits and Schedule')->schema([
                                TextInput::make('max_impressions')
                                    ->numeric()
                                    ->nullable(),
                                TextInput::make('max_clicks')
                                    ->numeric()
                                    ->nullable(),
                                TextInput::make('daily_impressions_limit')
                                    ->numeric()
                                    ->nullable(),
                                TextInput::make('daily_clicks_limit')
                                    ->numeric()
                                    ->nullable(),
                                DateTimePicker::make('starts_at')
                                    ->nullable(),
                                DateTimePicker::make('ends_at')
                                    ->nullable(),
                            ]),
                        ]),
                    ]),
                    Tab::make('Placements')->schema([
                        Select::make('placements')
                            ->relationship('placements', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ]),
                    Tab::make('Media')->schema([
                        SpatieMediaLibraryFileUpload::make('banner_image')
                            ->collection(MediaCollection::BannerImage->value)
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('250')
                            ->panelLayout('compact')
                            ->required(),
                    ]),
                    Tab::make('Schedule')->schema([
                        SchedulePicker::make('schedule_data')
                            ->columnSpanFull()
                            ->afterStateHydrated(static function (Set $set, ?Banner $record): void {
                                if (! $record instanceof Banner) {
                                    $set('schedule_data', []);

                                    return;
                                }

                                $schedule = $record->schedule->map(fn ($item): string => sprintf('%s-%s', $item->day_of_week, $item->hour))->all();
                                $set('schedule_data', $schedule);
                            }),
                    ]),
                    Tab::make('Statistics')->schema([
                        TextInput::make('statistics_placeholder')
                            ->label('Statistics')
                            ->helperText('Aggregated banner statistics will be displayed here.')
                            ->disabled(),
                    ]),
                ]),
        ]);
    }
}
