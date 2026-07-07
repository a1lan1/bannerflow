<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Banner\RotationStrategyEnum;
use App\Models\BannerPlacement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BannerPlacement>
 */
class BannerPlacementFactory extends Factory
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
            'rotation_strategy' => $this->faker->randomElement(RotationStrategyEnum::cases()),
            'is_active' => $this->faker->boolean(),
            'max_banners' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }

    public function active(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => true,
        ]);
    }

    public function inactive(): Factory
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
