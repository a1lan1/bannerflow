<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { toRefs, watch } from 'vue'
import { useDragSelection } from '@/composables/useDragSelection'
import { useScheduleGrid } from '@/composables/useScheduleGrid'
import { useBannerScheduleStore } from '@/stores/useBannerScheduleStore'

const props = defineProps<{
  bannerId: string
}>()

const { bannerId } = toRefs(props)

const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

const scheduleStore = useBannerScheduleStore()
const { scheduleData, fetching, storing } = storeToRefs(scheduleStore)

const {
  grid,
  currentSchedule,
  toggleDay,
  toggleHourColumn,
  clearGrid,
  selectAll,
  HOURS_IN_DAY
} = useScheduleGrid(scheduleData)

const {
  isDragging,
  startDrag,
  duringDrag,
  endDrag,
  getCellVisualState,
  isCellInDragSelection
} = useDragSelection(grid)

watch(
  bannerId,
  () => {
    if (bannerId.value) {
      scheduleStore.fetchSchedule(bannerId.value)
    }
  },
  { immediate: true }
)

const handleSaveSchedule = () => {
  scheduleStore.saveSchedule(bannerId.value, currentSchedule.value)
}
</script>

<template>
  <div class="rounded-lg bg-white p-4 shadow">
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-medium text-gray-900">Schedule Picker (7x24)</h3>
      <div class="space-x-2">
        <v-btn
          v-if="bannerId"
          color="success"
          density="compact"
          :loading="storing"
          @click="handleSaveSchedule"
        >
          Save Schedule
        </v-btn>
        <v-btn
          class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
          density="compact"
          @click="clearGrid"
        >
          Clear All
        </v-btn>
        <v-btn
          class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
          density="compact"
          @click="selectAll"
        >
          Select All
        </v-btn>
      </div>
    </div>

    <v-skeleton-loader
      v-if="fetching"
      type="card"
      max-height="150"
    />
    <div
      v-else
      class="grid grid-cols-[auto_repeat(24,_minmax(0,_1fr))] gap-1 text-center text-xs select-none"
      @mouseleave="endDrag"
    >
      <!-- Corner cell -->
      <div class="p-1 font-semibold text-gray-700"></div>

      <!-- Hour headers -->
      <div
        v-for="hour in HOURS_IN_DAY"
        :key="`hour-header-${hour - 1}`"
        @click="toggleHourColumn(hour - 1)"
        class="cursor-pointer rounded-sm p-1 font-semibold text-gray-700 hover:bg-gray-100"
        :title="`Toggle all ${String(hour - 1).padStart(2, '0')}:00 hours`"
      >
        {{ String(hour - 1).padStart(2, '0') }}
      </div>

      <!-- Day rows -->
      <template
        v-for="(dayName, dayIndex) in dayNames"
        :key="`day-row-${dayIndex}`"
      >
        <!-- Day header -->
        <div
          class="cursor-pointer rounded-sm p-1 text-left font-semibold text-gray-700 hover:bg-gray-100"
          :title="`Toggle all ${dayName} hours`"
          @click="toggleDay(dayIndex)"
        >
          {{ dayName }}
        </div>

        <!-- Hour cells -->
        <div
          v-for="hour in HOURS_IN_DAY"
          :key="`cell-${dayIndex}-${hour - 1}`"
          :class="[
            'cursor-pointer rounded-sm border border-gray-200 p-1',
            getCellVisualState(dayIndex, hour - 1)
              ? 'bg-indigo-500 hover:bg-indigo-600'
              : 'bg-gray-50 hover:bg-gray-100',
            {
              'opacity-75': isCellInDragSelection(dayIndex, hour - 1) && isDragging,
            },
          ]"
          :title="`${dayName}, ${String(hour - 1).padStart(2, '0')}:00`"
          @mousedown.prevent="startDrag(dayIndex, hour - 1)"
          @mouseenter="duringDrag(dayIndex, hour - 1)"
        ></div>
      </template>
    </div>
  </div>
</template>
