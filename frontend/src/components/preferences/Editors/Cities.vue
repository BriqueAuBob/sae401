<script setup lang="ts">
import { ref } from 'vue';
import Input from '../../Input.vue';
import WeatherWidget from '../../WeatherWidget.vue';
import Button from '../../Button.vue';

const MAX_CITIES = 6;
const city = ref('');
const model = defineModel<string[]>({
  default: [],
});

const addCity = () => {
  if (city.value && !model.value.includes(city.value) && model.value.length < MAX_CITIES) {
    model.value = [...model.value, city.value];
    city.value = '';
  }
};

const deleteCity = (city: string) => {
  model.value = model.value.filter((c) => c !== city);
};
</script>

<template>
  <div class="w-full p-4">
    <div class="text-md mb-1 font-medium">Ajout d'une ville ({{ model.length }}/{{ MAX_CITIES }})</div>
    <TransitionGroup name="fade">
      <div class="mb-3 grid grid-cols-2 gap-1" v-if="model.length > 0">
        <TransitionGroup name="slide-fade">
          <div v-for="city in model" :key="city" class="group relative">
            <WeatherWidget :city="city" class="h-full !p-3" />
            <Button
              class="!absolute right-2 top-2 z-50 flex h-8 w-8 items-center justify-center opacity-0 duration-200 group-hover:opacity-100"
              style="padding: 0"
              color="white"
              @click="deleteCity(city)"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </Button>
          </div>
        </TransitionGroup>
      </div>
      <div class="py-2" v-else>
        <div class="mb-1 w-full text-center text-sm text-gray-700 dark:text-gray-300">Aucune ville ajoutée en favori</div>
        <div class="mb-4 w-full text-balance text-center text-xs text-gray-400">
          Ajoute des villes à ta liste de villes favories pour les voir apparaitre sur la page d'accueil
        </div>
      </div>
    </TransitionGroup>
    <Input
      class="w-full"
      label="Ville à ajouter"
      v-model="city"
      placeholder="Paris"
      @keyup.enter="addCity"
      :disabled="model.length >= MAX_CITIES"
    />
  </div>
</template>
