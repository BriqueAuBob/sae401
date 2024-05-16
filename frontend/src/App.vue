<script setup lang="ts">
import { useColorMode } from '@vueuse/core';

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
</template>
