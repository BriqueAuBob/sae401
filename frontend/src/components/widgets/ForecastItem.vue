<script setup lang="ts">
import { computed, PropType, ref } from 'vue';
import type { Forecast } from '../../types/openweather';
import useTemperature from '../../composables/useTemperature';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue';
import Button from '../Button.vue';

const props = defineProps({
  forecast: {
    type: Object as PropType<
      Forecast & {
        forecasts?: Forecast[];
      }
    >,
    required: true,
  },
  mode: {
    type: String as PropType<'date' | 'hour'>,
    required: false,
    default: 'date',
  },
});

const addZero = (value: number) => {
  if (value < 10) {
    return '0' + value;
  }
  return value;
};

const date = computed(() => {
  return new Date(props.forecast.dt * 1000);
});

const hour = computed(() => {
  return addZero(date.value.getHours());
});

const day = computed(() => {
  return addZero(date.value.getDate());
});

const month = computed(() => {
  return addZero(date.value.getMonth() + 1);
});

const getWeatherStateTitle = (state: any) => {
  return state.description.charAt(0).toUpperCase() + state.description.slice(1);
};

const getTimeString = (timestamp: number) => {
  const date = new Date(timestamp * 1000);
  return addZero(date.getHours()) + 'h00';
};

const { getTemperature } = useTemperature();

const isOpen = ref(false);

const closeModal = () => {
  isOpen.value = false;
};

const openModal = () => {
  if (props.mode === 'hour') return;
  isOpen.value = true;
};
</script>

<template>
  <component
    :is="mode === 'date' ? 'button' : 'div'"
    class="flex flex-col items-center"
    @click="openModal"
    :class="{
      'w-full cursor-pointer rounded-3xl p-4 duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700': mode === 'date',
    }"
  >
    <div class="text-sm font-medium">{{ mode === 'date' ? day + '/' + month : hour + 'h00' }}</div>
    <img
      :src="`http://openweathermap.org/img/wn/${forecast.weather[0].icon}.png`"
      :alt="forecast.weather[0].description"
      class="h-12 w-12"
    />
    <div class="mb-1 text-center text-sm">{{ getWeatherStateTitle(forecast.weather[0]) }}</div>
    <div class="text-sm">{{ getTemperature(forecast.main.temp) }}</div>
  </component>

  <TransitionRoot appear :show="isOpen" as="template" v-if="mode === 'date'">
    <Dialog as="div" @close="closeModal" class="relative z-[90]">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-[1px]" />
      </TransitionChild>

      <div class="fixed inset-0 z-[90] overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="relative max-h-96 w-full max-w-md transform overflow-hidden overflow-y-scroll rounded-3xl border border-neutral-100 bg-white p-6 text-left align-middle shadow-xl shadow-neutral-800 transition-all dark:border-neutral-700 dark:bg-neutral-800"
            >
              <DialogTitle as="h3" class="text-lg font-semibold leading-6"> Prévisions pour le {{ day }}/{{ month }} </DialogTitle>
              <div class="mb-8 mt-2">
                <div v-for="f in forecast?.forecasts" class="flex items-center gap-2">
                  <div class="text-sm font-medium">{{ getTimeString(f.dt) }}</div>
                  <img
                    :src="`http://openweathermap.org/img/wn/${f.weather[0].icon}.png`"
                    :alt="forecast.weather[0].description"
                    class="h-12 w-12"
                  />
                  <div class="text-center text-sm">{{ getWeatherStateTitle(f.weather[0]) }}</div>
                  <div class="text-sm">{{ getTemperature(f.main.temp) }}</div>
                </div>
              </div>

              <div class="sticky bottom-0 w-full">
                <Button @click="closeModal" class="w-full" color="primary" size="sm">Fermer</Button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
