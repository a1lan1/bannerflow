<script setup lang="ts">
import { useIntersectionObserver } from '@vueuse/core'
import { ref, nextTick, toRefs, watch, onUnmounted } from 'vue'
import { useBanner } from '@/composables/useBanner'

const props = defineProps<{
  placement: string;
}>()

const { placement } = toRefs(props)
const bannerRef = ref<HTMLElement>()
const observerStop = ref<(() => void) | null>(null)

const {
  banner,
  isFetching,
  error,
  recordImpression,
  handleClick
} = useBanner(placement)

watch(banner, async(newBanner) => {
  if (!newBanner) return

  await nextTick()

  observerHandler()
},
{ immediate: true }
)

const observerHandler = () => {
  const { stop } = useIntersectionObserver(
    bannerRef,
    ([entry]) => {
      if (entry.isIntersecting) {
        recordImpression()
        stop()
      }
    },
    { threshold: 0.5 }
  )

  observerStop.value = stop
}

onUnmounted(() => {
  if (observerStop.value) observerStop.value()
})
</script>

<template>
  <transition name="fade" mode="out-in">
    <v-skeleton-loader
      v-if="isFetching"
      type="image"
      max-height="150"
    />
    <div
      v-else-if="error && placement"
      class="banner-error"
    >
      No banner found for {{ placement }}.
    </div>
    <v-img
      v-else-if="banner"
      ref="bannerRef"
      :src="banner.image"
      :alt="banner.alt || placement"
      :href="banner.link"
      :target="banner.target"
      cover
      rounded
      class="cursor-pointer slide-image"
      max-height="150"
      @click.prevent="handleClick"
    >
      <div class="banner-name-overlay">
        {{ banner.name }}
      </div>
    </v-img>
  </transition>
  <!-- If no banner, no error, and not fetching, render nothing -->
</template>

<style scoped>
.banner-name-overlay {
  position: absolute;
  bottom: 8px;
  left: 8px;
  z-index: 10;
  color: #fff;
  font-size: 12px;
  font-weight: 600;
  text-shadow: 0 2px 5px rgba(0, 0, 0, 0.8);
  background: rgba(0, 0, 0, 0.5);
  padding: 4px 8px;
  border-radius: 4px;
  pointer-events: none;
  max-width: 75%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-leave-to {
  opacity: 0;
}

.fade-enter-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from {
  opacity: 0;
}
</style>
