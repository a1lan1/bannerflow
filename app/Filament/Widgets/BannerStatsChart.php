<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Banner;
use App\Models\BannerStatistic;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;
use Override;

class BannerStatsChart extends ChartWidget
{
    protected ?string $heading = 'Banner Statistics';

    protected static bool $isDiscovered = false;

    protected ?string $pollingInterval = '15s';

    protected ?string $maxHeight = '400px';

    public ?Banner $record = null;

    #[Override]
    protected function getData(): array
    {
        $getTrendQuery = function (): Builder {
            $query = BannerStatistic::query();
            if ($this->record instanceof Banner) {
                $query->where('banner_id', $this->record->id);
            }

            return $query;
        };

        $impressions = Trend::query($getTrendQuery())
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->sum('impressions');

        $clicks = Trend::query($getTrendQuery())
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->sum('clicks');

        return [
            'datasets' => [
                [
                    'label' => 'Impressions',
                    'data' => $impressions->map(fn (TrendValue $value): mixed => $value->aggregate),
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Clicks',
                    'data' => $clicks->map(fn (TrendValue $value): mixed => $value->aggregate),
                    'borderColor' => '#FF6384',
                ],
            ],
            'labels' => $impressions->map(fn (TrendValue $value): string => $value->date),
        ];
    }

    #[Override]
    protected function getType(): string
    {
        return 'line';
    }
}
