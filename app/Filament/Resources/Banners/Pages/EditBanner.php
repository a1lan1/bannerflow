<?php

declare(strict_types=1);

namespace App\Filament\Resources\Banners\Pages;

use App\Actions\Banner\SyncBannerScheduleAction;
use App\Data\Banner\ScheduleData;
use App\Filament\Resources\Banners\BannerResource;
use App\Models\Banner;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;
use Spatie\LaravelData\DataCollection;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

    protected ?array $scheduleData = null;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    #[Override]
    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function afterSave(): void
    {
        if ($this->scheduleData !== null) {
            /** @var Banner $banner */
            $banner = $this->getRecord();

            resolve(SyncBannerScheduleAction::class)->execute(
                $banner,
                new DataCollection(ScheduleData::class, $this->scheduleData)
            );
        }
    }
}
