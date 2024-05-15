<script setup lang="ts">
defineProps({
  noText: {
    type: Boolean,
    default: false,
  },
  size: {
    type: String,
    default: 'h-16 w-16',
  },
});
</script>

<template>
  <div class="container flex flex-col items-center justify-center py-8">
    <div class="border-primary-500 animate-spin rounded-full border-b-2" :class="size"></div>
    <div v-if="!noText" class="text-primary-500 mt-4">Chargement des données...</div>
    <div v-if="!noText" class="text-primary-700 mt-2 text-sm">Veuillez patienter quelques instants.</div>
  </div>
</template>
