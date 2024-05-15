<script setup lang="ts">
import { ref } from "vue";
import { fetchFromApi } from "../../../lib/fetch";

const email = ref("");

const sendResetPasswordRequest = async () => {
  try {
    fetchFromApi("auth/reset-password", {
      method: "POST",
      body: { email: email.value },
    });
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <div>
    <h1>Réinitialiser le mot de passe</h1>
    <form @submit.prevent="sendResetPasswordRequest">
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" v-model="email" />
      </div>
      <button type="submit">Envoyer la demande</button>
    </form>
  </div>
</template>
