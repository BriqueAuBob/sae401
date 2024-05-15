<script setup lang="ts">
import useTemperature from '../composables/useTemperature';
import useFetch from '../composables/useFetch';
import LoadingIndicator from './LoadingIndicator.vue';
import type { WeatherCity } from '../types/openweather';

const props = defineProps({
  city: {
    type: String,
    required: true,
  },
});

const { getTemperature } = useTemperature();

const { data, loading } = useFetch<WeatherCity>(`/weather/` + props.city);
</script>

<template>
  <article class="rounded-3xl border bg-blue-200 p-3 dark:border-neutral-500 dark:bg-blue-600">
    <template v-if="!loading && data">
      <h1 class="text-lg">{{ city }}</h1>
      <div class="text-2xl font-bold">{{ getTemperature(data?.main?.temp) }}</div>
    </template>
    <LoadingIndicator size="h-6 w-6" noText v-else />
  </article>
</template>
