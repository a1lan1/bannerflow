<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Banner\BannerEventTypeEnum;
use Database\Factories\BannerEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property BannerEventTypeEnum $type
 * @property-read Banner|null $banner
 * @property-read BannerPlacement|null $placement
 * @property-read User|null $user
 *
 * @method static BannerEventFactory factory($count = null, $state = [])
 * @method static Builder<static>|BannerEvent newModelQuery()
 * @method static Builder<static>|BannerEvent newQuery()
 * @method static Builder<static>|BannerEvent query()
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
class BannerEvent extends Model
{
    use HasFactory;
    use HasUlids;

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
