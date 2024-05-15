<script setup lang="ts">
import { useRoute } from 'vue-router';
import useFetch from '../../composables/useFetch';
import useTemperature from '../../composables/useTemperature';
import LoadingIndicator from '../../components/LoadingIndicator.vue';
import { watch } from 'vue';
import Layout from '../../layouts/default.vue';

const route = useRoute();
const city = route.params.city;

const { data, loading, error, getData } = useFetch<any>(`/weather/${city}`);
const { getTemperature } = useTemperature();

watch(
  () => route.params.city,
  (newCity) => {
    getData(`/weather/${newCity}`);
  }
);
</script>

<template>
  <Layout>
    <div class="container py-8 pt-24">
      <LoadingIndicator v-if="loading" />
      <template v-else-if="error">Error: {{ error.message }}</template>
      <template v-else>
        <h1>{{ data.name }}</h1>
        <p>{{ data.weather[0].description }}</p>
        <p>{{ getTemperature(data?.main?.temp) }}</p>
      </template>
    </div>
  </Layout>
</template>
