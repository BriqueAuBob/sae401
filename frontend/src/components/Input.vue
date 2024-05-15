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
  <label :for="id" :class="{ 'sr-only': hiddenLabel }" class="mb-0.5 ml-4 block text-sm font-medium text-neutral-600">{{ label }}</label>
  <input
    v-bind="$attrs"
    :placeholder="placeholder"
    class="focus:ring-primary-200 focus:ring-offset-primary-50 rounded-full border bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-1"
    v-model="model"
    :id="id"
    :name="id"
  />
</template>
