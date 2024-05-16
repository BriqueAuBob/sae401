<script setup lang="ts">
import Card from '../Card.vue';
import usePreference from '../../composables/usePreference';

defineProps({
  humidity: {
    type: Number,
    required: true,
  },
});

const preferenceName = 'display_humidity';
const getPreference = usePreference();
</script>

<template>
  <Card v-if="getPreference(preferenceName)">
    <div class="text-lg font-medium">Humidité</div>
    <span class="text-3xl font-bold">{{ humidity }}%</span>
  </Card>
</template>
