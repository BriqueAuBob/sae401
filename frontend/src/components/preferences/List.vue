<script setup lang="ts">
import useFetch from '../../composables/useFetch';
import { Preference } from '../../types/preference';
import PreferenceComponent from './Preference.vue';

const { data: preferences, loading } = useFetch<Preference[]>('/users/@me/preferences');
</script>

<template>
    <h2>Préférences</h2>
    <div v-if="loading">Chargement...</div>
    <ul v-else>
        <li v-for="preference in preferences" :key="preference.id">
            <PreferenceComponent :preference="preference" />
        </li>
    </ul>
</template>