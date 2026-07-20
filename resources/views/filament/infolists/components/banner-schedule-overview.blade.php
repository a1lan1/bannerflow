<x-filament-infolists::entry-wrapper :entry="$entry">
    <div class="p-4 bg-white rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Schedule Overview</h3>
        </div>

        @php
            $daysOfWeek = [
                0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
                4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
            ];
            $hoursOfDay = range(0, 23);

            $activeSchedule = collect($record->schedule_data)
                ->map(fn($item) => "{$item['day']}-{$item['hour']}")
                ->toArray();
        @endphp

        <div class="grid grid-cols-[auto_repeat(24,_minmax(0,_1fr))] gap-1 text-center text-xs">
            {{-- Corner cell --}}
            <div class="p-1 font-semibold text-gray-700"></div>

            {{-- Hour headers --}}
            @foreach($hoursOfDay as $hour)
                <div class="p-1 font-semibold text-gray-700">
                    {{ str_pad((string) $hour, 2, '0', STR_PAD_LEFT) }}
                </div>
            @endforeach

            {{-- Day rows --}}
            @foreach($daysOfWeek as $dayIndex => $dayName)
                {{-- Day header --}}
                <div class="p-1 font-semibold text-gray-700 text-left">
                    {{ $dayName }}
                </div>

                {{-- Hour cells --}}
                @foreach($hoursOfDay as $hour)
                    <div class="p-1 border border-gray-200 rounded-sm
                        {{ in_array("{$dayIndex}-{$hour}", $activeSchedule) ? 'bg-indigo-500' : 'bg-gray-50' }}"
                        title="{{ $dayName }}, {{ str_pad((string) $hour, 2, '0', STR_PAD_LEFT) }}:00"
                    ></div>
                @endforeach
            @endforeach
        </div>
    </div>
</x-filament-infolists::entry-wrapper>
