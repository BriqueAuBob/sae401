<script setup lang="ts">
import useTemperature from '../composables/useTemperature';
import useFetch from '../composables/useFetch';
import LoadingIndicator from './LoadingIndicator.vue';
import type { WeatherCity } from '../types/openweather';
import ArrowUp from '../assets/icons/arrow-up.svg';
import ArrowDown from '../assets/icons/arrow-down.svg';
import usePreference from '../composables/usePreference';

const props = defineProps({
  city: {
    type: String,
    required: true,
  },
});

const { getTemperature } = useTemperature();
const getPreference = usePreference();

const { data: weather, loading } = useFetch<WeatherCity>(`/weather/` + props.city);

const getWeatherStateTitle = (state: any) => {
  return state.description.charAt(0).toUpperCase() + state.description.slice(1);
};
</script>

<template>
  <article
    class="border-primary-100 shadow-primary-200 dark:to-primary-800 dark:from-primary-600 dark:shadow-primary-800 from-primary-200 to-primary-400 relative rounded-3xl border-2 bg-gradient-to-b p-3 shadow-md dark:border-neutral-500"
    ref="weatherWidget"
  >
    <template v-if="!loading && weather">
      <h1 class="text-sm">{{ weather?.name }}</h1>
      <div class="text-2xl font-bold">{{ getTemperature(weather?.main?.temp) }}</div>
      <div class="flex flex-wrap">
        <div class="flex items-center gap-1" v-for="state of weather?.weather">
          <img class="h-8 w-8" :src="'https://openweathermap.org/img/wn/' + state.icon + '.png'" alt="weather icon" />
          <div class="text-sm">{{ getWeatherStateTitle(state) }}</div>
        </div>
      </div>
      <div class="flex gap-2" v-if="getPreference('display_min_max')?.pvalue">
        <div class="flex items-center gap-0.5">
          <ArrowUp class="h-3 w-3" />
          <div class="text-xs">{{ getTemperature(weather?.main?.temp_max) }}</div>
        </div>
        <div class="flex items-center gap-0.5">
          <ArrowDown class="h-3 w-3" />
          <div class="text-xs">{{ getTemperature(weather?.main?.temp_min) }}</div>
        </div>
      </div>
    </template>
    <LoadingIndicator size="h-6 w-6" noText v-else />
  </article>
</template>
