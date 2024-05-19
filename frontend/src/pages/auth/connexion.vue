<script setup lang="ts">
import { reactive, ref } from 'vue';
import useUserStore from '../../stores/user';
import AuthLayout from '../../layouts/auth.vue';
import Input from '../../components/Input.vue';
import Button from '../../components/Button.vue';
import ErrorsAlert from '../../components/ErrorsAlert.vue';

const errors = ref<
  {
    title: string;
    message: string;
  }[]
>([]);
const userStore = useUserStore();
const form = reactive({
  email: '',
  password: '',
});

const login = async () => {
  try {
    await userStore.login(form.email, form.password);
  } catch (error: any) {
    switch (error.message) {
      case 'Invalid credentials.':
        errors.value = [
          {
            title: 'Identifiants incorrects',
            message: 'Vérifiez votre email et votre mot de passe',
          },
        ];
        break;
      default:
        errors.value = [
          {
            title: 'Une erreur est survenue',
            message: 'Veuillez réessayer plus tard',
          },
        ];
        break;
    }
  }
};
</script>

<template>
  <AuthLayout>
    <div class="container flex flex-col gap-2">
      <div class="mb-2">
        <h1 class="text-2xl font-bold">Connexion</h1>
        <h2 class="text-balance text-sm">Récupère tes préférences en te connectant à ton compte</h2>
      </div>
      <ErrorsAlert :errors="errors" />
      <form @submit.prevent="login" class="flex flex-col gap-2">
        <div class="w-full">
          <Input class="w-full" label="Email" type="email" v-model="form.email" placeholder="Entrez votre email..." required />
        </div>
        <div class="w-full">
          <Input
            class="w-full"
            label="Mot de passe"
            type="password"
            v-model="form.password"
            placeholder="Entrez votre mot de passe..."
            required
          />
          <RouterLink
            :to="{
              name: '/auth/reset-password/',
            }"
            class="mt-4 self-start text-xs text-neutral-500 underline"
          >
            Mot de passe oublié
          </RouterLink>
        </div>
        <Button class="mt-2" type="submit">Connexion</Button>
      </form>
      <RouterLink
        :to="{
          name: '/auth/inscription',
        }"
        class="text-primary-900 dark:text-primary-300 mt-2 self-start text-sm underline"
      >
        Pas encore de compte ? Inscrivez-vous
      </RouterLink>
    </div>
  </AuthLayout>
</template>
