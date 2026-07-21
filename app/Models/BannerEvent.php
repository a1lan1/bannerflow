<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Banner\BannerEventTypeEnum;
use Carbon\CarbonImmutable;
use Database\Factories\BannerEventFactory;
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
 * @property string|null $user_id
 * @property BannerEventTypeEnum $type
 * @property string|null $session_id
 * @property string|null $ip
 * @property string|null $country
 * @property string|null $device
 * @property int|null $is_mobile
 * @property string|null $browser
 * @property string|null $operating_system
 * @property string|null $user_agent
 * @property string|null $locale
 * @property string|null $timezone
 * @property string|null $screen
 * @property string|null $referer
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $utm_term
 * @property string|null $utm_content
 * @property array<array-key, mixed>|null $metadata
 * @property CarbonImmutable $created_at
 * @property-read Banner|null $banner
 * @property-read BannerPlacement $placement
 * @property-read User|null $user
 *
 * @method static BannerEventFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerEvent newModelQuery()
 * @method static Builder<static>|BannerEvent newQuery()
 * @method static Builder<static>|BannerEvent query()
 * @method static Builder<static>|BannerEvent whereBannerId($value)
 * @method static Builder<static>|BannerEvent whereBrowser($value)
 * @method static Builder<static>|BannerEvent whereCountry($value)
 * @method static Builder<static>|BannerEvent whereCreatedAt($value)
 * @method static Builder<static>|BannerEvent whereDevice($value)
 * @method static Builder<static>|BannerEvent whereId($value)
 * @method static Builder<static>|BannerEvent whereIp($value)
 * @method static Builder<static>|BannerEvent whereIsMobile($value)
 * @method static Builder<static>|BannerEvent whereLocale($value)
 * @method static Builder<static>|BannerEvent whereMetadata($value)
 * @method static Builder<static>|BannerEvent whereOperatingSystem($value)
 * @method static Builder<static>|BannerEvent wherePlacementId($value)
 * @method static Builder<static>|BannerEvent whereReferer($value)
 * @method static Builder<static>|BannerEvent whereScreen($value)
 * @method static Builder<static>|BannerEvent whereSessionId($value)
 * @method static Builder<static>|BannerEvent whereTimezone($value)
 * @method static Builder<static>|BannerEvent whereType($value)
 * @method static Builder<static>|BannerEvent whereUserAgent($value)
 * @method static Builder<static>|BannerEvent whereUserId($value)
 * @method static Builder<static>|BannerEvent whereUtmCampaign($value)
 * @method static Builder<static>|BannerEvent whereUtmContent($value)
 * @method static Builder<static>|BannerEvent whereUtmMedium($value)
 * @method static Builder<static>|BannerEvent whereUtmSource($value)
 * @method static Builder<static>|BannerEvent whereUtmTerm($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'banner_id',
    'placement_id',
    'user_id',
    'type',
    'session_id',
    'ip',
    'country',
    'device',
    'is_mobile',
    'browser',
    'operating_system',
    'user_agent',
    'locale',
    'timezone',
    'screen',
    'referer',
    'utm_source',
    'utm_medium',
    'utm_campaign',
    'utm_term',
    'utm_content',
    'metadata',
])]
#[UseFactory(BannerEventFactory::class)]
#[Table(keyType: 'string', incrementing: false)]
class BannerEvent extends Model
{
    use HasFactory;
    use HasUlids;

    public const null UPDATED_AT = null;

    #[Override]
    protected function casts(): array
    {
        return [
            'type' => BannerEventTypeEnum::class,
            'metadata' => 'array',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
