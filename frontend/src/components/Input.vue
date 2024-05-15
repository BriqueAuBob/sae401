<script setup lang="ts">
import { computed } from 'vue';

const model = defineModel();

const props = defineProps({
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

const id = computed(() => props.label?.toLowerCase().replace(' ', '-'));
</script>

<template>
  <label
    :for="id"
    :class="{ 'sr-only': hiddenLabel }"
    class="mb-0.5 ml-4 block text-sm font-medium text-neutral-600 dark:text-neutral-400"
    >{{ label }}</label
  >
  <input
    v-bind="$attrs"
    :placeholder="placeholder"
    class="focus:ring-primary-200 dark:focus:ring-primary-500 focus:ring-offset-primary-50 rounded-full border bg-white px-3 py-2 text-sm shadow-sm duration-200 focus:outline-none focus:ring-1 disabled:cursor-not-allowed disabled:opacity-50 dark:focus:ring-2"
    v-model="model"
    :id="id"
    :name="id"
  />
</template>
