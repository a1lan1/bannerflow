<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Banner\BannerStatusEnum;
use App\Enums\Banner\BannerTargetEnum;
use App\Enums\MediaCollection;
use App\Models\Banner;
use App\Models\BannerCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'campaign_id' => null,
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'link' => $this->faker->url(),
            'target' => $this->faker->randomElement(BannerTargetEnum::cases()),
            'alt' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(BannerStatusEnum::cases()),
            'priority' => $this->faker->numberBetween(0, 100),
            'weight' => $this->faker->numberBetween(1, 1000),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'max_impressions' => $this->faker->optional()->numberBetween(1000, 100000),
            'max_clicks' => $this->faker->optional()->numberBetween(100, 10000),
            'daily_impressions_limit' => $this->faker->optional()->numberBetween(100, 10000),
            'daily_clicks_limit' => $this->faker->optional()->numberBetween(10, 1000),
            'starts_at' => $this->faker->optional()->dateTimeBetween('-1 month', '+1 month'),
            'ends_at' => $this->faker->optional()->dateTimeBetween('+1 month', '+6 months'),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    public function active(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BannerStatusEnum::ACTIVE,
        ]);
    }

    public function draft(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BannerStatusEnum::DRAFT,
        ]);
    }

    public function archived(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BannerStatusEnum::ARCHIVED,
        ]);
    }

    public function paused(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BannerStatusEnum::PAUSED,
        ]);
    }

    public function withCampaign(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'campaign_id' => BannerCampaign::factory(),
        ]);
    }

    public function withDefaultImage(): Factory
    {
        return $this->afterCreating(function (Banner $banner): void {
            $files = File::glob(database_path('seeders/data/sample_banner_*.svg'));

            if (empty($files)) {
                return;
            }

            $randomFile = $files[array_rand($files)];

            $banner->addMedia($randomFile)
                ->preservingOriginal()
                ->toMediaCollection(MediaCollection::BannerImage->value);
        });
    }
}
