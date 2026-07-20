<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Banner\AggregateBannerStatisticsAction;
use App\Actions\Banner\RecordBannerClickAction;
use App\Actions\Banner\RecordBannerImpressionAction;
use App\Actions\Banner\SyncBannerScheduleAction;
use App\Interfaces\Actions\Banner\AggregateBannerStatisticsActionInterface;
use App\Interfaces\Actions\Banner\RecordBannerClickActionInterface;
use App\Interfaces\Actions\Banner\RecordBannerImpressionActionInterface;
use App\Interfaces\Actions\Banner\SyncBannerScheduleActionInterface;
use App\Interfaces\Services\Banner\BannerQueryServiceInterface;
use App\Interfaces\Services\Banner\BannerRotationServiceInterface;
use App\Interfaces\Services\Banner\BannerSelectionServiceInterface;
use App\Interfaces\Services\Banner\BannerTrackingServiceInterface;
use App\Services\Banner\BannerQueryService;
use App\Services\Banner\BannerRotationService;
use App\Services\Banner\BannerSelectionService;
use App\Services\Banner\BannerTrackingService;
use Illuminate\Support\ServiceProvider;
use Override;

class BannerServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<string, string>
     */
    public array $bindings = [
        // Banner Actions
        RecordBannerClickActionInterface::class => RecordBannerClickAction::class,
        RecordBannerImpressionActionInterface::class => RecordBannerImpressionAction::class,
        AggregateBannerStatisticsActionInterface::class => AggregateBannerStatisticsAction::class,
        SyncBannerScheduleActionInterface::class => SyncBannerScheduleAction::class,

        // Banner Services
        BannerQueryServiceInterface::class => BannerQueryService::class,
        BannerRotationServiceInterface::class => BannerRotationService::class,
        BannerSelectionServiceInterface::class => BannerSelectionService::class,
        BannerTrackingServiceInterface::class => BannerTrackingService::class,
    ];

    /**
     * Register services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
