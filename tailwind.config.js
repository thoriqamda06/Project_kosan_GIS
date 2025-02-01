/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",        // Semua file PHP di root
    "./**/*.php"   // Semua file PHP di subfolder
  ],
  theme: {
    extend: {
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
        montserrat: ['Montserrat', 'sans-serif'],
        roboto: ['Roboto', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
