<script setup lang="ts">
import Button from '../components/Button.vue';
import Layout from '../layouts/default.vue';
import WeatherWidget from '../components/WeatherWidget.vue';
import useAuthStore from '../stores/user';
import usePreference from '../composables/usePreference';
import { computed } from 'vue';

const authStore = useAuthStore();
const getPreference = usePreference();

const citiesPreference = computed(() => getPreference('cities')?.pvalue);
</script>

<template>
  <Layout>
    <header class="from-primary-200 dark:from-primary-700 bg-gradient-to-b pb-16 pt-36 text-center">
      <h1 class="text-4xl font-bold">La météo à portée de clic</h1>
      <h2 class="mx-auto mt-2 max-w-xl text-balance text-lg">
        Des prévisions météo précises et actualisées pour planifier votre journée en toute confiance, où que vous soyez
      </h2>
      <Button class="mt-4" v-if="!authStore.user">Connexion</Button>
    </header>
    <section class="container py-8">
      <h1 class="mb-4 text-center text-xl font-bold">{{ authStore?.user ? 'Villes favorites' : 'Météo de villes connues' }}</h1>
      <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3">
        <RouterLink
          v-for="city of citiesPreference"
          :key="city"
          :to="{
            name: '/meteo/[city]',
            params: { city },
          }"
          class="cursor-pointer duration-200 hover:-translate-y-1 hover:brightness-105"
        >
          <WeatherWidget :city="city" />
        </RouterLink>
      </div>
    </section>
  </Layout>
</template>
