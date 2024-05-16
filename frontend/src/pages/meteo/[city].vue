<script setup lang="ts">
import { useRoute } from 'vue-router';
import useFetch from '../../composables/useFetch';
import LoadingIndicator from '../../components/LoadingIndicator.vue';
import { ref, watch } from 'vue';
import Layout from '../../layouts/default.vue';
import WeatherWidget from '../../components/WeatherWidget.vue';
import WidgetWind from '../../components/widgets/Wind.vue';
import WidgetSunPhases from '../../components/widgets/SunPhases.vue';
import WidgetHumidity from '../../components/widgets/Humidity.vue';
import WidgetPressure from '../../components/widgets/Pressure.vue';
import WidgetClouds from '../../components/widgets/Clouds.vue';

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
            <WeatherWidget size="xl" class="p-6 text-center" childClasses="flex flex-col items-center" :city="city" />
            <div class="mt-4 grid grid-flow-row-dense grid-cols-4 gap-2">
              <WidgetWind :wind="data?.wind" />
              <WidgetSunPhases :sys="data?.sys" />
              <WidgetHumidity :humidity="data?.main?.humidity" />
              <WidgetPressure :pressure="data?.main?.pressure" />
              <WidgetClouds :clouds="data?.clouds" />
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
