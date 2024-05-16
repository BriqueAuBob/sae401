<script setup lang="ts">
import Card from '../Card.vue';
import usePreference from '../../composables/usePreference';

defineProps({
  pressure: {
    type: Number,
    required: true,
  },
});

const preferenceName = 'display_pressure';
const getPreference = usePreference();
</script>

<template>
  <Card v-if="getPreference(preferenceName)?.pvalue">
    <div class="text-lg font-medium">Pression</div>
    <span class="text-3xl font-bold">{{ pressure }}hPa</span>
  </Card>
</template>
