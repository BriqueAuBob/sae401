<script setup lang="ts">
import Button from '../components/Button.vue';
import Layout from '../layouts/default.vue';
</script>

<template>
  <Layout>
    <header class="py-8 pt-28 text-center">
      <h1 class="text-4xl font-bold">La météo à portée de clic</h1>
      <h2 class="mx-auto mt-2 max-w-xl text-balance text-lg">
        Des prévisions météo précises et actualisées pour planifier votre journée en toute confiance, où que vous soyez
      </h2>
      <Button class="mt-4">Connexion</Button>
    </header>
  </Layout>
</template>
