<?php

declare(strict_types=1);

namespace App\Services\Banner;

use App\Interfaces\Services\Banner\BannerQueryServiceInterface;
use App\Models\Banner;
use App\Models\BannerPlacement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final readonly class BannerQueryService implements BannerQueryServiceInterface
{
    public function getAvailableBannersForPlacement(BannerPlacement $placement): Collection
    {
        return Banner::query()
            ->whereHas('placements', fn (Builder $q) => $q->where('id', $placement->id))
            ->with(['media'])
            ->where(function (Builder $query): void {
                $query->whereAvailableNow()
                    ->orWhereHas('campaign', fn (Builder $q) => $q->whereActive());
            })
            ->availableBySchedule()
            ->withEventCounts()
            ->get()
            ->reject(fn (Banner $banner): bool => $banner->hasReachedLimits());
    }
}
