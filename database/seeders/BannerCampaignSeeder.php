<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BannerCampaign;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BannerCampaignSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        BannerCampaign::factory(random_int(5, 10))
            ->active()
            ->create();

        BannerCampaign::factory(random_int(5, 10))
            ->draft()
            ->create();

        BannerCampaign::factory(random_int(5, 10))
            ->paused()
            ->create();

        BannerCampaign::factory(random_int(5, 10))
            ->archived()
            ->create();
    }
}
