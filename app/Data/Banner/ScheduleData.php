<?php

declare(strict_types=1);

namespace App\Data\Banner;

use Spatie\LaravelData\Data;

final class ScheduleData extends Data
{
    public function __construct(
        public readonly int $day_of_week,
        public readonly int $hour,
    ) {}
}
