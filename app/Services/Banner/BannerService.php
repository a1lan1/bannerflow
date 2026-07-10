<?php

declare(strict_types=1);

namespace App\Services\Banner;

use App\Builders\BannerBuilder;
use App\Models\Banner;
use Illuminate\Pagination\Paginator;

final readonly class BannerService
{
    public function getBannersForAutocomplete(?string $searchQuery): Paginator
    {
        return Banner::query()
            ->select(['id', 'name'])
            ->whereAvailableNow()
            ->when($searchQuery, fn (BannerBuilder $query, string $search): BannerBuilder => $query->whereSearch($search))
            ->simplePaginate(10);
    }
}
