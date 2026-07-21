<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Banner;

use App\Data\Banner\ScheduleData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\UpdateBannerScheduleRequest;
use App\Http\Resources\Banner\BannerScheduleResource;
use App\Interfaces\Actions\Banner\SyncBannerScheduleActionInterface;
use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\LaravelData\DataCollection;

class BannerScheduleController extends Controller
{
    public function index(Banner $banner): AnonymousResourceCollection
    {
        return BannerScheduleResource::collection(
            $banner->load('schedule')->schedule
        );
    }

    public function update(
        UpdateBannerScheduleRequest $request,
        Banner $banner,
        SyncBannerScheduleActionInterface $syncBannerScheduleAction
    ): JsonResponse {
        $schedule = new DataCollection(ScheduleData::class, $request->array('schedule'));

        $syncBannerScheduleAction->execute($banner, $schedule);

        return response()->json(['message' => 'Schedule updated successfully.']);
    }
}
