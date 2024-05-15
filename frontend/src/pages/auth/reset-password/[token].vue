<script setup lang="ts">
import { reactive } from "vue";
import { useRoute, useRouter } from "vue-router";
import { fetchFromApi } from "../../../lib/fetch";

const route = useRoute();
const router = useRouter();
const token = route.params.token;

const form = reactive({
  password: "",
  confirm_password: "",
});

const resetPassword = async () => {
  await fetchFromApi("auth/reset-password/" + token, {
    method: "POST",
    body: form,
  });
  router.push({
    name: "/auth/connexion",
  });
};
</script>

<template>
  <div>
    <h1>Réinitialiser le mot de passe</h1>
    <form @submit.prevent="resetPassword">
      <input
        v-model="form.password"
        type="password"
        placeholder="Nouveau mot de passe"
      />
      <input
        v-model="form.confirm_password"
        type="password"
        placeholder="Confirmer le mot de passe"
      />
      <button type="submit">Réinitialiser</button>
    </form>
  </div>
</template>
