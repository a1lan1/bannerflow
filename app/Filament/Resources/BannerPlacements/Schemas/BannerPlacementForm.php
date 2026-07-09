<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerPlacements\Schemas;

use App\Enums\Banner\RotationStrategyEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BannerPlacementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('rotation_strategy')
                    ->options(RotationStrategyEnum::class)
                    ->default('weighted')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('max_banners')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
