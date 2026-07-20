<?php

declare(strict_types=1);

namespace App\Services\Banner;

use App\Data\Banner\BannerContext;
use App\Interfaces\Services\Banner\BannerQueryServiceInterface;
use App\Interfaces\Services\Banner\BannerRotationServiceInterface;
use App\Interfaces\Services\Banner\BannerSelectionServiceInterface;
use App\Models\Banner;
use App\Models\BannerPlacement;
use Random\RandomException;

final readonly class BannerRotationService implements BannerRotationServiceInterface
{
    public function __construct(
        private BannerQueryServiceInterface $queryService,
        private BannerSelectionServiceInterface $selectionService,
    ) {}

    /**
     * @throws RandomException
     */
    public function getBanner(BannerContext $context): ?Banner
    {
        /** @var BannerPlacement|null $placement */
        $placement = BannerPlacement::query()
            ->where('slug', $context->placement)
            ->where('is_active', true)
            ->first();

        if (! $placement) {
            return null;
        }

        $banners = $this->queryService->getAvailableBannersForPlacement($placement);

        if ($banners->isEmpty()) {
            return null;
        }

        return $this->selectionService->select(
            $banners,
            $placement->rotation_strategy,
        );
    }
}
