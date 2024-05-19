<script setup lang="ts">
import Card from '../Card.vue';
import usePreference from '../../composables/usePreference';
import { computed } from 'vue';
import Rain from '../../assets/widgets/rain.png';

const props = defineProps({
  humidity: {
    type: Number,
    required: true,
  },
});

const preferenceName = 'display_humidity';
const getPreference = usePreference();

const strokeDasharray = computed(() => {
  return props.humidity * Math.PI * 0.25 + ' 100';
});
</script>

<template>
  <Card v-if="getPreference(preferenceName)?.pvalue" class="relative overflow-hidden">
    <div class="text-lg font-medium">Humidité</div>
    <svg viewBox="-2 -2 54 30" fill="none" class="mt-2 w-32 overflow-visible">
      <path
        class="absolute bg-transparent stroke-blue-500 blur-md"
        stroke-width="4"
        :stroke-dasharray="strokeDasharray"
        stroke-linecap="round"
        d="M0 25a 25 25 90 0 1 50 0"
      />
      <path
        class="bg-transparent stroke-blue-500"
        stroke-width="4"
        :stroke-dasharray="strokeDasharray"
        stroke-linecap="round"
        d="M0 25a 25 25 90 0 1 50 0"
      />
    </svg>
    <div class="relative -top-10">
      <span class="absolute left-1/2 block -translate-x-1/2 text-3xl font-bold">{{ humidity }}%</span>
    </div>
    <img
      v-if="props.humidity > 50"
      :src="Rain"
      class="pointer-events-none absolute bottom-0 left-0 right-0 top-0 h-full w-full object-cover mix-blend-plus-lighter dark:opacity-75 dark:mix-blend-soft-light"
    />
  </Card>
</template>
