<script setup lang="ts">
import { reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { fetchFromApi } from '../../../lib/fetch';
import AuthLayout from '../../../layouts/auth.vue';
import Input from '../../../components/Input.vue';
import Button from '../../../components/Button.vue';

const route = useRoute();
const router = useRouter();
const token = route.params.token;

const form = reactive({
  password: '',
  confirm_password: '',
});

const resetPassword = async () => {
  await fetchFromApi('auth/reset-password/' + token, {
    method: 'POST',
    body: form,
  });
  router.push({
    name: '/auth/connexion',
  });
};
</script>

<template>
  <AuthLayout>
    <h1>Réinitialiser le mot de passe</h1>
    <form @submit.prevent="resetPassword">
      <Input v-model="form.password" type="password" placeholder="Nouveau mot de passe" />
      <Input v-model="form.confirm_password" type="password" placeholder="Confirmer le mot de passe" />
      <Button type="submit">Réinitialiser</Button>
    </form>
  </AuthLayout>
</template>
