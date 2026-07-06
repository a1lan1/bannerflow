<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Banner\CampaignStatusEnum;
use Database\Factories\BannerCampaignFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

/**
 * @property CampaignStatusEnum $status
 * @property-read Collection<int, Banner> $banners
 * @property-read int|null $banners_count
 *
 * @method static BannerCampaignFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerCampaign newModelQuery()
 * @method static Builder<static>|BannerCampaign newQuery()
 * @method static Builder<static>|BannerCampaign onlyTrashed()
 * @method static Builder<static>|BannerCampaign query()
 * @method static Builder<static>|BannerCampaign withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|BannerCampaign withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'slug',
    'description',
    'status',
    'starts_at',
    'ends_at',
])]
#[UseFactory(BannerCampaignFactory::class)]
#[Table(keyType: 'string', incrementing: false)]
class BannerCampaign extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    #[Override]
    protected function casts(): array
    {
        return [
            'status' => CampaignStatusEnum::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }
}
