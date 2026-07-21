<?php

declare(strict_types=1);

namespace App\Http\Resources\Banner;

use App\Enums\MediaCollection;
use App\Models\Banner;
use App\Models\BannerSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Banner
 */
class BannerResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'alt' => $this->whenHas('alt'),
            'link' => $this->whenHas('link'),
            'target' => $this->whenHas('target'),
            'image' => $this->getFirstMediaUrl(MediaCollection::BannerImage->value),
            'schedule_data' => $this->whenLoaded('schedule', fn () => $this->schedule->map(fn (BannerSchedule $schedule): array => [
                'day' => $schedule->day_of_week,
                'hour' => $schedule->hour,
            ])),
        ];
    }
}
