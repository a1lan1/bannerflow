<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Banner\BannerEventTypeEnum;
use App\Models\Banner;
use App\Models\BannerEvent;
use App\Models\BannerPlacement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BannerEvent>
 */
class BannerEventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) Str::ulid(),
            'banner_id' => Banner::factory(),
            'placement_id' => BannerPlacement::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(BannerEventTypeEnum::cases()),
            'session_id' => Str::random(32),
            'ip' => $this->faker->ipv4(),
            'country' => $this->faker->countryCode(),
            'device' => $this->faker->randomElement(['desktop', 'mobile', 'tablet']),
            'is_mobile' => $this->faker->boolean(),
            'browser' => $this->faker->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge']),
            'operating_system' => $this->faker->randomElement(['Windows', 'macOS', 'Linux', 'Android', 'iOS']),
            'user_agent' => $this->faker->userAgent(),
            'locale' => $this->faker->locale(),
            'timezone' => $this->faker->timezone(),
            'screen' => $this->faker->randomElement(['1920x1080', '1366x768', '375x667']),
            'referer' => $this->faker->url(),
            'utm_source' => $this->faker->word(),
            'utm_medium' => $this->faker->word(),
            'utm_campaign' => $this->faker->word(),
            'utm_term' => $this->faker->word(),
            'utm_content' => $this->faker->word(),
            'metadata' => json_encode(['key' => 'value']),
            'created_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
