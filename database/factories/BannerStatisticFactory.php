<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Banner;
use App\Models\BannerPlacement;
use App\Models\BannerStatistic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BannerStatistic>
 */
class BannerStatisticFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $impressions = $this->faker->numberBetween(100, 10000);
        $clicks = $this->faker->numberBetween(1, $impressions / 10); // Clicks should be less than impressions
        $ctr = ($impressions > 0) ? ($clicks / $impressions) * 100 : 0;

        return [
            'banner_id' => Banner::factory(),
            'placement_id' => BannerPlacement::factory(),
            'date' => $this->faker->date(),
            'hour' => $this->faker->optional()->numberBetween(0, 23),
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => $ctr,
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
