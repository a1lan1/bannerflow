<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Override;

class StatsOverview extends StatsOverviewWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $pollingInterval = '15s';

    #[Override]
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All users in the system')
                ->color('success'),
        ];
    }
}
