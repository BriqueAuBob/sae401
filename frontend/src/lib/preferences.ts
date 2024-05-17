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
    value: ['Troyes', 'Paris', 'Lyon', 'Marseille', 'Bordeaux', 'Lille'],
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
  },
  wind_speed_unit: {
    title: 'Unité de vitesse du vent',
    description: "Choisissez l'unité dans laquelle la vitesse du vent doit être affichée.",
    value: 'mps',
    options: [
      { value: 'kmph', label: 'Kilomètres par heure' },
      { value: 'mps', label: 'Mètres par seconde' },
      { value: 'mph', label: 'Miles par heure' },
    ],
    component: TabSelector,
  },
  display_min_max: {
    title: 'Afficher les températures minimales et maximales',
    description: 'Affichez les températures minimales et maximales dans les prévisions météorologiques.',
    value: true,
  },
  display_wind: {
    title: 'Afficher le widget de vent',
    description: 'Affichez la vitesse et la direction du vent dans les prévisions météorologiques.',
    value: true,
  },
  display_sun_phases: {
    title: "Afficher l'heure de lever et de coucher du soleil",
    description: "Affichez l'heure de lever et de coucher du soleil dans les prévisions météorologiques.",
    value: true,
  },
  display_humidity: {
    title: "Afficher l'humidité",
    description: "Affichez le taux d'humidité dans les prévisions météorologiques.",
    value: true,
  },
  display_clouds: {
    title: 'Afficher les nuages',
    description: 'Affichez le pourcentage de couverture nuageuse dans les prévisions météorologiques.',
    value: true,
  },
  display_pressure: {
    title: 'Afficher la pression',
    description: 'Affichez la pression atmosphérique dans les prévisions météorologiques.',
    value: true,
  },
  display_forecast: {
    title: 'Afficher les prévisions',
    description: 'Affichez les prévisions météorologiques pour les prochains jours.',
    value: true,
  },
};

export default PREFERENCES;
