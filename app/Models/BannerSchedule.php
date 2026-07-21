<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\BannerScheduleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $banner_id
 * @property int $day_of_week
 * @property int $hour
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Banner|null $banner
 *
 * @method static BannerScheduleFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerSchedule newModelQuery()
 * @method static Builder<static>|BannerSchedule newQuery()
 * @method static Builder<static>|BannerSchedule query()
 * @method static Builder<static>|BannerSchedule whereBannerId($value)
 * @method static Builder<static>|BannerSchedule whereCreatedAt($value)
 * @method static Builder<static>|BannerSchedule whereDayOfWeek($value)
 * @method static Builder<static>|BannerSchedule whereHour($value)
 * @method static Builder<static>|BannerSchedule whereId($value)
 * @method static Builder<static>|BannerSchedule whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'banner_id',
    'day_of_week',
    'hour',
])]
#[UseFactory(BannerScheduleFactory::class)]
#[Table(keyType: 'string', incrementing: false)]
class BannerSchedule extends Model
{
    use HasFactory;
    use HasUlids;

    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }
}
