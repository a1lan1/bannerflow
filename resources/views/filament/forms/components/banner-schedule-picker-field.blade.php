<x-filament-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @php
        $daysOfWeek = [
            0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
            4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
        ];
        $hoursOfDay = range(0, 23);
    @endphp

    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}') || [],
            isDragging: false,

            toggleCell(key) {
                if (this.state.includes(key)) {
                    this.state = this.state.filter(h => h !== key);
                } else {
                    this.state.push(key);
                }
            },

            selectColumn(hour) {
                let hours = [0,1,2,3,4,5,6].map(d => `${d}-${hour}`);
                let allSelected = hours.every(h => this.state.includes(h));

                if (allSelected) {
                    this.state = this.state.filter(h => !h.endsWith(`-${hour}`));
                } else {
                    this.state = [...new Set([...this.state, ...hours])];
                }
            },

            selectRow(dayIndex) {
                let hours = Array.from({length: 24}, (_, i) => `${dayIndex}-${i}`);
                let allSelected = hours.every(h => this.state.includes(h));

                if (allSelected) {
                    this.state = this.state.filter(h => !h.startsWith(`${dayIndex}-`));
                } else {
                    this.state = [...new Set([...this.state, ...hours])];
                }
            }
        }"
        x-on:mousedown.window="isDragging = true"
        x-on:mouseup.window="isDragging = false"
        x-on:mouseleave="isDragging = false"
        class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 select-none"
    >
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Banner Schedule (7x24)</h3>
            <div class="space-x-2">
                <button
                    x-on:click="state = []"
                    type="button"
                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
                >
                    Clear All
                </button>
            </div>
        </div>

        <div class="grid gap-1 text-center text-xs" style="grid-template-columns: auto repeat(24, minmax(0, 1fr));">
            {{-- Header Row --}}
            <div class="p-1 font-semibold text-gray-700 dark:text-gray-300"></div>

            @foreach($hoursOfDay as $hour)
                <div
                    x-on:click="selectColumn({{ $hour }})"
                    x-on:mousedown="
                        if (isDragging) {
                            selectColumn({{ $hour }});
                        }
                    "
                    class="p-1 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 rounded-sm dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    {{ str_pad((string) $hour, 2, '0', STR_PAD_LEFT) }}
                </div>
            @endforeach

            {{-- Days Rows --}}
            @foreach($daysOfWeek as $dayIndex => $dayName)
                {{-- Day Name Column --}}
                <div
                    x-on:click="selectRow({{ $dayIndex }})"
                    x-on:mousedown="
                        if (isDragging) {
                            selectRow({{ $dayIndex }});
                        }
                    "
                    class="p-1 font-semibold text-gray-700 text-left cursor-pointer hover:bg-gray-100 rounded-sm dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    {{ $dayName }}
                </div>

                {{-- Cells --}}
                @foreach($hoursOfDay as $hour)
                    @php $key = "{$dayIndex}-{$hour}"; @endphp
                    <div
                        x-on:mousedown="
                            isDragging = true;
                            toggleCell('{{ $key }}');
                        "
                        x-on:mouseenter="
                            if (isDragging) {
                                toggleCell('{{ $key }}');
                            }
                        "
                        class="p-1 border border-gray-200 rounded-sm cursor-pointer dark:border-gray-700"
                        :class="state.includes('{{ $key }}')
                            ? 'bg-indigo-500 hover:bg-indigo-600'
                            : 'bg-gray-50 hover:bg-gray-100 dark:bg-gray-900 dark:hover:bg-gray-700'"
                    ></div>
                @endforeach
            @endforeach
        </div>
    </div>
</x-filament-forms::field-wrapper>
