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
          DEFAULT: '#348efd',
          50: '#eef7ff',
          100: '#daedff',
          200: '#bde0ff',
          300: '#8fcdff',
          400: '#5bb0ff',
          500: '#348efd',
          600: '#1d6ff2',
          700: '#1659df',
          800: '#1948b4',
          900: '#1a408e',
          950: '#152956',
        },
      },
    },
  },
  plugins: [],
};
