<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Banner;

use App\Data\Banner\BannerContext;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\TrackBannerRequest;
use App\Interfaces\Services\Banner\BannerTrackingServiceInterface;
use App\Models\Banner;
use App\Models\BannerPlacement;
use Illuminate\Http\JsonResponse;

class TrackBannerController extends Controller
{
    public function __construct(
        private readonly BannerTrackingServiceInterface $trackingService,
    ) {}

    public function handleImpression(TrackBannerRequest $request, Banner $banner, BannerPlacement $placement): JsonResponse
    {
        $this->trackingService->trackImpression(
            banner: $banner,
            placement: $placement,
            context: BannerContext::fromRequest($request)
        );

        return response()->json(['message' => 'Impression recorded successfully']);
    }

    public function handleClick(TrackBannerRequest $request, Banner $banner, BannerPlacement $placement): JsonResponse
    {
        $this->trackingService->trackClick(
            banner: $banner,
            placement: $placement,
            context: BannerContext::fromRequest($request)
        );

        return response()->json(['message' => 'Click recorded successfully']);
    }
}
