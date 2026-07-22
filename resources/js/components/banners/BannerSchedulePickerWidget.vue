<script setup lang="ts">
import { ref } from 'vue'
import BannerAutocomplete from '@/components/banners/BannerAutocomplete.vue'
import SchedulePicker from '@/components/banners/SchedulePicker.vue'
import type { BannerAutocompleteItem } from '@/types/banner'

const selectedBanner = ref<BannerAutocompleteItem | null>(null)
</script>

<template>
  <v-card>
    <v-card-actions>
      <BannerAutocomplete v-model="selectedBanner" />
    </v-card-actions>
    <v-card-text class="pb-0">
      <div
        v-if="selectedBanner"
        class="relative min-h-[200px]"
      >
        <SchedulePicker :banner-id="selectedBanner.id" />
      </div>
      <div v-else class="flex h-48 items-center justify-center text-gray-500">
        Please select a banner to see its schedule.
      </div>
    </v-card-text>
  </v-card>
</template>
