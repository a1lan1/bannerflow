<?php

declare(strict_types=1);

namespace App\Http\Requests\Banner;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateBannerScheduleRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<string>>
     */
    public function rules(): array
    {
        return [
            'schedule' => ['present', 'array'],
            'schedule.*.day' => ['required', 'integer', 'min:0', 'max:6'],
            'schedule.*.hour' => ['required', 'integer', 'min:0', 'max:23'],
        ];
    }

    #[Override]
    protected function passedValidation(): void
    {
        $this->merge([
            'schedule' => array_map(fn (array $item): array => [
                'day_of_week' => (int) $item['day'],
                'hour' => (int) $item['hour'],
            ], $this->input('schedule')),
        ]);
    }
}
