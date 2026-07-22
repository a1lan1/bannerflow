<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useBannerSearch } from '@/composables/useBannerSearch'
import type { BannerAutocompleteItem } from '@/types/banner'

const props = defineProps<{
  modelValue: BannerAutocompleteItem | null;
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', banner: BannerAutocompleteItem | null): void,
}>()

const { loading, searchQuery, items, fetchBanners } = useBannerSearch()

const internalBanner = ref<BannerAutocompleteItem | null>(props.modelValue)

watch(
  () => props.modelValue,
  (newValue) => {
    internalBanner.value = newValue
  }
)

watch(internalBanner, (newValue) => {
  emit('update:modelValue', newValue)
})

onMounted(fetchBanners)
</script>

<template>
  <v-autocomplete
    v-model="internalBanner"
    v-model:search="searchQuery"
    :items="items"
    :loading="loading"
    :no-data-text="searchQuery ? 'Banners not found' : 'Enter a search query'"
    variant="solo-filled"
    item-title="name"
    item-value="id"
    label="Select a Banner to Edit Schedule"
    placeholder="Start typing..."
    prepend-inner-icon="mdi-magnify"
    clearable
    no-filter
    single-line
    hide-no-data
    return-object
    hide-details="auto"
    density="compact"
  />
</template>
