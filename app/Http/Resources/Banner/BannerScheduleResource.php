<?php

declare(strict_types=1);

namespace App\Http\Resources\Banner;

use App\Models\BannerSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin BannerSchedule
 */
class BannerScheduleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'banner_id' => $this->banner_id,
            'day' => $this->day_of_week,
            'hour' => $this->hour,
        ];
    }
}
