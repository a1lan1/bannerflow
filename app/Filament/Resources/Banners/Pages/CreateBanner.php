<?php

declare(strict_types=1);

namespace App\Filament\Resources\Banners\Pages;

use App\Data\Banner\ScheduleData;
use App\Filament\Resources\Banners\BannerResource;
use App\Interfaces\Actions\Banner\SyncBannerScheduleActionInterface;
use App\Models\Banner;
use Filament\Resources\Pages\CreateRecord;
use Override;
use Spatie\LaravelData\DataCollection;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

    protected ?array $scheduleData = null;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['schedule_data'])) {
            $this->scheduleData = array_map(function ($item): array {
                [$day, $hour] = explode('-', $item);

                return [
                    'day_of_week' => (int) $day,
                    'hour' => (int) $hour,
                ];
            }, $data['schedule_data']);

            unset($data['schedule_data']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->scheduleData !== null) {
            /** @var Banner $banner */
            $banner = $this->getRecord();

            resolve(SyncBannerScheduleActionInterface::class)->execute(
                $banner,
                new DataCollection(ScheduleData::class, $this->scheduleData)
            );
        }
    }
}
