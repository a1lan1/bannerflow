<?php

declare(strict_types=1);

namespace App\Models;

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
 * @property-read Banner|null $banner
 * @property-read BannerPlacement|null $placement
 *
 * @method static BannerStatisticFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerStatistic newModelQuery()
 * @method static Builder<static>|BannerStatistic newQuery()
 * @method static Builder<static>|BannerStatistic query()
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
