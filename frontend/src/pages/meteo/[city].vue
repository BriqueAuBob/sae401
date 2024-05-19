<script setup lang="ts">
import { useRoute } from 'vue-router';
import useFetch from '../../composables/useFetch';
import LoadingIndicator from '../../components/LoadingIndicator.vue';
import { computed, Ref, ref, watch } from 'vue';
import Layout from '../../layouts/default.vue';
import WeatherWidget from '../../components/WeatherWidget.vue';
import WidgetWind from '../../components/widgets/Wind.vue';
import WidgetSunPhases from '../../components/widgets/SunPhases.vue';
import WidgetHumidity from '../../components/widgets/Humidity.vue';
import WidgetPressure from '../../components/widgets/Pressure.vue';
import WidgetClouds from '../../components/widgets/Clouds.vue';
import WidgetForecast from '../../components/widgets/Forecast.vue';
import { Forecast, WeatherForecast } from '../../types/openweather';
import usePreference from '../../composables/usePreference';

const route = useRoute();
const city = ref<string>(route.params.city as string);
const getPreference = usePreference();

const { data, loading, error, getData } = useFetch<any>(`/weather/${city.value}`);

watch(
  () => route.params.city,
  (newCity) => {
    city.value = newCity as string;
    getData(`/weather/${newCity}`);
  }
);

const otherCities = ['Paris', 'London', 'New York', 'Tokyo'];

const forecast = ref<Ref | null>(null);
if (getPreference('display_forecast')?.pvalue) {
  const { data: forecastData, getData } = useFetch<WeatherForecast>(`/weather/${city.value}/forecast`);
  forecast.value = forecastData;
  watch(
    () => city.value,
    (newCity) => {
      getData(`/weather/${newCity}/forecast`);
    }
  );
}

const todayOnly = computed(() => {
  return forecast.value?.value?.list.filter((forecast: Forecast) => {
    const date = new Date(forecast.dt * 1000);
    return date.getDate() === new Date().getDate();
  });
});
const nextDays = computed(() => {
  return forecast.value?.value?.list
    .filter((forecast: Forecast) => {
      const date = new Date(forecast.dt * 1000);
      return date.getDate() !== new Date().getDate();
    })
    .reduce((acc: { forecasts: Forecast[]; dt: number }[], forecast: Forecast) => {
      const date = new Date(forecast.dt * 1000);
      const day = date.getDate();
      const month = date.getMonth();
      const found = acc.find((f) => {
        const date = new Date(f.dt * 1000);
        return date.getDate() === day && month === date.getMonth();
      });

      if (!found) {
        acc.push({
          forecasts: [forecast],
          dt: forecast.dt,
        });
      } else {
        found.forecasts.push(forecast);
      }

      return acc;
    }, [])
    .map((f: { forecasts: Forecast[]; dt: number }) => {
      const temperatureAvg = f.forecasts.reduce((acc, forecast) => acc + forecast.main.temp, 0) / f.forecasts.length;
      const statsWeather = f.forecasts.reduce((acc: { [key: string]: number }, forecast) => {
        const key = forecast.weather[0].description;
        acc[key] = acc[key] ? acc[key] + 1 : 1;
        return acc;
      }, {});
      const weatherDescription = Object.keys(statsWeather).reduce((acc, key) => {
        if (statsWeather[key] > statsWeather[acc]) {
          return key;
        }
        return acc;
      }, Object.keys(statsWeather)[0]);
      const weather = f.forecasts.find((forecast) => forecast.weather[0].description === weatherDescription)?.weather;

      return {
        dt: f.dt,
        main: {
          temp: temperatureAvg,
        },
        weather: [
          {
            ...weather?.[0],
            icon: weather?.[0].icon.replace('n', 'd'),
          },
        ],
        forecasts: f.forecasts,
      };
    });
});
</script>

<template>
  <Layout>
    <div class="relative">
      <header class="from-primary-200 dark:from-primary-800 bg-gradient-to-b to-transparent pb-12 pt-20"></header>
      <main class="container">
        <LoadingIndicator v-if="loading" class="min-h-96" />
        <template v-else-if="error">Error: {{ error.message }}</template>
        <div class="lg:grid lg:grid-cols-4 lg:gap-4" v-else>
          <div class="lg:col-span-3">
            <WeatherWidget size="xl" class="w-full p-6 text-center" childClasses="flex flex-col items-center" :city="city">
              <WidgetForecast
                v-if="forecast?.value && getPreference('display_forecast')?.pvalue"
                :forecasts="todayOnly"
                class="mt-4 !rounded-2xl bg-white/50 backdrop-blur-sm dark:bg-neutral-800/90"
                title="Prévisions de la journée"
                mode="hour"
              />
            </WeatherWidget>
            <div class="mt-4 grid-cols-1 gap-2 space-y-2 sm:grid md:grid-cols-2 md:space-y-0 lg:grid-flow-row-dense">
              <WidgetForecast
                class="col-span-2 md:col-span-4"
                v-if="forecast?.value && getPreference('display_forecast')?.pvalue"
                :forecasts="nextDays"
                title="Prévisions pour les prochains jours"
                mode="date"
              />
              <WidgetWind :wind="data?.wind" />
              <WidgetSunPhases :sys="data?.sys" />
              <WidgetHumidity :humidity="data?.main?.humidity" />
              <WidgetPressure :pressure="data?.main?.pressure" />
              <WidgetClouds :clouds="data?.clouds" />
            </div>
          </div>
          <aside class="mt-4 opacity-50 duration-200 hover:opacity-100 lg:mt-0">
            <h1 class="text-lg font-semibold">Autres villes</h1>
            <div class="flex flex-wrap gap-2 lg:flex-col">
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
