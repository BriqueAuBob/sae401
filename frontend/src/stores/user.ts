import { defineStore } from 'pinia';
import { onMounted, ref } from 'vue';
import { fetchFromApi } from '../lib/fetch';
import type { Preference } from '../types/preference';

type User = {
  username: string;
  email: string;
  preferences: Preference[];
};

export default defineStore('user', () => {
  const user = ref<User | null>(null);
  const token = ref(localStorage.getItem('token'));

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

  const login = (username: string, password: string) => {
    fetchFromApi<{ token: string }>('/auth/login', {
      method: 'POST',
      body: {
        username,
        password,
      },
    }).then((data) => {
      handleAuthentification(data.token);
      window.location.href = '/';
    });
  };

  const register = (username: string, email: string, password: string) => {
    fetchFromApi<{ token: string }>('/auth/register', {
      method: 'POST',
      body: {
        username,
        email,
        password,
      },
    }).then((data) => {
      handleAuthentification(data.token);
      window.location.href = '/';
    });
  };

  const logout = () => {
    token.value = null;
    user.value = null;
    localStorage.removeItem('token');
    window.location.href = '/';
  };

  const updatePreference = async (preference: Preference) => {
    if (!user.value) return;
    const prefStore = user.value?.preferences?.find((p) => p.id === preference.id);
    if (!prefStore) return;
    prefStore.pvalue = preference.pvalue;
  };

  const findPreference = (key: string) => {
    return user.value?.preferences?.find((p) => p.pkey === key);
  };

  return {
    user,
    token,
    login,
    register,
    logout,
    updatePreference,
    findPreference,
  };
});
