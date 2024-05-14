<script setup lang="ts">
import useUserStore from "./stores/user";

const userStore = useUserStore();
</script>

<template>
  User:
  {{ userStore.user }}
  <RouterView />
</template>
