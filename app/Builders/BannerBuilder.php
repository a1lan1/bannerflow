<?php

declare(strict_types=1);

namespace App\Builders;

use App\Enums\Banner\BannerEventTypeEnum;
use App\Enums\Banner\BannerStatusEnum;
use App\Models\Banner;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of Banner
 *
 * @extends Builder<TModelClass>
 */
class BannerBuilder extends Builder
{
    public function whereSearch(string $search): self
    {
        $searchTerm = strtolower($search);

        return $this->where(function (Builder $q) use ($searchTerm): void {
            $q->whereRaw('LOWER(name) LIKE ?', ['%'.$searchTerm.'%'])
                ->orWhereHas('campaign', function (Builder $companyQuery) use ($searchTerm): void {
                    $companyQuery->whereRaw('LOWER(name) LIKE ?', ['%'.$searchTerm.'%']);
                });
        });
    }

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
        return $this->where(function (Builder $query): void {
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

    public function withEventCounts(): self
    {
        return $this->withCount([
            'events as impressions_count' => fn (Builder $q) => $q->where('type', BannerEventTypeEnum::IMPRESSION),
            'events as clicks_count' => fn (Builder $q) => $q->where('type', BannerEventTypeEnum::CLICK),
            'events as daily_impressions_count' => fn (Builder $q) => $q->where('type', BannerEventTypeEnum::IMPRESSION)->whereDate('created_at', today()),
            'events as daily_clicks_count' => fn (Builder $q) => $q->where('type', BannerEventTypeEnum::CLICK)->whereDate('created_at', today()),
        ]);
    }

    public function availableBySchedule(): self
    {
        $now = now();

        return $this->where(function (Builder $query) use ($now): void {
            $query->whereDoesntHave('schedule')
                ->orWhereHas('schedule', function (Builder $q) use ($now): void {
                    $q->where('day_of_week', $now->dayOfWeek)
                        ->where('hour', $now->hour);
                });
        });
    }
}
