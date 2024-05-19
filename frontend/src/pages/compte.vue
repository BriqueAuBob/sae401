<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import useUserStore from '../stores/user';
import PreferencesList from '../components/preferences/List.vue';
import Layout from '../layouts/default.vue';
import Input from '../components/Input.vue';
import Button from '../components/Button.vue';
import ErrorsAlert from '../components/ErrorsAlert.vue';
import { toast } from 'vue-sonner';
import { useRouter } from 'vue-router';

const userStore = useUserStore();
const router = useRouter();

onMounted(() => {
  if (!userStore.user) {
    router.push('/auth/connexion');
  }
});

const form = reactive<{
  username: string;
  email: string;
  password: string;
  password_confirm: string;
}>({
  username: userStore?.user?.username || '',
  email: userStore?.user?.email || '',
  password: '',
  password_confirm: '',
});
const errors = ref<
  {
    title: string;
    message: string;
  }[]
>([]);

const updateAccount = async () => {
  try {
    const data = await userStore.updateAccount(form);
    toast.success(data.message);
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
            message: error.message,
          },
        ];
        break;
    }
  }
};
</script>

<template>
  <Layout>
    <div class="container py-8 pt-32">
      <h1 class="text-xl font-semibold">Compte</h1>
      <h2 class="mb-4 text-sm font-medium">Vous êtes connecté en tant que {{ userStore.user?.username }} ({{ userStore.user?.email }})</h2>
      <form class="mb-8 flex flex-col space-y-4" @submit.prevent="updateAccount">
        <h3 class="text-lg font-medium">Modifier votre compte</h3>
        <ErrorsAlert :errors="errors" />
        <div class="grid gap-2 lg:grid-cols-2">
          <div class="w-full">
            <Input class="w-full" type="text" v-model="form.username" label="Nom d'utilisateur" placeholder="Nom d'utilisateur" />
          </div>
          <div class="w-full">
            <Input class="w-full" type="email" v-model="form.email" label="Email" placeholder="Email" />
          </div>
          <div class="w-full">
            <Input class="w-full" type="password" v-model="form.password" label="Mot de passe" placeholder="Mot de passe" />
          </div>
          <div class="w-full">
            <Input
              class="w-full"
              type="password"
              v-model="form.password_confirm"
              label="Confirmer le mot de passe"
              placeholder="Confirmer le mot de passe"
            />
          </div>
        </div>
        <Button class="self-end lg:w-1/4" type="submit" color="green">Enregistrer</Button>
      </form>
      <PreferencesList />
      <div class="flex justify-center">
        <Button class="mx-auto mt-8" color="red" @click="userStore.logout">Déconnexion</Button>
      </div>
    </div>
  </Layout>
</template>
