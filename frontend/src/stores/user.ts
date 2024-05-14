import { defineStore } from "pinia";
import { onMounted, ref } from "vue";
import { fetchFromApi } from "../lib/fetch";

type User = {
  username: string;
  email: string;
};

export default defineStore("user", () => {
  const user = ref<User | null>(null);
  const token = ref(localStorage.getItem("token"));

  const initStore = async () => {
    if (token.value) {
      const response = await fetchFromApi<User>("users/@me");
      user.value = response;
    }
  };

  onMounted(initStore);

  const handleAuthentification = (tkn: string) => {
    token.value = tkn;
    localStorage.setItem("token", tkn);
    initStore();
  };

  const login = (username: string, password: string) => {
    fetchFromApi<{ token: string }>("/auth/login", {
      method: "POST",
      body: {
        username,
        password,
      },
    }).then((data) => {
      handleAuthentification(data.token);
    });
  };

  const register = (username: string, email: string, password: string) => {
    fetchFromApi<{ token: string }>("/auth/register", {
      method: "POST",
      body: {
        username,
        email,
        password,
      },
    }).then((data) => {
      handleAuthentification(data.token);
    });
  };

  return {
    user,
    token,
    login,
    register,
  };
});
