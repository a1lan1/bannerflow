<?php

declare(strict_types=1);

namespace App\Enums;

enum MediaCollection: string
{
    // user
    case UserAvatar = 'user.avatar';
    case UserAvatarThumb = 'user.avatar-thumb';
    // banner
    case BannerImage = 'banner.image';
}
