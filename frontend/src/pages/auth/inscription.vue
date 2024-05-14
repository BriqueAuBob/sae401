<script setup lang="ts">
import { reactive } from "vue";
import useUserStore from "../../stores/user";

const userStore = useUserStore();
const form = reactive({
  email: "",
  username: "",
  password: "",
});

const register = () => {
  userStore.register(form.email, form.username, form.password);
};
</script>

<template>
  <form @submit.prevent="register" class="container flex flex-col gap-2">
    <input type="email" v-model="form.email" placeholder="Email" required />
    <input
      type="text"
      v-model="form.username"
      placeholder="Nom d'utilisateur"
      required
    />
    <input
      type="password"
      v-model="form.password"
      placeholder="Mot de passe"
      required
    />
    <button type="submit">Inscription</button>
  </form>
</template>
