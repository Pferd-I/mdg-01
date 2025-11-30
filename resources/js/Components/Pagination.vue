<!-- resources/js/Components/Pagination.vue -->
<template>
  <div v-if="links?.length > 3" class="flex flex-wrap gap-1 justify-center my-4">
    <template v-for="(link, key) in links" :key="key">
      <div v-if="link.url" class="inline">
        <Link
          :href="link.url"
          class="px-3 py-1 rounded-md text-sm"
          :class="{
            'bg-cyan-500 text-white': link.active,
            'bg-gray-200 text-gray-700 hover:bg-gray-300': !link.active,
          }"
          preserve-scroll
          preserve-state
        >
          <span v-html="link.label" />
        </Link>
      </div>
      <div v-else class="px-3 py-1 text-sm text-gray-500">
        <span v-html="link.label" />
      </div>
    </template>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
  links: Array,
});
</script>
