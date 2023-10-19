<script setup lang="ts">
  defineProps<{ country: Country }>()
</script>

<template>
  <div class="max-w-xs rounded overflow-hidden shadow-lg my-2 p-2 bg-gray-50">
    <img :src="country.flag" :alt="country.name" class="object-scale-down h-32">
    <div class="px-6 py-4 text-center">
      <div class="font-bold mb-2">{{ country.name }}</div>
    </div>
  </div>
</template>
