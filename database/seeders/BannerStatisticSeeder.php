<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerPlacement;
use App\Models\BannerStatistic;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BannerStatisticSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        $banners = Banner::all();
        $placements = BannerPlacement::all();

        if ($banners->isEmpty() || $placements->isEmpty()) {
            $this->command->error('No banners or placements found. Please run DatabaseSeeder first.');

            return;
        }

        foreach ($banners as $banner) {
            foreach ($placements as $placement) {
                BannerStatistic::factory(random_int(1, 10))
                    ->for($banner)
                    ->for($placement, 'placement')
                    ->create();
            }
        }
    }
}
