<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\BannerStatisticFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property string $id
 * @property string $banner_id
 * @property string $placement_id
 * @property CarbonImmutable $date
 * @property int|null $hour
 * @property int $impressions
 * @property int $clicks
 * @property numeric $ctr
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Banner|null $banner
 * @property-read BannerPlacement $placement
 *
 * @method static BannerStatisticFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerStatistic newModelQuery()
 * @method static Builder<static>|BannerStatistic newQuery()
 * @method static Builder<static>|BannerStatistic query()
 * @method static Builder<static>|BannerStatistic whereBannerId($value)
 * @method static Builder<static>|BannerStatistic whereClicks($value)
 * @method static Builder<static>|BannerStatistic whereCreatedAt($value)
 * @method static Builder<static>|BannerStatistic whereCtr($value)
 * @method static Builder<static>|BannerStatistic whereDate($value)
 * @method static Builder<static>|BannerStatistic whereHour($value)
 * @method static Builder<static>|BannerStatistic whereId($value)
 * @method static Builder<static>|BannerStatistic whereImpressions($value)
 * @method static Builder<static>|BannerStatistic wherePlacementId($value)
 * @method static Builder<static>|BannerStatistic whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'banner_id',
    'placement_id',
    'date',
    'hour',
    'impressions',
    'clicks',
    'ctr',
])]
#[UseFactory(BannerStatisticFactory::class)]
#[Table(keyType: 'string', incrementing: false)]
class BannerStatistic extends Model
{
    use HasFactory;
    use HasUlids;

    #[Override]
    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    public function placement(): BelongsTo
    {
        return $this->belongsTo(BannerPlacement::class);
    }
}
