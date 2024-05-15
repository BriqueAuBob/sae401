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
      return 'bg-white text-black hover:bg-neutral-50';
    default:
      return `bg-${props.color}-500 hover:bg-${props.color}-400 text-white`;
  }
});
</script>

<template>
  <button
    :class="[
      color,
      `rounded-full border border-neutral-200 px-4 py-2 font-medium shadow-sm duration-200 dark:border-neutral-400`,
      sizes[size],
    ]"
  >
    <slot></slot>
  </button>
</template>
