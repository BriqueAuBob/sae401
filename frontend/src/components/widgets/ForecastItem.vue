<script setup lang="ts">
import { computed, PropType } from 'vue';
import type { Forecast } from '../../types/openweather';
import useTemperature from '../../composables/useTemperature';

const props = defineProps({
  forecast: {
    type: Object as PropType<Forecast>,
    required: true,
  },
  mode: {
    type: String as PropType<'date' | 'hour'>,
    required: false,
    default: 'date',
  },
});

const addZero = (value: number) => {
  if (value < 10) {
    return '0' + value;
  }
  return value;
};

const date = computed(() => {
  return new Date(props.forecast.dt * 1000);
});

const hour = computed(() => {
  return addZero(date.value.getHours());
});

const day = computed(() => {
  return addZero(date.value.getDate());
});

const month = computed(() => {
  return addZero(date.value.getMonth() + 1);
});

const getWeatherStateTitle = (state: any) => {
  return state.description.charAt(0).toUpperCase() + state.description.slice(1);
};

const { getTemperature } = useTemperature();
</script>

<template>
  <div class="flex flex-col items-center">
    <div class="text-sm font-medium">{{ mode === 'date' ? day + '/' + month : hour + 'h00' }}</div>
    <img
      :src="`http://openweathermap.org/img/wn/${forecast.weather[0].icon}.png`"
      :alt="forecast.weather[0].description"
      class="h-12 w-12"
    />
    <div class="mb-1 text-center text-sm">{{ getWeatherStateTitle(forecast.weather[0]) }}</div>
    <div class="text-sm">{{ getTemperature(forecast.main.temp) }}</div>
  </div>
</template>
