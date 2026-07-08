<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Banner;
use App\Models\BannerSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BannerSchedule>
 */
class BannerScheduleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'banner_id' => Banner::factory(),
            'day_of_week' => $this->faker->numberBetween(0, 6),
            'hour' => $this->faker->numberBetween(0, 23),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
