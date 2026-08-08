/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        barlow: ['"Barlow Semi Condensed"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
