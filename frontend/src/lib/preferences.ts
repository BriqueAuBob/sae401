import Cities from '../components/preferences/Editors/Cities.vue';
import TabSelector from '../components/preferences/Editors/TabSelector.vue';
import SwitchTheme from '../components/SwitchTheme.vue';

export interface Preference {
  title: string;
  description: string;
  value: any;
  options?: { value: any; label: string }[];
  component?: any;
  events?: { [key: string]: Function };
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
  theme: {
    title: 'Thème',
    description: "Choisissez un thème pour personnaliser l'apparence de l'application.",
    value: 'light',
    options: [
      { value: 'light', label: 'Clair' },
      { value: 'dark', label: 'Sombre' },
    ],
    component: SwitchTheme,
    events: {
      'update:modelValue': (value: string) => {
        console.log('value', value);
      },
    },
  },
  display_min_max: {
    title: 'Afficher les températures minimales et maximales',
    description: 'Affichez les températures minimales et maximales dans les prévisions météorologiques.',
    value: true,
  },
};

export default PREFERENCES;
