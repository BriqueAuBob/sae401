import useUserStore from '../stores/user';

export default () => {
  const userStore = useUserStore();

  const getKelvin = (temp: number) => {
    return (temp + 273.15).toFixed(2) + 'K';
  };

  const getFahrenheit = (temp: number) => {
    return ((temp * 9) / 5 + 32).toFixed(2) + '°F';
  };

  const getCelsius = (temp: number) => {
    return temp.toFixed(2) + '°C';
  };

  const getTemperature = (temp: number) => {
    const unit = userStore.findPreference('temp_unit');
    if (unit?.pvalue === 'kelvin') {
      return getKelvin(temp);
    } else if (unit?.pvalue === 'fahrenheit') {
      return getFahrenheit(temp);
    } else {
      return getCelsius(temp);
    }
  };

  return {
    getTemperature,
  };
};
