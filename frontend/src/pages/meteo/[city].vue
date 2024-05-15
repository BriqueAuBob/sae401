<script setup lang="ts">
import { useRoute } from 'vue-router'
import useFetch from '../../composables/useFetch';
import useTemperature from '../../composables/useTemperature';
import { ref, watch } from 'vue';

const route = useRoute()
const city = route.params.city

const { data, loading } = useFetch<any>(`/weather/${city}`)
const { getTemperature } = useTemperature()
</script>

<template>
    <div v-if="loading">Loading...</div>
    <div v-else>
        <h1>{{ data.name }}</h1>
        <p>{{ data.weather[0].description }}</p>
        <p>{{ getTemperature(data?.main?.temp) }}</p>
    </div>
</template>