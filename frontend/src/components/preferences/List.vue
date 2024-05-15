<script setup lang="ts">
import useFetch from '../../composables/useFetch';
import { Preference } from '../../types/preference';
import PreferenceComponent from './Preference.vue';

const { data: preferences, loading } = useFetch<Preference[]>('/users/@me/preferences');
</script>

<template>
  <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
    <h2 class="p-4 text-xl font-semibold">Préférences</h2>
    <div class="m-1 rounded-3xl bg-neutral-100">
      <div v-if="loading">Chargement...</div>
      <ul v-else class="flex flex-col gap-4 divide-y p-4">
        <li v-for="preference in preferences" :key="preference.id">
          <PreferenceComponent :preference="preference" />
        </li>
      </ul>
    </div>
  </div>
</template>
