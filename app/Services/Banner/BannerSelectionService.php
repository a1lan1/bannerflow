<?php

declare(strict_types=1);

namespace App\Services\Banner;

use App\Enums\Banner\RotationStrategyEnum;
use App\Interfaces\Services\Banner\BannerSelectionServiceInterface;
use App\Models\Banner;
use Illuminate\Support\Collection;
use Random\RandomException;

final readonly class BannerSelectionService implements BannerSelectionServiceInterface
{
    /**
     * @param  Collection<int, Banner>  $banners
     *
     * @throws RandomException
     */
    public function select(
        Collection $banners,
        RotationStrategyEnum $strategy,
    ): ?Banner {
        if ($banners->isEmpty()) {
            return null;
        }

        return match ($strategy) {
            RotationStrategyEnum::RANDOM => $this->random($banners),
            RotationStrategyEnum::WEIGHTED => $this->weighted($banners),
            RotationStrategyEnum::SEQUENTIAL => $this->sequential($banners),
        };
    }

    /**
     * @param  Collection<int, Banner>  $banners
     */
    private function random(Collection $banners): Banner
    {
        return $banners->random();
    }

    /**
     * @param  Collection<int, Banner>  $banners
     *
     * @throws RandomException
     */
    private function weighted(Collection $banners): Banner
    {
        $totalWeight = $banners->sum('weight');

        if ($totalWeight <= 0) {
            return $this->random($banners);
        }

        $random = random_int(1, $totalWeight);

        foreach ($banners as $banner) {
            $random -= $banner->weight;

            if ($random <= 0) {
                return $banner;
            }
        }

        return $banners->last();
    }

    /**
     * @param  Collection<int, Banner>  $banners
     */
    private function sequential(Collection $banners): Banner
    {
        return $banners
            ->sortBy('sort_order')
            ->first();
    }
}
