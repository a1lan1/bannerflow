<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import Banner from '@/components/banners/Banner.vue'
import BannerSchedulePickerWidget from '@/components/banners/BannerSchedulePickerWidget.vue'
import { dashboard } from '@/routes'

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Dashboard',
        href: dashboard()
      }
    ]
  }
})
</script>

<template>
  <Head title="Demo Dashboard" />

  <div class="flex h-full flex-1 flex-col">
    <!-- Header -->
    <header class="mb-4 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
      <h2 class="mb-2 text-lg font-semibold">Header Banner</h2>
      <div class="grid gap-4 md:grid-cols-2">
        <Banner placement="header-banner" />
        <Banner placement="header-banner" />
      </div>
    </header>

    <div class="flex flex-1 gap-4">
      <!-- Main Content -->
      <main class="flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
        <h2 class="mb-2 text-lg font-semibold">Interactive Schedule Picker</h2>
        <div class="flex flex-col">
          <BannerSchedulePickerWidget />
        </div>
      </main>

      <!-- Right Sidebar -->
      <aside class="w-1/4 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
        <h2 class="mb-2 text-lg font-semibold">Sidebar Banner</h2>
        <div class="flex flex-col gap-4">
          <Banner placement="sidebar-banner" />
          <Banner placement="sidebar-banner" />
        </div>
      </aside>
    </div>

    <!-- Footer -->
    <footer class="mt-4 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
      <h2 class="mb-2 text-lg font-semibold">Footer Banner</h2>
      <div class="grid gap-4 md:grid-cols-3">
        <Banner placement="footer-banner" />
        <Banner placement="footer-banner" />
        <Banner placement="footer-banner" />
      </div>
    </footer>
  </div>
</template>
