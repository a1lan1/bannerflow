<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerCampaign;
use App\Models\BannerPlacement;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BannerSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        // Create banners without campaigns
        Banner::factory(10)->create();

        // Create banners with existing campaigns
        BannerCampaign::all()->each(function (BannerCampaign $campaign): void {
            Banner::factory(random_int(1, 5))
                ->for($campaign, 'campaign')
                ->create();
        });

        // Attach banners to placements
        $banners = Banner::all();
        BannerPlacement::all()->each(function (BannerPlacement $placement) use ($banners): void {
            $placement->banners()->attach(
                $banners->random(
                    random_int(1, min(5, $banners->count()))
                )->pluck('id')->toArray()
            );
        });
    }
}
