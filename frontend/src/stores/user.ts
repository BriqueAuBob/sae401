import { defineStore } from 'pinia';
import { onMounted, ref } from 'vue';
import { fetchFromApi } from '../lib/fetch';
import type { Preference } from '../types/preference';
import preferences, { Preference as PreferenceType } from '../lib/preferences';
import { toast } from 'vue-sonner';
import { useRouter } from 'vue-router';

type User = {
  username: string;
  email: string;
  preferences: Preference[];
};

export default defineStore('user', () => {
  const user = ref<User | null>(null);
  const token = ref(localStorage.getItem('token'));
  const router = useRouter();

  const initStore = async () => {
    if (token.value) {
      const response = await fetchFromApi<User>('users/@me');
      user.value = response;
    }
  };

  onMounted(initStore);

  const handleAuthentification = (tkn: string) => {
    token.value = tkn;
    localStorage.setItem('token', tkn);
    initStore();
  };

  const login = async (username: string, password: string) => {
    try {
      const data = await fetchFromApi<{ token: string }>('/auth/login', {
        method: 'POST',
        body: {
          username,
          password,
        },
      });
      handleAuthentification(data.token);
      router.push('/');
    } catch (err: any) {
      throw err;
    }
  };

  const register = async (form: { username: string; email: string; password: string; password_confirm: string }) => {
    try {
      const data = await fetchFromApi<{ token: string }>('/auth/register', {
        method: 'POST',
        body: form,
      });
      handleAuthentification(data.token);
      router.push('/');
    } catch (err) {
      throw err;
    }
  };

  const logout = () => {
    token.value = null;
    user.value = null;
    localStorage.removeItem('token');
    router.push('/');
  };

  const updatePreference = async (preference: Preference) => {
    if (!user.value) return;
    const prefStore = user.value?.preferences?.find((p) => p.id === preference.id);
    if (!prefStore) return;
    prefStore.pvalue = preference.pvalue;
  };

  const findPreference = (key: keyof typeof preferences) => {
    const defaultPreference = preferences[key] as PreferenceType;
    return user.value
      ? user.value?.preferences?.find((p) => p.pkey === key)
      : {
          id: 0,
          pkey: key,
          pvalue: defaultPreference.value,
        };
  };

  const updateAccount = async (form: { username: string; email: string; password: string; password_confirm: string }) => {
    try {
      const data = await fetchFromApi<{ token: string; user: User; message: string }>('/users/@me', {
        method: 'PUT',
        body: form,
      });
      user.value = data.user;
      return data;
    } catch (err) {
      throw err;
    }
  };

  return {
    user,
    token,
    login,
    register,
    logout,
    updatePreference,
    findPreference,
    updateAccount,
  };
});
