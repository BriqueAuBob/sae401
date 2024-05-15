<script setup lang="ts">
import { useRouter } from 'vue-router';
import useUserStore from '../stores/user';
import Input from './Input.vue';
import Button from './Button.vue';
import { ref } from 'vue';

const city = ref('');
const router = useRouter();

const userStore = useUserStore();
const searchCity = () => {
  if (city.value) {
    router.push({
      name: '/meteo/[city]',
      params: {
        city: city.value,
      },
    });
  }
};
</script>

<template>
  <div
    class="left-O container fixed left-1/2 top-2 z-50 -translate-x-1/2 rounded-full border bg-white/80 px-6 py-4 shadow-sm backdrop-blur-sm"
  >
    <div class="relative flex items-center justify-between">
      <div>
        <router-link
          :to="{
            name: '/',
          }"
          class="text-xl font-bold"
        >
          WeatherApp
        </router-link>
      </div>
      <Input
        v-model="city"
        class="absolute left-1/2 w-1/3 -translate-x-1/2"
        placeholder="Rechercher une ville..."
        label="Ville"
        hiddenLabel
        @keyup.enter="searchCity"
      />
      <div v-if="!userStore.user">
        <router-link
          :to="{
            name: '/auth/connexion',
          }"
          class="text-lg font-bold"
        >
          <Button color="blue"> Accéder à mon compte </Button>
        </router-link>
      </div>
      <div v-else>
        <router-link
          :to="{
            name: '/compte',
          }"
          class="text-lg font-bold"
        >
          {{ userStore.user.username }}
        </router-link>
      </div>
    </div>
  </div>
</template>
