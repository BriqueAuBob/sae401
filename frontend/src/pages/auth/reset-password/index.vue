<script setup lang="ts">
import { ref } from 'vue';
import { fetchFromApi } from '../../../lib/fetch';
import AuthLayout from '../../../layouts/auth.vue';
import Input from '../../../components/Input.vue';
import Button from '../../../components/Button.vue';

const email = ref('');

const sendResetPasswordRequest = async () => {
  try {
    fetchFromApi('auth/reset-password', {
      method: 'POST',
      body: { email: email.value },
    });
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <AuthLayout>
    <h1>Réinitialiser le mot de passe</h1>
    <form @submit.prevent="sendResetPasswordRequest">
      <Input type="email" label="Email" v-model="email" />
      <button type="submit">Envoyer la demande</button>
    </form>
  </AuthLayout>
</template>
