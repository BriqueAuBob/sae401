<script setup lang="ts">
import useUserStore from "../stores/user";
import PreferencesList from "../components/preferences/List.vue";

const userStore = useUserStore();
</script>

<template>
    <h1>Compte</h1>
    <p>Vous êtes connecté en tant que {{ userStore.user?.email }}</p>
    <PreferencesList />
    <button @click="userStore.logout">Déconnexion</button>
</template>