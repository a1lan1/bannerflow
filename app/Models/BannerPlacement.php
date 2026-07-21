<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Banner\RotationStrategyEnum;
use Carbon\CarbonImmutable;
use Database\Factories\BannerPlacementFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property RotationStrategyEnum $rotation_strategy
 * @property bool $is_active
 * @property int $max_banners
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Banner> $banners
 * @property-read int|null $banners_count
 * @property-read Collection<int, BannerEvent> $events
 * @property-read int|null $events_count
 * @property-read Collection<int, BannerStatistic> $statistics
 * @property-read int|null $statistics_count
 *
 * @method static BannerPlacementFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerPlacement newModelQuery()
 * @method static Builder<static>|BannerPlacement newQuery()
 * @method static Builder<static>|BannerPlacement query()
 * @method static Builder<static>|BannerPlacement whereCreatedAt($value)
 * @method static Builder<static>|BannerPlacement whereDescription($value)
 * @method static Builder<static>|BannerPlacement whereId($value)
 * @method static Builder<static>|BannerPlacement whereIsActive($value)
 * @method static Builder<static>|BannerPlacement whereMaxBanners($value)
 * @method static Builder<static>|BannerPlacement whereName($value)
 * @method static Builder<static>|BannerPlacement whereRotationStrategy($value)
 * @method static Builder<static>|BannerPlacement whereSlug($value)
 * @method static Builder<static>|BannerPlacement whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'slug',
    'description',
    'rotation_strategy',
    'is_active',
    'max_banners',
])]
#[UseFactory(BannerPlacementFactory::class)]
#[Table(keyType: 'string', incrementing: false)]
class BannerPlacement extends Model
{
    use HasFactory;
    use HasUlids;

    #[Override]
    protected function casts(): array
    {
        return [
            'rotation_strategy' => RotationStrategyEnum::class,
            'is_active' => 'boolean',
        ];
    }

    public function banners(): BelongsToMany
    {
        return $this->belongsToMany(
            Banner::class,
            'banner_placement_banner',
            'placement_id',
            'banner_id'
        );
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
