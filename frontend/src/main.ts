import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router/auto";
import { createPinia } from "pinia";

const router = createRouter({
  history: createWebHistory(),
});

createApp(App).use(router).use(createPinia()).mount("#app");
