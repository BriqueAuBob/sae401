<script setup lang="ts">
import { reactive } from "vue";
import useUserStore from "../../stores/user";

const userStore = useUserStore();
const form = reactive({
  email: "",
  password: "",
});

const login = () => {
  userStore.login(form.email, form.password);
};
</script>

<template>
  <form @submit.prevent="login" class="container flex flex-col gap-2">
    <input type="email" v-model="form.email" placeholder="Email" required />
    <input
      type="password"
      v-model="form.password"
      placeholder="Mot de passe"
      required
    />
    <button type="submit">Connexion</button>
  </form>
</template>
