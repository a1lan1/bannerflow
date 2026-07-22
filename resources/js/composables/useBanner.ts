import { computed, onMounted, onUnmounted, ref, watch } from 'vue'
import type { Ref } from 'vue'
import { api } from '@/plugins/axios'
import { snackbar } from '@/plugins/snackbar'
import type { Banner } from '@/types/banner'

interface ApiResponse {
  data: Banner;
}

const MIN_REFRESH_INTERVAL = 10000
const MAX_REFRESH_INTERVAL = 30000

export function useBanner(placement: Ref<string>) {
  const interval = ref<number | null>(null)
  const isFetching = ref(false)
  const error = ref<Error | null>(null)
  const banner = ref<Banner | null>(null)

  const fetchBanner = async() => {
    if (!placement.value) {
      banner.value = null
      error.value = new Error('Placement is not specified.')

      return
    }

    isFetching.value = true
    banner.value = null
    error.value = null

    try {
      const { data } = await api.get<ApiResponse>(`/v1/banners/${placement.value}`)
      banner.value = data.data
    } catch (e: any) {
      error.value = e
      banner.value = null
    } finally {
      isFetching.value = false
    }
  }

  watch(placement, fetchBanner, { immediate: true })

  const getContextHeaders = (): Record<string, string> => {
    const headers: Record<string, string> = {}

    // Any relevant headers from the client-side for BannerContext
    return headers
  }

  const recordImpression = async() => {
    if (!banner.value || !placement.value) {
      console.log('Banner or placement is not defined.')

      return
    }

    try {
      await api.post(`/v1/banners/${banner.value.id}/placements/${placement.value}/impression`, {}, {
        headers: getContextHeaders()
      })
      console.log(`Impression recorded for banner: ${banner.value.id}.`)
    } catch (e) {
      snackbar.error({ text: 'Failed to record impression.' })
      console.error('Failed to record impression:', e)
    }
  }

  const handleClick = async() => {
    if (!banner.value || !placement.value) {
      return
    }

    try {
      await api.post(`/v1/banners/${banner.value.id}/placements/${placement.value}/click`, {}, {
        headers: getContextHeaders()
      })
      console.log(`Click recorded for banner: ${banner.value.id}.`)
    } catch (e) {
      snackbar.error({ text: 'Failed to record click.' })
      console.error('Failed to record click:', e)
    }

    window.open(banner.value.link, banner.value.target)
  }

  const randomInt = computed(() => {
    return Math.floor(Math.random() * (MAX_REFRESH_INTERVAL - MIN_REFRESH_INTERVAL + 1)) + MIN_REFRESH_INTERVAL
  })

  onMounted(() => {
    // We change the banner every N seconds
    interval.value = setInterval(fetchBanner, randomInt.value)
  })

  onUnmounted(() => {
    if (interval.value) clearInterval(interval.value)
  })

  return {
    banner,
    isFetching,
    error,
    recordImpression,
    handleClick
  }
}
