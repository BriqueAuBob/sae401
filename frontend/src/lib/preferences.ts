import TabSelector from '../components/preferences/TabSelector.vue';

const PREFERENCES = {
  temp_unit: {
    title: 'Unité de température',
    description: 'Unité de température utilisée pour afficher les températures',
    value: 'celsius',
    options: [
      { value: 'celsius', label: 'Celsius' },
      { value: 'fahrenheit', label: 'Fahrenheit' },
      { value: 'kelvin', label: 'Kelvin' },
    ],
    component: TabSelector,
  },
};

export default PREFERENCES;
