<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Override;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    #[Override]
    protected function getHeaderWidgets(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public function getWidgets(): array
    {
        return [
            //
        ];
    }
}
