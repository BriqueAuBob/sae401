<script setup lang="ts">
import useUserStore from '../stores/user';
import PreferencesList from '../components/preferences/List.vue';
import Layout from '../layouts/default.vue';
import Button from '../components/Button.vue';

const userStore = useUserStore();
</script>

<template>
  <Layout>
    <div class="container py-8 pt-24">
      <h1>Compte</h1>
      <p>Vous êtes connecté en tant que {{ userStore.user?.email }}</p>
      <PreferencesList />
      <Button color="red" @click="userStore.logout">Déconnexion</Button>
    </div>
  </Layout>
</template>
