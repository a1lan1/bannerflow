<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\BannerEvent;
use App\Models\BannerPlacement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class BannerEventSeeder extends Seeder
{
    /**
     * @throws RandomException
     */
    public function run(): void
    {
        $users = User::all();
        $banners = Banner::all();
        $placements = BannerPlacement::all();

        if ($banners->isEmpty() || $placements->isEmpty() || $users->isEmpty()) {
            $this->command->error('No banners, placements or users to associate events found. Please run DatabaseSeeder first.');

            return;
        }

        foreach ($banners as $banner) {
            foreach ($placements as $placement) {
                for ($i = 0; $i < random_int(5, 10); $i++) {
                    BannerEvent::factory()->create([
                        'banner_id' => $banner->id,
                        'placement_id' => $placement->id,
                        'user_id' => $users->random()->id,
                    ]);
                }
            }
        }
    }
}
