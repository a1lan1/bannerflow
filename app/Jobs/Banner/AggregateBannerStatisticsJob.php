<?php

declare(strict_types=1);

namespace App\Jobs\Banner;

use App\Actions\Banner\AggregateBannerStatisticsAction;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AggregateBannerStatisticsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public ?Carbon $date = null) {}

    public function handle(AggregateBannerStatisticsAction $action): void
    {
        $action->execute($this->date);
    }
}
