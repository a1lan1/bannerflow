import { watchDebounced } from '@vueuse/core'
import { ref } from 'vue'
import { api } from '@/plugins/axios'
import { snackbar } from '@/plugins/snackbar'
import type { BannerAutocompleteItem } from '@/types/banner'

export function useBannerSearch() {
  const loading = ref(false)
  const searchQuery = ref('')
  const items = ref<BannerAutocompleteItem[]>([])

  async function fetchBanners() {
    // No need to fetch if query is too short, but allow fetching all on initial load (empty query)
    if (searchQuery.value.trim().length > 0 && searchQuery.value.trim().length < 3) {
      items.value = []

      return
    }

    try {
      loading.value = true
      const { data } = await api.get('/v1/banners', {
        params: { query: searchQuery.value }
      })
      items.value = data.data
    } catch (error) {
      snackbar.error({ text: 'Error fetching autocomplete suggestions :(' })
      console.error('Error fetching autocomplete suggestions:', error)
    } finally {
      loading.value = false
    }
  }

  watchDebounced(
    searchQuery,
    fetchBanners,
    { debounce: 300 }
  )

  return {
    loading,
    searchQuery,
    items,
    fetchBanners
  }
}
