<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerSchedule;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BannerScheduleSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        Banner::all()->each(function (Banner $banner): void {
            // Create an array of all possible combinations
            $availableSlots = [];

            for ($day = 0; $day <= 6; $day++) {
                for ($hour = 0; $hour <= 23; $hour++) {
                    $availableSlots[] = [
                        'day_of_week' => $day,
                        'hour' => $hour,
                    ];
                }
            }

            // Mix and take a random amount (1-7)
            shuffle($availableSlots);

            $slotsToCreate = match (random_int(1, 10)) {
                1, 2 => random_int(40, 55), // 20% of banners are very active
                3, 4, 5 => random_int(22, 38), // 30% - middle
                default => random_int(8, 20), // 50% — rare
            };

            $selectedSlots = array_slice($availableSlots, 0, $slotsToCreate);

            foreach ($selectedSlots as $slot) {
                BannerSchedule::factory()
                    ->for($banner)
                    ->create([
                        'day_of_week' => $slot['day_of_week'],
                        'hour' => $slot['hour'],
                    ]);
            }
        });
    }
}
