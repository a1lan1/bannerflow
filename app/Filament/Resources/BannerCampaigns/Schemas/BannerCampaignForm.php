<?php

declare(strict_types=1);

namespace App\Filament\Resources\BannerCampaigns\Schemas;

use App\Enums\Banner\CampaignStatusEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BannerCampaignForm
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
                Select::make('status')
                    ->options(CampaignStatusEnum::class)
                    ->required(),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
            ]);
    }
}
