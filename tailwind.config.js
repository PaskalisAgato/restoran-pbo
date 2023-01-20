/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./component/**/*.{html,js,php}"],
  theme: {
    extend: {
      fontFamily: {
        alata:"'Alata', sans-serif",
        italiana:"'Italiana', serif",
      },
      colors: {
        'coklat': '#C5A880C2',
        'coklat2': '#C5A880',
        'coklat3': '#532E1C',
        'coklat4': '#FFEBB7',
        'putih': '#AD8E70',
       
      },
    },
  },
  plugins: [],
}
