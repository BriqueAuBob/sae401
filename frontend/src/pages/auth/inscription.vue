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
  username: '',
  password: '',
  password_confirm: '',
});

const register = async () => {
  try {
    await userStore.register(form);
  } catch (err: any) {
    errors.value = err.violations.map((violation: any) => {
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
        <h1 class="text-2xl font-bold">Inscription</h1>
        <h2 class="text-balance text-sm">Gère tes préférences en te créant un compte</h2>
      </div>
      <ErrorsAlert :errors="errors" />
      <form @submit.prevent="register" class="flex flex-col gap-4">
        <div class="w-full">
          <Input class="w-full" label="Email" type="email" v-model="form.email" placeholder="Email" required />
        </div>
        <div class="w-full">
          <Input class="w-full" label="Nom d'utilisateur" type="text" v-model="form.username" placeholder="Nom d'utilisateur" required />
        </div>
        <div class="w-full">
          <Input class="w-full" label="Mot de passe" type="password" v-model="form.password" placeholder="Mot de passe" required />
        </div>
        <div class="w-full">
          <Input
            class="w-full"
            label="Confirmation du mot de passe"
            type="password"
            v-model="form.password_confirm"
            placeholder="Mot de passe"
            required
          />
        </div>
        <Button type="submit">Inscription</Button>
      </form>
    </div>
  </AuthLayout>
</template>
