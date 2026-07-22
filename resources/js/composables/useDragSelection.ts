import { ref  } from 'vue'
import type { Ref } from 'vue'
import type { ScheduleGrid } from '@/types'

export function useDragSelection(grid: Ref<ScheduleGrid>) {
  const isDragging = ref(false)
  const dragStart = ref<{ day: number; hour: number } | null>(null)
  const dragEnd = ref<{ day: number; hour: number } | null>(null)
  const initialDragState = ref<boolean | null>(null)

  const startDrag = (day: number, hour: number) => {
    isDragging.value = true
    dragStart.value = { day, hour }
    dragEnd.value = { day, hour }
    initialDragState.value = !grid.value[day][hour]

    // Apply the initial state to the starting cell
    grid.value[day][hour] = initialDragState.value

    document.addEventListener('mouseup', endDrag, { once: true })
  }

  const duringDrag = (day: number, hour: number) => {
    if (isDragging.value) {
      dragEnd.value = { day, hour }
    }
  }

  const endDrag = () => {
    if (!isDragging.value || !dragStart.value || !dragEnd.value || initialDragState.value === null) {
      return
    }

    const minDay = Math.min(dragStart.value.day, dragEnd.value.day)
    const maxDay = Math.max(dragStart.value.day, dragEnd.value.day)
    const minHour = Math.min(dragStart.value.hour, dragEnd.value.hour)
    const maxHour = Math.max(dragStart.value.hour, dragEnd.value.hour)

    for (let d = minDay; d <= maxDay; d++) {
      for (let h = minHour; h <= maxHour; h++) {
        grid.value[d][h] = initialDragState.value
      }
    }

    isDragging.value = false
    dragStart.value = null
    dragEnd.value = null
    initialDragState.value = null
  }

  const isCellInDragSelection = (day: number, hour: number) => {
    if (!isDragging.value || !dragStart.value || !dragEnd.value) {
      return false
    }

    const minDay = Math.min(dragStart.value.day, dragEnd.value.day)
    const maxDay = Math.max(dragStart.value.day, dragEnd.value.day)
    const minHour = Math.min(dragStart.value.hour, dragEnd.value.hour)
    const maxHour = Math.max(dragStart.value.hour, dragEnd.value.hour)

    return day >= minDay && day <= maxDay && hour >= minHour && hour <= maxHour
  }

  const getCellVisualState = (day: number, hour: number) => {
    if (isDragging.value && isCellInDragSelection(day, hour)) {
      return initialDragState.value
    }

    return grid.value[day][hour]
  }

  return {
    isDragging,
    startDrag,
    duringDrag,
    endDrag,
    isCellInDragSelection,
    getCellVisualState
  }
}
