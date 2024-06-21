/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.{js,mjs,jsx,ts,tsx,vue,blade.php}",
        "/public/scripts/**/*.mjs"
      ],
  theme: {
    extend: {
        borderRadius: {
            'fmt-default-radius': '7px'
        },
        colors: {
            'fmt-blue-1': '#19BBE1',
            'fmt-blue-1-600': '#0E6D84',
            'fmt-blue-1-800': '#094755',
            'fmt-blue-1-900': '#052A33',
            'fmt-blue-1-1000': '#021216',
            'fmt-blue-2': '#BEF3FF',
            'fmt-blue-3': '#DBF8FF',

            'fmt-orange-1': '#E58904',
            'fmt-orange-1-400': '#B56C03',
            'fmt-orange-1-600': '#714301',
            'fmt-orange-1-800': '#482B00',
            'fmt-orange-2': '#FFD69A',
            'fmt-orange-2-600': '#65553D',
            'fmt-orange-3': '#FFEED6',

            'fmt-purple-1': '#8D02D6',
            'fmt-purple-1-button': '#570085',
            'fmt-purple-1-hover': '#570085',
            'fmt-purple-1-600': '#48006E',
            'fmt-purple-1-800': '#29003F',
            'fmt-purple-1-900': '#12001C',
            'fmt-purple-2': '#D4B9FF',
            'fmt-purple-3': '#E7D9FF',

            'fmt-red-1': '#FB2220',
            'fmt-red-2': '#F1BDBD',
            'fmt-red-3': '#FFE2E2',
        },
    },
  },
  plugins: [],
}

