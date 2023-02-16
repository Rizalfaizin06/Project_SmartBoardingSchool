/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}", "./node_modules/flowbite/**/*.js"],
  theme: {
    extend: {
      fontFamily: {
        'poppins': ['Poppins']
        },
        colors: {
          primary: '#de7b06',
          secondary: '#e4eeff',
          separate: '#f9f9fb',
          dark: '#0f172a',
        }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
