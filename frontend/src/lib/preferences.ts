import Cities from '../components/preferences/Editors/Cities.vue';
import TabSelector from '../components/preferences/Editors/TabSelector.vue';

export interface Preference {
  title: string;
  description: string;
  value: any;
  options?: { value: any; label: string }[];
  component?: any;
}

const PREFERENCES: {
  [key: string]: Preference;
} = {
  temp_unit: {
    title: 'Unité de température',
    description: "Choisissez l'unité dans laquelle les températures doivent être affichées.",
    value: 'celsius',
    options: [
      { value: 'celsius', label: 'Celsius' },
      { value: 'fahrenheit', label: 'Fahrenheit' },
      { value: 'kelvin', label: 'Kelvin' },
    ],
    component: TabSelector,
  },
  cities: {
    title: 'Villes favorites',
    description: 'Ajoutez ou supprimez des villes pour lesquelles vous souhaitez afficher les prévisions météorologiques.',
    value: [],
    component: Cities,
  },
};

export default PREFERENCES;
