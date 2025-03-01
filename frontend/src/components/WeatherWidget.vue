<script setup lang="ts">
import useTemperature from '../composables/useTemperature';
import useFetch from '../composables/useFetch';
import LoadingIndicator from './LoadingIndicator.vue';
import type { WeatherCity } from '../types/openweather';
import ArrowUp from '../assets/icons/arrow-up.svg';
import ArrowDown from '../assets/icons/arrow-down.svg';
import usePreference from '../composables/usePreference';
import Cloud from '../assets/widgets/cloud.png';
import Cloud2 from '../assets/widgets/cloud2.webp';
import Clouds from '../assets/widgets/clouds.png';
import Sun from '../assets/widgets/sun.png';
import Rain from '../assets/widgets/rain.png';
import { computed, PropType } from 'vue';

type Sizes = 'md' | 'xl';

const props = defineProps({
  city: {
    type: String,
    required: true,
  },
  childClasses: {
    type: String,
    default: '',
  },
  size: {
    type: String as PropType<Sizes>,
    default: 'md',
  },
});

const { getTemperature } = useTemperature();
const getPreference = usePreference();

const { data: weather, loading } = useFetch<WeatherCity>(`/weather/` + props.city);

const getWeatherStateTitle = (state: any) => {
  return state.description.charAt(0).toUpperCase() + state.description.slice(1);
};

const isCloudy = computed(() => {
  return weather?.value?.weather?.find((state: any) => state.main === 'Clouds');
});

const isSunny = computed(() => {
  return weather?.value?.weather?.find((state: any) => state.main === 'Clear');
});

const isRainy = computed(() => {
  return weather?.value?.weather?.find((state: any) => state.main === 'Rain');
});

const sizes: { [key: string]: any } = {
  md: {
    cityName: 'text-sm',
    temperature: 'text-2xl',
    weatherState: 'text-sm',
    temperatureMinMax: 'text-xs',
  },
  xl: {
    cityName: 'text-lg',
    temperature: 'text-4xl',
    weatherState: 'text-lg',
    temperatureMinMax: 'text-sm',
  },
};
const size = computed(() => sizes[props.size]);
</script>

<template>
  <article
    class="border-primary-100 shadow-primary-200 dark:to-primary-800 dark:from-primary-600 dark:shadow-primary-900 from-primary-200 to-primary-400 dark:border-primary-800 relative rounded-3xl border-2 bg-gradient-to-b p-4 shadow-md"
    ref="weatherWidget"
    :class="{
      'overflow-hidden': true,
    }"
  >
    <template v-if="!loading && weather">
      <img v-if="isCloudy" :src="Clouds" alt="" class="pointer-events-none absolute left-0 right-0 top-0 w-full opacity-25" />
      <div class="relative z-50" :class="childClasses">
        <h1 :class="size.cityName">{{ weather?.name }}</h1>
        <div :class="size.temperature" class="font-bold">{{ getTemperature(weather?.main?.temp) }}</div>
        <div class="flex flex-wrap gap-2">
          <div class="flex items-center gap-1" v-for="state of weather?.weather">
            <img class="h-8 w-8" :src="'https://openweathermap.org/img/wn/' + state.icon + '.png'" alt="weather icon" />
            <div :class="size.weatherState">{{ getWeatherStateTitle(state) }}</div>
          </div>
        </div>
        <div class="flex gap-2" v-if="getPreference('display_min_max')?.pvalue">
          <div class="flex items-center gap-0.5">
            <ArrowUp class="h-3 w-3" />
            <div :class="size.temperatureMinMax">{{ getTemperature(weather?.main?.temp_max) }}</div>
          </div>
          <div class="flex items-center gap-0.5">
            <ArrowDown class="h-3 w-3" />
            <div :class="size.temperatureMinMax">{{ getTemperature(weather?.main?.temp_min) }}</div>
          </div>
        </div>
      </div>

      <slot />

      <img v-if="isCloudy?.description === 'couvert'" :src="Cloud" alt="" class="pointer-events-none absolute -right-4 -top-4 z-20 w-32" />
      <img v-else-if="isCloudy" :src="Cloud2" alt="" class="pointer-events-none absolute -right-4 -top-4 z-20 w-32" />
      <img
        v-else-if="isSunny"
        :src="Sun"
        alt=""
        class="pointer-events-none absolute -right-4 -top-4 z-20 w-32 drop-shadow-[0px_0px_30px_rgba(255,191,0,0.5)]"
      />
      <img
        v-else-if="isRainy"
        :src="Rain"
        alt=""
        class="pointer-events-none absolute right-0 top-0 z-20 h-full w-full mix-blend-soft-light"
      />
    </template>
    <LoadingIndicator size="h-6 w-6" noText v-else />
  </article>
</template>
