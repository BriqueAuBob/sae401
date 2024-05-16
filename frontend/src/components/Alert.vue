<script setup lang="ts">
import { PropType } from 'vue';

type AlertType = 'success' | 'error' | 'warning' | 'info';

const props = defineProps({
  type: {
    type: String as PropType<AlertType>,
    default: 'info',
  },
  title: {
    type: String,
    required: true,
  },
  message: {
    type: String,
    required: true,
  },
});

const colors = {
  success: 'bg-green-100 text-green-800 border-green-200',
  error: 'bg-red-100 text-red-800 border-red-200',
  warning: 'bg-yellow-100 text-yellow-800 border-yellow-200',
  info: 'bg-blue-100 text-blue-800 border-blue-200',
};
</script>

<template>
  <div class="rounded-2xl border-2 p-3 shadow-sm" :class="colors[props.type]">
    <div class="text-sm font-medium">{{ title }}</div>
    <p class="text-xs">{{ message }}</p>
  </div>
</template>
