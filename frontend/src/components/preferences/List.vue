<script setup lang="ts">
import useFetch from '../../composables/useFetch';
import { Preference } from '../../types/preference';
import PreferenceComponent from './Preference.vue';
import LoadingIndicator from '../LoadingIndicator.vue';

const { data: preferences, loading } = useFetch<Preference[]>('/users/@me/preferences');
</script>

<template>
  <section class="overflow-hidden rounded-3xl bg-white shadow-md shadow-neutral-200 dark:bg-neutral-800 dark:shadow-neutral-800">
    <div class="p-4">
      <h2 class="text-lg font-semibold">Préférences</h2>
      <p class="text-sm">Modifie les préférences associées à ton compte !</p>
    </div>
    <div class="mx-1 mb-1 rounded-3xl bg-neutral-100 dark:bg-neutral-700">
      <LoadingIndicator v-if="loading" class="min-h-96" />
      <ul v-else class="flex flex-col divide-y">
        <li v-for="preference in preferences" :key="preference.id">
          <PreferenceComponent :preference="preference" />
        </li>
      </ul>
    </div>
  </section>
</template>
