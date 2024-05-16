<script setup lang="ts">
import { PropType } from 'vue';

const sizes = {
  xs: 'h-4 w-4 text-xs',
  sm: 'h-6 w-6 text-sm',
  md: 'h-8 w-8 text-md',
  lg: 'h-16 w-16 text-lg',
};

const props = defineProps({
  username: {
    type: String,
    required: true,
  },
  size: {
    type: String as PropType<keyof typeof sizes>,
    default: 'md',
  },
});

const getInitials = (username: string) => {
  return username
    .split(' ')
    .map((name) => name[0])
    .join('');
};

const sizeClasses = sizes[props.size];
</script>

<template>
  <div class="bg-primary-500 flex items-center justify-center rounded-full text-white" :class="sizeClasses">
    {{ getInitials(username) }}
  </div>
</template>
