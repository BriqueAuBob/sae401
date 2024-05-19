<script setup lang="ts">
import Button from '../components/Button.vue';

const goBack = () => {
  window.history.back();
};
</script>

<template>
  <div class="grid lg:grid-cols-2">
    <img
      class="h-full max-h-screen w-full object-cover"
      src="https://images.unsplash.com/photo-1617150119111-09bbb85178b0?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGNpZWwlMjBibGV1fGVufDB8fDB8fHww"
    />
    <main class="container flex min-h-screen flex-col items-center justify-center">
      <Button size="xs" class="mb-4 ml-4 self-start" color="white" @click="goBack">Retour</Button>
      <slot></slot>
    </main>
  </div>
</template>
