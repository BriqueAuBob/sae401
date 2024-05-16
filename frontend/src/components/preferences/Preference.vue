<script setup lang="ts">
import { PropType } from 'vue';
import type { Preference } from '../../types/preference';
import Input from '../Input.vue';
import Toggle from '../Toggle.vue';
import { fetchFromApi } from '../../lib/fetch';
import useUserStore from '../../stores/user';
import preferences from '../../lib/preferences';

const userStore = useUserStore();
const props = defineProps({
  preference: {
    type: Object as PropType<Preference>,
    required: true,
  },
});
const wrappedPreference = preferences[props.preference.pkey as keyof typeof preferences];

const handleModification = () => {
  if (!props.preference.id) return;
  fetchFromApi(`/users/@me/preferences/${props.preference.id}`, {
    method: 'PUT',
    body: {
      pvalue: props.preference.pvalue,
    },
  });
  userStore.updatePreference(props.preference);
};

const components = {
  JSON: {
    component: Input,
    events: {},
  },
  NUMBER: {
    component: Input,
    events: {},
  },
  STRING: {
    component: Input,
    events: {},
  },
  BOOLEAN: {
    component: Toggle,
    events: {
      'update:modelValue': handleModification,
    },
  },
};
</script>

<template>
  <div class="flex flex-col items-start gap-4 p-4 lg:flex-row">
    <div>
      <div class="text-md font-semibold">
        {{ wrappedPreference?.title }}
      </div>
      <p class="max-w-xl text-sm">
        {{ wrappedPreference?.description }}
      </p>
    </div>
    <div class="flex w-full self-center lg:w-1/2 lg:justify-end">
      <component
        v-if="wrappedPreference?.component"
        :is="wrappedPreference?.component"
        v-model="preference.pvalue"
        @update:modelValue="handleModification"
        v-bind="wrappedPreference"
        v-on="wrappedPreference?.events || {}"
      />
      <component
        v-else-if="components[preference.ptype as keyof typeof components]"
        :is="components[preference.ptype as keyof typeof components].component"
        v-model="preference.pvalue"
        @blur="handleModification"
        v-on="wrappedPreference?.events || components[preference.ptype as keyof typeof components].events || {}"
      />
    </div>
  </div>
</template>
