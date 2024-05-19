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
  <Card v-if="getPreference(preferenceName)?.pvalue" class="relative overflow-hidden duration-200 hover:grayscale">
    <div class="text-lg font-medium">Couché</div>
    <span class="text-3xl font-bold">{{ getSunrise(sys.sunset) }}</span>
    <div
      class="absolute -right-4 -top-4 aspect-square w-1/2 rounded-full bg-gradient-to-tr from-orange-500 to-yellow-500 shadow-2xl shadow-orange-500 blur-sm"
    ></div>

    <div class="mt-2 flex items-center gap-2">
      <div class="font-regular text-sm">Levé</div>
      <span class="text-md font-bold">{{ getSunrise(sys.sunrise) }}</span>
    </div>
  </Card>
</template>
