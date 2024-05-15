<script setup lang="ts">
import useUserStore from '../stores/user';
import PreferencesList from '../components/preferences/List.vue';
import Layout from '../layouts/default.vue';
import Button from '../components/Button.vue';

const userStore = useUserStore();
</script>

<template>
  <Layout>
    <div class="container py-8 pt-32">
      <h1 class="text-xl font-semibold">Compte</h1>
      <h2 class="mb-4 text-sm font-medium">Vous êtes connecté en tant que {{ userStore.user?.username }} ({{ userStore.user?.email }})</h2>
      <PreferencesList />
      <div class="flex justify-center">
        <Button class="mx-auto mt-8" color="red" @click="userStore.logout">Déconnexion</Button>
      </div>
    </div>
  </Layout>
</template>
