<script setup lang="ts">
import { computed, PropType } from 'vue';

type Color = 'primary' | 'red' | 'green' | 'blue' | 'yellow' | 'indigo' | 'purple' | 'pink' | 'gray' | 'black' | 'white' | 'transparent';
type Size = 'xs' | 'sm' | 'md' | 'lg' | 'xl';

const props = defineProps({
  color: {
    type: String as PropType<Color>,
    default: 'primary',
  },
  size: {
    type: String as PropType<Size>,
    default: 'md',
  },
});

const sizes = {
  xs: 'px-2 py-1 text-xs',
  sm: 'px-3 py-2 text-sm',
  md: 'px-4 py-2 text-base',
  lg: 'px-6 py-3 text-lg',
  xl: 'px-8 py-4 text-xl',
};
const color = computed(() => {
  switch (props.color) {
    case 'white':
      return 'bg-white text-black hover:bg-neutral-50 ring-neutral-100';
    default:
      return `bg-${props.color}-500 hover:bg-${props.color}-400 text-white ring-${props.color}-200`;
  }
});
</script>

<template>
  <button
    :class="[
      color,
      `relative overflow-hidden rounded-full border border-neutral-400/50 px-4 py-2 font-medium shadow-sm duration-200 dark:border-neutral-600/25`,
      'after:left-O ring-offset-primary-50 from-white/50 ring-1 ring-offset-1 after:absolute after:bottom-0 after:right-0 after:top-0 after:h-full after:w-full  after:bg-gradient-to-b dark:ring-offset-neutral-900',
      sizes[size],
    ]"
  >
    <slot></slot>
  </button>
</template>
