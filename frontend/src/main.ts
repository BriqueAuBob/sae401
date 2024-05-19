import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import { createRouter, createWebHistory } from "vue-router/auto";
import { createPinia } from "pinia";
import { PiniaSharedState } from "pinia-shared-state";

const router = createRouter({
  history: createWebHistory(),
});
const pinia = createPinia().use(PiniaSharedState({
  enable: true,
  initialize: true,
  type: 'localstorage'
}))

createApp(App).use(router).use(pinia).mount("#app");
