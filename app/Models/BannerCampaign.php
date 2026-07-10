<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\BannerCampaignBuilder;
use App\Enums\Banner\CampaignStatusEnum;
use Carbon\CarbonImmutable;
use Database\Factories\BannerCampaignFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
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
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property CampaignStatusEnum $status
 * @property CarbonImmutable|null $starts_at
 * @property CarbonImmutable|null $ends_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property-read Collection<int, Banner> $banners
 * @property-read int|null $banners_count
 *
 * @method static BannerCampaignFactory factory($count = null, $state = [])
 * @method static BannerCampaignBuilder<static>|BannerCampaign newModelQuery()
 * @method static BannerCampaignBuilder<static>|BannerCampaign newQuery()
 * @method static Builder<static>|BannerCampaign onlyTrashed()
 * @method static BannerCampaignBuilder<static>|BannerCampaign query()
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereActive()
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereCreatedAt($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereDeletedAt($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereDescription($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereEndsAt($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereId($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereName($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereSlug($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereStartsAt($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereStatus($value)
 * @method static BannerCampaignBuilder<static>|BannerCampaign whereUpdatedAt($value)
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
#[UseEloquentBuilder(BannerCampaignBuilder::class)]
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
        return $this->hasMany(Banner::class, 'campaign_id');
    }
}
