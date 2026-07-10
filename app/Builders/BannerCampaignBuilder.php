<?php

declare(strict_types=1);

namespace App\Builders;

use App\Enums\Banner\CampaignStatusEnum;
use App\Models\BannerCampaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of BannerCampaign
 *
 * @extends Builder<TModelClass>
 */
class BannerCampaignBuilder extends Builder
{
    public function whereActive(): self
    {
        return $this->where('status', CampaignStatusEnum::ACTIVE);
    }
}
