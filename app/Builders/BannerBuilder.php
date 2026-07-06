<?php

declare(strict_types=1);

namespace App\Builders;

use App\Enums\Banner\BannerStatusEnum;
use Illuminate\Database\Eloquent\Builder;

class BannerBuilder extends Builder
{
    /**
     * Только активные (status = 'active').
     */
    public function whereActive(): self
    {
        return $this->where('status', BannerStatusEnum::ACTIVE);
    }

    /**
     * Баннеры, у которых уже наступило время старта
     * (starts_at <= now или starts_at is null).
     */
    public function whereStarted(): self
    {
        return $this->where(function ($query): void {
            $query->whereNull('starts_at')
                ->orWhere('starts_at', '<=', now());
        });
    }

    /**
     * Баннеры, которые ещё не закончились
     * (ends_at > now или ends_at is null).
     */
    public function whereNotExpired(): self
    {
        return $this->where(function ($query): void {
            $query->whereNull('ends_at')
                ->orWhere('ends_at', '>', now());
        });
    }

    /**
     * Баннеры, доступные прямо сейчас:
     * активные + уже начались + ещё не истекли.
     */
    public function whereAvailableNow(): self
    {
        return $this
            ->whereActive()
            ->whereStarted()
            ->whereNotExpired();
    }
}
