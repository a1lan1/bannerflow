<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\BannerBuilder;
use App\Enums\Banner\BannerStatusEnum;
use App\Enums\Banner\BannerTargetEnum;
use App\Enums\MediaCollection;
use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property BannerStatusEnum $status
 * @property BannerTargetEnum $target
 * @property-read BannerCampaign|null $campaign
 * @property-read Collection<int, BannerEvent> $events
 * @property-read int|null $events_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, BannerPlacement> $placements
 * @property-read int|null $placements_count
 * @property-read Collection<int, BannerSchedule> $schedule
 * @property-read int|null $schedule_count
 * @property-read Collection<int, BannerStatistic> $statistics
 * @property-read int|null $statistics_count
 *
 * @method static BannerFactory factory($count = null, $state = [])
 * @method static BannerBuilder<static>|Banner newModelQuery()
 * @method static BannerBuilder<static>|Banner newQuery()
 * @method static Builder<static>|Banner onlyTrashed()
 * @method static BannerBuilder<static>|Banner query()
 * @method static BannerBuilder<static>|Banner whereActive()
 * @method static BannerBuilder<static>|Banner whereAvailableNow()
 * @method static BannerBuilder<static>|Banner whereNotExpired()
 * @method static BannerBuilder<static>|Banner whereStarted()
 * @method static Builder<static>|Banner withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Banner withoutTrashed()
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'campaign_id',
    'name',
    'slug',
    'link',
    'target',
    'alt',
    'status',
    'priority',
    'weight',
    'sort_order',
    'max_impressions',
    'max_clicks',
    'daily_impressions_limit',
    'daily_clicks_limit',
    'starts_at',
    'ends_at',
])]
#[UseFactory(BannerFactory::class)]
#[UseEloquentBuilder(BannerBuilder::class)]
#[Table(keyType: 'string', incrementing: false)]
class Banner extends Model
{
    use HasFactory;
    use HasUlids;
    use InteractsWithMedia;
    use SoftDeletes;

    #[Override]
    protected function casts(): array
    {
        return [
            'status' => BannerStatusEnum::class,
            'target' => BannerTargetEnum::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollection::BannerImage->value)
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'image/avif',
                'image/svg+xml',
            ])
            ->singleFile();
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(BannerCampaign::class);
    }

    public function placements(): BelongsToMany
    {
        return $this->belongsToMany(
            BannerPlacement::class,
            'banner_placement_banner',
            'banner_id',
            'placement_id'
        );
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(BannerSchedule::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(BannerEvent::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(BannerStatistic::class);
    }
}
