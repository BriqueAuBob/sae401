<script setup lang="ts">
import { PropType } from 'vue';
import type { Preference } from '../../types/preference';
import Input from '../Input.vue';
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

const components = {
  JSON: Input,
  NUMBER: Input,
  STRING: Input,
  BOOLEAN: Input,
};

const handleModification = () => {
  fetchFromApi(`/users/@me/preferences/${props.preference.id}`, {
    method: 'PUT',
    body: {
      pvalue: props.preference.pvalue,
    },
  });
  userStore.updatePreference(props.preference);
};
</script>

<template>
  <div class="flex items-center justify-between">
    <div>
      <div class="text-md font-semibold">
        {{ wrappedPreference?.title }}
      </div>
      <p class="max-w-md text-sm">
        {{ wrappedPreference?.description }}
      </p>
    </div>
    <component
      v-if="wrappedPreference?.component"
      :is="wrappedPreference?.component"
      v-model="preference.pvalue"
      v-bind="wrappedPreference"
      @update:modelValue="handleModification"
    />
    <component
      v-else-if="components[preference.ptype as keyof typeof components]"
      :is="components[preference.ptype as keyof typeof components]"
      v-model="preference.pvalue"
      @blur="handleModification"
    />
  </div>
</template>
