import defaultConfig from 'tailwindcss/defaultConfig';

/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx,vue}'],
  safelist: [
    {
      pattern: /bg-.*-(500|400)/,
      variants: ['hover'],
    },
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        sans: ['DM Sans', ...defaultConfig.theme.fontFamily.sans],
      },
      container: {
        center: true,
        padding: '1rem',
      },
      colors: {
        primary: {
          DEFAULT: '#3C84F1',
          50: '#F5F9FE',
          100: '#ECF3FE',
          200: '#CEE0FC',
          300: '#B1CEF9',
          400: '#77A9F5',
          500: '#3C84F1',
          600: '#3677D9',
          700: '#244F91',
          800: '#1B3B6C',
          900: '#122848',
        },
      },
    },
  },
  plugins: [],
};
