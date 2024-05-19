<script setup lang="ts">
import { useRouter } from 'vue-router';
import useUserStore from '../stores/user';
import Input from './Input.vue';
import Button from './Button.vue';
import { ref } from 'vue';
import Avatar from './Avatar.vue';

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
    class="left-O container fixed left-1/2 top-2 z-[90] -translate-x-1/2 rounded-full border bg-white/80 px-6 py-4 shadow-sm backdrop-blur-sm dark:border-neutral-700 dark:bg-neutral-800/80"
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
      <div class="flex items-center gap-2">
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
            class="text-md flex items-center gap-2 rounded-xl border-2 border-transparent bg-neutral-50 px-4 py-2 font-bold duration-200 hover:-translate-y-2 hover:border-neutral-100 hover:shadow-sm dark:bg-neutral-700 dark:hover:border-neutral-600"
          >
            <Avatar size="sm" :username="userStore.user.username" />
            {{ userStore.user.username }}
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
