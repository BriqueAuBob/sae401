<script setup lang="ts">
import { useRoute } from 'vue-router';
import useFetch from '../../composables/useFetch';
import LoadingIndicator from '../../components/LoadingIndicator.vue';
import { ref, watch } from 'vue';
import Layout from '../../layouts/default.vue';
import WeatherWidget from '../../components/WeatherWidget.vue';
import WidgetWind from '../../components/widgets/Wind.vue';
import usePreference from '../../composables/usePreference';
import useTemperature from '../../composables/useTemperature';
import Card from '../../components/Card.vue';
import ArrowUp from '../../assets/icons/arrow-up.svg';
import ArrowDown from '../../assets/icons/arrow-down.svg';
import WidgetSunPhases from '../../components/widgets/SunPhases.vue';

const route = useRoute();
const city = ref<string>(route.params.city as string);

const { data, loading, error, getData } = useFetch<any>(`/weather/${city.value}`);

watch(
  () => route.params.city,
  (newCity) => {
    getData(`/weather/${newCity}`);
  }
);

const otherCities = ['Paris', 'London', 'New York', 'Tokyo'];
const getPreference = usePreference();
const { getTemperature } = useTemperature();

const getWeatherStateTitle = (state: any) => {
  return state.description.charAt(0).toUpperCase() + state.description.slice(1);
};
</script>

<template>
  <Layout>
    <div class="relative">
      <header class="from-primary-200 dark:from-primary-800 bg-gradient-to-b to-transparent pb-12 pt-20"></header>
      <main class="container">
        <LoadingIndicator v-if="loading" class="min-h-96" />
        <template v-else-if="error">Error: {{ error.message }}</template>
        <div class="grid gap-4 lg:grid-cols-4" v-else>
          <div class="col-span-3">
            <Card class="flex flex-col justify-center text-center">
              <h1 class="text-2xl font-medium">{{ data?.name || city }}</h1>
              <h2 class="text-4xl font-black">{{ getTemperature(data.main.temp) }}</h2>
              <div class="flex items-center justify-center gap-4">
                <div v-for="state of data?.weather" class="flex items-center gap-2">
                  <img :src="`http://openweathermap.org/img/wn/${data.weather[0].icon}.png`" :alt="data.weather[0].description" />
                  <div>{{ getWeatherStateTitle(state) }}</div>
                </div>
              </div>
              <div class="flex justify-center gap-2" v-if="getPreference('display_min_max')?.pvalue">
                <div class="flex items-center gap-0.5">
                  <ArrowUp class="h-3.5 w-3.5" />
                  <div class="text-xs">{{ getTemperature(data?.main?.temp_max) }}</div>
                </div>
                <div class="flex items-center gap-0.5">
                  <ArrowDown class="h-3.5 w-3.5" />
                  <div class="text-xs">{{ getTemperature(data?.main?.temp_min) }}</div>
                </div>
              </div>
            </Card>
            <div class="mt-4 grid grid-cols-4 gap-2">
              <WidgetWind :wind="data?.wind" />
              <WidgetSunPhases :sys="data?.sys" />
            </div>
          </div>
          <aside class="opacity-50 duration-200 hover:opacity-100">
            <h1 class="text-lg font-semibold">Autres villes</h1>
            <div class="flex gap-2 lg:flex-col">
              <RouterLink
                v-for="city in otherCities"
                :key="city"
                :to="`/meteo/${city}`"
                class="opacity-75 duration-200 hover:-translate-y-1 hover:opacity-100 hover:brightness-105 dark:opacity-90"
              >
                <WeatherWidget :city="city" />
              </RouterLink>
            </div>
          </aside>
        </div>
      </main>
    </div>
  </Layout>
</template>
