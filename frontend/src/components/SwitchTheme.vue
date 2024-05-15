<script setup lang="ts">
import { BasicColorSchema, useColorMode } from '@vueuse/core';

const colorMode = useColorMode({
  attribute: 'class',
  modes: {
    light: '',
    dark: 'dark',
  },
  storageKey: 'theme',
  disableTransition: false,
});

const modes: {
  name: string;
  value: BasicColorSchema;
  colors: {
    [key: string]: string;
  };
}[] = [
  {
    name: 'Mode clair',
    value: 'light',
    colors: {
      background: 'bg-white',
      card: 'bg-neutral-200',
      text: 'text-black',
      border: 'border-neutral-300',
    },
  },
  {
    name: 'Mode sombre',
    value: 'dark',
    colors: {
      background: 'bg-neutral-800',
      card: 'bg-neutral-700',
      text: 'text-white',
      border: 'border-neutral-600',
    },
  },
];
</script>

<template>
  <div class="grid w-full grid-cols-2 gap-2">
    <button
      v-for="mode in modes"
      @click="colorMode = mode.value"
      class="overflow-hidden rounded-2xl border-2"
      :class="[
        colorMode === mode.value && 'border-primary-500 shadow-primary-200 dark:shadow-primary-700 border shadow-sm',
        mode.colors.card,
      ]"
    >
      <div class="h-32 w-full overflow-hidden p-1" :class="mode.colors.background">
        <div class="h-12 w-full rounded-xl" :class="mode.colors.card"></div>
        <div class="mt-1 grid grid-cols-3 gap-1">
          <div v-for="i in 6" :key="i" class="h-12 w-full rounded-xl" :class="mode.colors.card"></div>
        </div>
      </div>
      <div class="shadow-primary-500 border-t p-4" :class="[mode.colors.text, mode.colors.border]">
        {{ mode.name }}
      </div>
    </button>
  </div>
</template>
