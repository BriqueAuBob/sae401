<script setup lang="ts">
import { PropType } from 'vue';
import type { Preference } from '../../types/preference';
import Input from '../Input.vue';
import { fetchFromApi } from '../../lib/fetch';
import useUserStore from '../../stores/user';

const userStore = useUserStore();
const props = defineProps({
  preference: {
    type: Object as PropType<Preference>,
    required: true
  }
})

const components = {
    JSON: Input,
    NUMBER: Input,
    STRING: Input,
    BOOLEAN: Input,
}

const handleModification = () => {
    fetchFromApi(`/users/@me/preferences/${props.preference.id}`, {
        method: 'PUT',
        body: {
            pvalue: props.preference.pvalue
        }
    })
    userStore.updatePreference(props.preference)
}
</script>

<template>
    <div class="p-4 flex justify-between">
        <div>
            {{ preference.pkey }}
            {{ preference.ptype }}
        </div>
        <component 
            v-if="components[preference.ptype]" 
            :is="components[preference.ptype]" 
            v-model="preference.pvalue"
            @blur="handleModification"
        />
    </div>
</template>