<script setup lang="ts">
import { PropType } from 'vue';
import { Wind } from '../../types/openweather';
import Card from '../Card.vue';
import useWind from '../../composables/useWind';
import usePreference from '../../composables/usePreference';

defineProps({
  wind: {
    type: Object as PropType<Wind>,
    required: true,
  },
});

const preferenceName = 'display_wind';
const getPreference = usePreference();
const { getWindSpeed, getWindDirection } = useWind();
</script>

<template>
  <Card v-if="getPreference(preferenceName)">
    <h2 class="text-lg font-medium">Vent</h2>
    <span class="text-3xl font-bold">{{ getWindSpeed(wind.speed) }}</span>
    <div class="mt-4 flex items-center justify-end gap-2">
      <svg
        :style="`transform: rotate(${wind.deg}deg)`"
        class="inline-block"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path d="M12 2V22M12 2L15 5M12 2L9 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      <span class="text-lg">{{ getWindDirection(wind.deg) }}</span>
    </div>
  </Card>
</template>
