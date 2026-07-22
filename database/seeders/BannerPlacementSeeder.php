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
        $placements = [
            ['name' => 'Header Banner', 'slug' => 'header-banner'],
            ['name' => 'Sidebar Banner', 'slug' => 'sidebar-banner'],
            ['name' => 'Footer Banner', 'slug' => 'footer-banner'],
        ];

        foreach ($placements as $placement) {
            BannerPlacement::factory()
                ->active()
                ->create($placement);
        }
    }
}
