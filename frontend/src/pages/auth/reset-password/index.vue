<script setup lang="ts">
import { ref } from 'vue';
import { fetchFromApi } from '../../../lib/fetch';
import AuthLayout from '../../../layouts/auth.vue';
import Input from '../../../components/Input.vue';
import Button from '../../../components/Button.vue';
import ErrorsAlert from '../../../components/ErrorsAlert.vue';
import Alert from '../../../components/Alert.vue';

const email = ref('');
const errors = ref<
  {
    title: string;
    message: string;
  }[]
>([]);
const message = ref('');

const sendResetPasswordRequest = async () => {
  try {
    const { message: dataMessage } = await fetchFromApi<{ message: string }>('auth/reset-password', {
      method: 'POST',
      body: { email: email.value },
    });
    message.value = dataMessage;
  } catch (error: any) {
    errors.value = !error?.violations
      ? [{ title: '', message: error?.message }]
      : error.violations?.map((violation: any) => {
          return {
            title: '',
            message: violation,
          };
        });
  }
};
</script>

<template>
  <AuthLayout>
    <div class="container flex flex-col gap-2">
      <div class="mb-2">
        <h1 class="text-2xl font-bold">Mot de passe oublié</h1>
        <h2 class="text-balance text-sm">Réinitialise ton mot de passe !</h2>
      </div>
      <ErrorsAlert :errors="errors" />
      <Alert v-if="message" type="success" title="Succès!" :message="message" />
      <form @submit.prevent="sendResetPasswordRequest" class="flex flex-col gap-2">
        <Input type="email" label="Email" v-model="email" />
        <Button type="submit">Envoyer la demande</Button>
      </form>
    </div>
  </AuthLayout>
</template>
