<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\BannerBuilder;
use App\Enums\Banner\BannerStatusEnum;
use App\Enums\Banner\BannerTargetEnum;
use App\Enums\MediaCollection;
use Carbon\CarbonImmutable;
use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $id
 * @property string|null $campaign_id
 * @property string $name
 * @property string $slug
 * @property string $link
 * @property BannerTargetEnum $target
 * @property string|null $alt
 * @property BannerStatusEnum $status
 * @property int $priority
 * @property int $weight
 * @property int $sort_order
 * @property int|null $max_impressions
 * @property int|null $max_clicks
 * @property int|null $daily_impressions_limit
 * @property int|null $daily_clicks_limit
 * @property CarbonImmutable|null $starts_at
 * @property CarbonImmutable|null $ends_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property-read float $average_ctr
 * @property-read BannerCampaign|null $campaign
 * @property-read Collection<int, BannerEvent> $events
 * @property-read int|null $events_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, BannerPlacement> $placements
 * @property-read int|null $placements_count
 * @property-read Collection<int, BannerSchedule> $schedule
 * @property-read int|null $schedule_count
 * @property-read array $schedule_data
 * @property-read Collection<int, BannerStatistic> $statistics
 * @property-read int|null $statistics_count
 * @property-read mixed $total_clicks
 * @property-read mixed $total_impressions
 * @property-read int|null $impressions_count
 * @property-read int|null $clicks_count
 * @property-read int|null $daily_impressions_count
 * @property-read int|null $daily_clicks_count
 *
 * @method static BannerBuilder<static>|Banner availableBySchedule()
 * @method static BannerFactory factory($count = null, $state = [])
 * @method static BannerBuilder<static>|Banner newModelQuery()
 * @method static BannerBuilder<static>|Banner newQuery()
 * @method static Builder<static>|Banner onlyTrashed()
 * @method static BannerBuilder<static>|Banner query()
 * @method static BannerBuilder<static>|Banner whereActive()
 * @method static BannerBuilder<static>|Banner whereAlt($value)
 * @method static BannerBuilder<static>|Banner whereAvailableNow()
 * @method static BannerBuilder<static>|Banner whereCampaignId($value)
 * @method static BannerBuilder<static>|Banner whereCreatedAt($value)
 * @method static BannerBuilder<static>|Banner whereDailyClicksLimit($value)
 * @method static BannerBuilder<static>|Banner whereDailyImpressionsLimit($value)
 * @method static BannerBuilder<static>|Banner whereDeletedAt($value)
 * @method static BannerBuilder<static>|Banner whereEndsAt($value)
 * @method static BannerBuilder<static>|Banner whereId($value)
 * @method static BannerBuilder<static>|Banner whereLink($value)
 * @method static BannerBuilder<static>|Banner whereMaxClicks($value)
 * @method static BannerBuilder<static>|Banner whereMaxImpressions($value)
 * @method static BannerBuilder<static>|Banner whereName($value)
 * @method static BannerBuilder<static>|Banner whereNotExpired()
 * @method static BannerBuilder<static>|Banner wherePriority($value)
 * @method static BannerBuilder<static>|Banner whereSearch(string $search)
 * @method static BannerBuilder<static>|Banner whereSlug($value)
 * @method static BannerBuilder<static>|Banner whereSortOrder($value)
 * @method static BannerBuilder<static>|Banner whereStarted()
 * @method static BannerBuilder<static>|Banner whereStartsAt($value)
 * @method static BannerBuilder<static>|Banner whereStatus($value)
 * @method static BannerBuilder<static>|Banner whereTarget($value)
 * @method static BannerBuilder<static>|Banner whereUpdatedAt($value)
 * @method static BannerBuilder<static>|Banner whereWeight($value)
 * @method static BannerBuilder<static>|Banner withEventCounts()
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
#[Appends(['total_impressions', 'total_clicks', 'average_ctr', 'schedule_data'])]
#[UseEloquentBuilder(BannerBuilder::class)]
#[Table(keyType: 'string', incrementing: false)]
class Banner extends Model implements HasMedia
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

    public function hasReachedLimits(): bool
    {
        return ($this->max_impressions !== null && $this->impressions_count >= $this->max_impressions)
            || ($this->max_clicks !== null && $this->clicks_count >= $this->max_clicks)
            || ($this->daily_impressions_limit !== null && $this->daily_impressions_count >= $this->daily_impressions_limit)
            || ($this->daily_clicks_limit !== null && $this->daily_clicks_count >= $this->daily_clicks_limit);
    }

    protected function totalImpressions(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->statistics->sum('impressions'),
        );
    }

    protected function totalClicks(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->statistics->sum('clicks'),
        );
    }

    protected function averageCtr(): Attribute
    {
        return Attribute::make(
            get: fn (): float => $this->total_impressions > 0
                ? round(($this->total_clicks / $this->total_impressions) * 100, 2)
                : 0.00,
        );
    }

    protected function scheduleData(): Attribute
    {
        return Attribute::make(
            get: fn (): array => $this->schedule
                ->map(fn (BannerSchedule $schedule): array => [
                    'day' => $schedule->day_of_week,
                    'hour' => $schedule->hour,
                ])
                ->all()
        );
    }
}
