<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { fetchFromApi } from '../../../lib/fetch';
import AuthLayout from '../../../layouts/auth.vue';
import Input from '../../../components/Input.vue';
import Button from '../../../components/Button.vue';
import ErrorsAlert from '../../../components/ErrorsAlert.vue';
import Alert from '../../../components/Alert.vue';
import { toast } from 'vue-sonner';

const route = useRoute();
const router = useRouter();
const token = route.params.token;

const form = reactive({
  password: '',
  confirm_password: '',
});
const message = ref('');
const errors = ref<
  {
    title: string;
    message: string;
  }[]
>([]);

const resetPassword = async () => {
  const sendData = async () => {
    try {
      await fetchFromApi('auth/reset-password/' + token, {
        method: 'POST',
        body: form,
      });
      router.push({
        name: '/auth/connexion',
      });
    } catch (err: any) {
      errors.value = !err?.violations
        ? [{ title: '', message: err?.message }]
        : err.violations?.map((violation: any) => {
            return {
              title: '',
              message: violation,
            };
          });
      throw new Error('Erreur lors de la réinitialisation du mot de passe!');
    }
  };
  toast.promise(sendData, {
    loading: 'Envoi de la demande...',
    success: () => 'Mot de passe réinitialisé avec succès!',
    error: () => 'Erreur lors de la réinitialisation du mot de passe!',
  });
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
      <form @submit.prevent="resetPassword" class="flex flex-col gap-2">
        <Input v-model="form.password" type="password" placeholder="Nouveau mot de passe" />
        <Input v-model="form.confirm_password" type="password" placeholder="Confirmer le mot de passe" />
        <Button type="submit">Réinitialiser</Button>
      </form>
    </div>
  </AuthLayout>
</template>
