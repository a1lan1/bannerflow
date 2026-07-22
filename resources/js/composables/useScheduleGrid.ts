import { ref, computed, watch } from 'vue'
import type { Ref } from 'vue'
import type { ScheduleEntry, ScheduleGrid } from '@/types'

export function useScheduleGrid(initialSchedule: Ref<ScheduleEntry[]>) {
  const DAYS_IN_WEEK = 7
  const HOURS_IN_DAY = 24

  // Internal state of the grid
  const grid = ref<ScheduleGrid>(
    Array.from({ length: DAYS_IN_WEEK }, () => Array(HOURS_IN_DAY).fill(false))
  )

  // Initialize grid from initialSchedule prop
  const initializeGrid = (schedule: ScheduleEntry[]) => {
    const newGrid: ScheduleGrid = Array.from({ length: DAYS_IN_WEEK }, () => Array(HOURS_IN_DAY).fill(false))
    schedule.forEach(entry => {
      if (entry.day >= 0 && entry.day < DAYS_IN_WEEK && entry.hour >= 0 && entry.hour < HOURS_IN_DAY) {
        newGrid[entry.day][entry.hour] = true
      }
    })
    grid.value = newGrid
  }

  // Watch for changes in initialSchedule and re-initialize the grid
  watch(initialSchedule, (newSchedule) => {
    initializeGrid(newSchedule)
  }, { immediate: true, deep: true })

  // Computed property to convert the grid back to ScheduleEntry[] format
  const currentSchedule = computed<ScheduleEntry[]>(() => {
    const schedule: ScheduleEntry[] = []

    for (let day = 0; day < DAYS_IN_WEEK; day++) {
      for (let hour = 0; hour < HOURS_IN_DAY; hour++) {
        if (grid.value[day][hour]) {
          schedule.push({ day, hour })
        }
      }
    }

    return schedule
  })

  const toggleHour = (day: number, hour: number) => {
    if (day >= 0 && day < DAYS_IN_WEEK && hour >= 0 && hour < HOURS_IN_DAY) {
      grid.value[day][hour] = !grid.value[day][hour]
    }
  }

  const toggleDay = (day: number) => {
    if (day >= 0 && day < DAYS_IN_WEEK) {
      const allHoursSelected = grid.value[day].every(Boolean)
      grid.value[day] = Array(HOURS_IN_DAY).fill(!allHoursSelected)
    }
  }

  const toggleHourColumn = (hour: number) => {
    if (hour >= 0 && hour < HOURS_IN_DAY) {
      const allDaysSelectedForHour = grid.value.every(dayRow => dayRow[hour])

      for (let day = 0; day < DAYS_IN_WEEK; day++) {
        grid.value[day][hour] = !allDaysSelectedForHour
      }
    }
  }

  const clearGrid = () => {
    grid.value = Array.from({ length: DAYS_IN_WEEK }, () => Array(HOURS_IN_DAY).fill(false))
  }

  const selectAll = () => {
    grid.value = Array.from({ length: DAYS_IN_WEEK }, () => Array(HOURS_IN_DAY).fill(true))
  }

  return {
    grid,
    currentSchedule,

    toggleHour,
    toggleDay,
    toggleHourColumn,
    clearGrid,
    selectAll,

    DAYS_IN_WEEK,
    HOURS_IN_DAY
  }
}
