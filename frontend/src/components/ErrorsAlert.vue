<script setup lang="ts">
import { PropType } from 'vue';
import Alert from './Alert.vue';

defineProps({
  errors: {
    type: Array as PropType<
      {
        title: string;
        message: string;
      }[]
    >,
    required: true,
  },
});
</script>

<template>
  <TransitionGroup name="slide-fade" :duration="500">
    <Alert v-for="error in errors" :key="error.title" type="error" :title="error.title" :message="error.message" />
  </TransitionGroup>
</template>
