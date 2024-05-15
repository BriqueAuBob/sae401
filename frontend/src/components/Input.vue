<script setup lang="ts">
const model = defineModel();

defineProps({
  placeholder: String,
  label: String,
  hiddenLabel: {
    type: Boolean,
    default: false,
  },
});

defineOptions({
  inheritAttrs: false,
});
</script>

<template>
  <label :class="{ 'sr-only': hiddenLabel }" class="mb-0.5 ml-4 block text-sm font-medium text-neutral-600">{{ label }}</label>
  <input
    v-bind="$attrs"
    :placeholder="placeholder"
    class="focus:ring-primary-200 focus:ring-offset-primary-50 rounded-full border bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1"
    v-model="model"
    type="text"
  />
</template>
