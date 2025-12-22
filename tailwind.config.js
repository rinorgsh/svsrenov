import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'svs': {
                    'red': '#A0402C',
                    'black': '#1A1A1A',
                    'white': '#FFFFFF',
                    'gray-light': '#F5F5F5',
                },
                'primary': '#A0402C',
                'secondary': '#1A1A1A',
            },
        },
    },

    plugins: [forms],
};
