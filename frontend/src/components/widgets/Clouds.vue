<script setup lang="ts">
import { PropType } from 'vue';
import { Clouds } from '../../types/openweather';
import Card from '../Card.vue';
import usePreference from '../../composables/usePreference';

defineProps({
  clouds: {
    type: Object as PropType<Clouds>,
    required: true,
  },
});

const preferenceName = 'display_clouds';
const getPreference = usePreference();
</script>

<template>
  <Card v-if="getPreference(preferenceName)?.pvalue">
    <div class="text-lg font-medium">Nuages</div>
    <span class="text-3xl font-bold">{{ clouds.all }}%</span>
  </Card>
</template>
