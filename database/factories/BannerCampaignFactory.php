<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Banner\CampaignStatusEnum;
use App\Models\BannerCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BannerCampaign>
 */
class BannerCampaignFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(CampaignStatusEnum::cases()),
            'starts_at' => $this->faker->optional()->dateTimeBetween('-1 month', '+1 month'),
            'ends_at' => $this->faker->optional()->dateTimeBetween('+1 month', '+6 months'),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    public function active(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => CampaignStatusEnum::ACTIVE,
        ]);
    }

    public function draft(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => CampaignStatusEnum::DRAFT,
        ]);
    }

    public function paused(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => CampaignStatusEnum::PAUSED,
        ]);
    }

    public function archived(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'status' => CampaignStatusEnum::ARCHIVED,
        ]);
    }
}
