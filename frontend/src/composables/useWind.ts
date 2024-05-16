import usePreference from './usePreference';

export default () => {
  const getPreference = usePreference();

  const getSpeedInMetersPerSecond = (speed: number) => {
    return speed.toFixed(2) + ' m/s';
  };

  const getSpeedInKilometersPerHour = (speed: number) => {
    return (speed * 3.6).toFixed(2) + ' km/h';
  };

  const getSpeedInMilesPerHour = (speed: number) => {
    return (speed * 2.23694).toFixed() + ' mph';
  };

  const getWindSpeed = (speed: number) => {
    const preference = getPreference('wind_speed_unit');
    switch (preference?.pvalue) {
      case 'mps':
        return getSpeedInMetersPerSecond(speed);
      case 'kmph':
        return getSpeedInKilometersPerHour(speed);
      case 'mph':
        return getSpeedInMilesPerHour(speed);
      default:
        return getSpeedInMetersPerSecond(speed);
    }
  };

  const getWindDirection = (degree: number) => {
    if (degree >= 337.5 || degree < 22.5) {
      return 'N';
    } else if (degree >= 22.5 && degree < 67.5) {
      return 'NE';
    } else if (degree >= 67.5 && degree < 112.5) {
      return 'E';
    } else if (degree >= 112.5 && degree < 157.5) {
      return 'SE';
    } else if (degree >= 157.5 && degree < 202.5) {
      return 'S';
    } else if (degree >= 202.5 && degree < 247.5) {
      return 'SW';
    } else if (degree >= 247.5 && degree < 292.5) {
      return 'W';
    } else if (degree >= 292.5 && degree < 337.5) {
      return 'NW';
    }
  };

  return { getWindSpeed, getWindDirection };
};
