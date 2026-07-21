<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Banner;

use App\Data\Banner\BannerContext;
use App\Http\Controllers\Controller;
use App\Http\Resources\Banner\BannerResource;
use App\Models\Banner;
use App\Services\Banner\BannerRotationService;
use App\Services\Banner\BannerService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Random\RandomException;

class BannerController extends Controller
{
    public function __construct(
        private readonly BannerRotationService $rotationService,
        private readonly BannerService $bannerService,
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        return BannerResource::collection(
            $this->bannerService->getBannersForAutocomplete(
                $request->input('query')
            )
        );
    }

    /**
     * @throws RandomException
     */
    public function show(Request $request): BannerResource
    {
        $banner = $this->rotationService->getBanner(
            BannerContext::fromRequest($request)
        );

        abort_if(! $banner instanceof Banner, 404);

        return BannerResource::make($banner);
    }
}
