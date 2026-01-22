<template>
  <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
    <div class="p-5 flex-grow">
      <div class="flex justify-between items-start mb-2">
        <h3 class="text-lg font-bold text-gray-900 truncate" :title="card.name">
          {{ card.name }}
        </h3>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
          {{ card.price }} ₽
        </span>
      </div>

      <p class="text-xs font-semibold uppercase tracking-wider text-blue-600 mb-3">
        {{ card.category?.name || 'Без категории' }}
      </p>

      <p class="text-gray-600 text-sm line-clamp-3">
        {{ card.description }}
      </p>
    </div>

    <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
      <Link 
        :href="`/product/${card.id}`"
        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
      >
        Подробнее
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    card: {
        type: Object,
        required: true,
        default: () => ({}),
    },
});

</script>

<style scoped>

</style>