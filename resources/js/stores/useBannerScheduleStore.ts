import { defineStore } from 'pinia'
import { ref } from 'vue'
import { api } from '@/plugins/axios'
import { snackbar } from '@/plugins/snackbar'
import type { ScheduleEntry } from '@/types'

export const useBannerScheduleStore = defineStore('bannerSchedule', () => {
  const scheduleData = ref<ScheduleEntry[]>([])
  const fetching = ref(false)
  const storing = ref(false)

  async function fetchSchedule(bannerId: string) {
    if (!bannerId) return

    fetching.value = true
    try {
      const { data } = await api.get(`/v1/banners/schedule/${bannerId}`)
      scheduleData.value = data.data
    } catch (error) {
      snackbar.error({ text: 'Failed to fetch schedule.' })
      console.error('Failed to fetch schedule:', error)
    } finally {
      fetching.value = false
    }
  }

  async function saveSchedule(bannerId: string, schedule: ScheduleEntry[]) {
    if (!bannerId) {
      snackbar.info({ text: 'Please select a banner first.' })

      return
    }

    storing.value = true
    try {
      await api.put(`/v1/banners/schedule/${bannerId}`, {
        schedule: schedule
      })
      snackbar.success({ text: 'Schedule saved successfully!' })
    } catch (error) {
      snackbar.error({ text: 'Failed to save schedule.' })
      console.error('Failed to save schedule:', error)
    } finally {
      storing.value = false
    }
  }

  return {
    scheduleData,
    fetching,
    storing,
    fetchSchedule,
    saveSchedule
  }
})
