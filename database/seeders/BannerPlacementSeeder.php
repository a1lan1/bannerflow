<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BannerPlacement;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BannerPlacementSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        BannerPlacement::factory(random_int(5, 10))
            ->active()
            ->create();

        BannerPlacement::factory(random_int(5, 10))
            ->inactive()
            ->create();
    }
}
