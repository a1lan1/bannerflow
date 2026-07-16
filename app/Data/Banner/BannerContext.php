<?php

declare(strict_types=1);

namespace App\Data\Banner;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
final class BannerContext extends Data
{
    public function __construct(
        public readonly ?string $placement = null,
        public readonly ?string $sessionId = null,
        public readonly ?string $ip = null,
        public readonly ?string $country = null,
        public readonly ?string $locale = null,
        public readonly ?string $timezone = null,
        public readonly ?string $device = null,
        public readonly ?string $operatingSystem = null,
        public readonly ?string $browser = null,
        public readonly ?string $userAgent = null,
        public readonly ?string $screen = null,
        public readonly ?string $referer = null,
        public readonly ?string $utmSource = null,
        public readonly ?string $utmMedium = null,
        public readonly ?string $utmCampaign = null,
        public readonly ?string $utmTerm = null,
        public readonly ?string $utmContent = null,
        public readonly ?array $metadata = null,
        public readonly ?User $user = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            placement: $request->route('placement'),
            sessionId: $request->session()->getId(),
            ip: $request->ip(),
            country: $request->header('CF-IPCountry'),
            locale: $request->getPreferredLanguage(),
            timezone: $request->header('X-Timezone'),
            device: $request->header('X-Device'),
            operatingSystem: $request->header('X-Operating-System'),
            browser: $request->header('X-Browser'),
            userAgent: $request->userAgent(),
            screen: $request->header('X-Screen'),
            referer: $request->headers->get('referer'),
            utmSource: $request->input('utm_source'),
            utmMedium: $request->input('utm_medium'),
            utmCampaign: $request->input('utm_campaign'),
            utmTerm: $request->input('utm_term'),
            utmContent: $request->input('utm_content'),
            metadata: $request->input('metadata'),
            user: $request->user(),
        );
    }

    public function toDatabaseArray(): array
    {
        return [
            'user_id' => $this->user?->id,
            'session_id' => $this->sessionId,
            'ip' => $this->ip,
            'country' => $this->country,
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'device' => $this->device,
            'operating_system' => $this->operatingSystem,
            'browser' => $this->browser,
            'user_agent' => $this->userAgent,
            'screen' => $this->screen,
            'referer' => $this->referer,
            'utm_source' => $this->utmSource,
            'utm_medium' => $this->utmMedium,
            'utm_campaign' => $this->utmCampaign,
            'utm_term' => $this->utmTerm,
            'utm_content' => $this->utmContent,
            'metadata' => $this->metadata,
        ];
    }
}
