<script setup lang="ts">
import Card from '../Card.vue';
import type { Forecast } from '../../types/openweather';
import { PropType } from 'vue';
import ForecastItem from './ForecastItem.vue';

defineProps({
  forecasts: {
    type: Array as PropType<Forecast[]>,
    required: true,
  },
  title: {
    type: String,
    required: true,
  },
  mode: {
    type: String as PropType<'date' | 'hour'>,
    required: false,
    default: 'date',
  },
});
</script>

<template>
  <Card v-if="forecasts" class="w-full max-w-full">
    <div class="mb-4 text-lg font-medium">{{ title }}</div>
    <div class="flex w-full items-start justify-between gap-8 overflow-x-auto px-4">
      <ForecastItem v-for="weather in forecasts" :key="weather.dt" :forecast="weather" :mode="mode" />
    </div>
  </Card>
</template>
