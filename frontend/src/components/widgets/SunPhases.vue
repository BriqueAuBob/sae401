<script setup lang="ts">
import { PropType } from 'vue';
import { Sys } from '../../types/openweather';
import Card from '../Card.vue';
import usePreference from '../../composables/usePreference';

defineProps({
  sys: {
    type: Object as PropType<Sys>,
    required: true,
  },
});

const preferenceName = 'display_sun_phases';
const getPreference = usePreference();

const getSunrise = (timestamp: number) => {
  return new Date(timestamp * 1000).toLocaleTimeString('fr-FR', {
    hour: '2-digit',
    minute: '2-digit',
  });
};
</script>

<template>
  <Card as="article" v-if="getPreference(preferenceName)">
    <div class="text-lg font-medium">Couché</div>
    <span class="text-3xl font-bold">{{ getSunrise(sys.sunset) }}</span>

    <div class="flex items-center gap-2">
      <div class="text-sm font-medium">Levé</div>
      <span class="text-md font-bold">{{ getSunrise(sys.sunrise) }}</span>
    </div>
  </Card>
</template>
