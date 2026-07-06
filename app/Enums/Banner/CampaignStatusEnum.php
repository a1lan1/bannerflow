<?php

declare(strict_types=1);

namespace App\Enums\Banner;

enum CampaignStatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case PAUSED = 'paused';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::PAUSED => 'Paused',
            self::ARCHIVED => 'Archived',
        };
    }
}
