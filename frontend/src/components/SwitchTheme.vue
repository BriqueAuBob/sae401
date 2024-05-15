<script setup lang="ts">
import { useColorMode, useCycleList } from '@vueuse/core';
import { watchEffect } from 'vue';

const mode = useColorMode({
  attribute: 'class',
  class: 'dark',
  modes: {
    light: '',
    dark: 'dark',
  },
  storageKey: 'theme',
  disableTransition: false,
});

const { state, next } = useCycleList(['light', 'dark'], { initialValue: mode.value });

const toggleMode = () => {
  next();
};

watchEffect(() => (mode.value = state.value));
</script>

<template>
  <button
    @click="toggleMode"
    class="text-md rounded-2xl border border-neutral-300 px-4 py-2 font-medium shadow-sm duration-300 ease-in hover:bg-neutral-100 dark:border-neutral-600 dark:bg-neutral-900 dark:hover:bg-neutral-800"
  >
    Thème
  </button>
</template>
