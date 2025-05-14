/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        first: '#2bd1c3',
        title: 'hsl(228, 18%, 16%)',
        text: 'hsl(228, 8%, 56%)',
        body: 'hsl(228, 100%, 99%)',
        shadow: 'hsla(228, 80%, 4%, 0.1)',
      },
      boxShadow: {
        custom: '0 2px 24px hsla(228, 80%, 4%, 0.1)',
        sidebar: '2px 0 24px hsla(228, 80%, 4%, 0.1)',
      },
      fontFamily: {
        nunito: ['"Nunito Sans"', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        normal: '0.938rem', // mengganti default base
        smaller: '0.75rem',
        tiny: '0.75rem',
      },
      zIndex: {
        tooltip: '10',
        fixed: '100',
      },
      height: {
        header: '3.5rem',
      },
    },
  },
  plugins: [],
}