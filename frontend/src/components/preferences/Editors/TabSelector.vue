<script setup lang="ts">
import { computed, PropType, ref } from 'vue';
import type Option from '../../../types/option';

const model = defineModel<string>();

defineProps({
  options: {
    type: Array as PropType<Option[]>,
    required: true,
  },
});

const buttons = ref<HTMLButtonElement[]>([]);
const hovered = ref<number | null>(null);
const backgroundStyle = computed(() => {
  if (hovered.value === null) {
    const button = buttons.value.find((button) => button.classList.contains('selected'));
    return {
      left: `${button?.offsetLeft}px`,
      width: `${button?.offsetWidth}px`,
    };
  }

  const button = buttons.value[hovered.value];
  return {
    left: `${button.offsetLeft}px`,
    width: `${button.offsetWidth}px`,
  };
});
</script>

<template>
  <div class="relative flex rounded-full bg-white shadow-sm dark:bg-neutral-600">
    <div
      class="bg-primary-200 dark:bg-primary-500 absolute top-0 h-full w-1/3 scale-95 rounded-full duration-200"
      :class="hovered === null || options[hovered].value === model ? '' : 'opacity-30'"
      :style="backgroundStyle"
    ></div>
    <template v-for="(option, index) in options" :key="option.value">
      <button
        class="z-20 rounded-md px-4 py-2"
        :class="{
          selected: model === option.value,
        }"
        @click="
          () => {
            model = option.value;
          }
        "
        @mouseenter="hovered = index"
        @mouseleave="hovered = null"
        ref="buttons"
      >
        {{ option.label }}
      </button>
    </template>
  </div>
</template>
