<script setup lang="ts">
import { useColorMode } from '@vueuse/core';
import { Toaster } from 'vue-sonner';

useColorMode({
  attribute: 'class',
  modes: {
    light: '',
    dark: 'dark',
  },
  storageKey: 'theme',
  disableTransition: false,
});
</script>

<template>
  <RouterView />
  <Toaster position="top-right" close-button />
</template>
