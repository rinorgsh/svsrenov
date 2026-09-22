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
                display: ['Manrope', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'svs': {
                    'red': '#B91C1C',
                    'black': '#1A1A1A',
                    'white': '#FFFFFF',
                    'gray-light': '#F5F5F5',
                },
                'primary': '#B91C1C',
                // Couleurs sémantiques : leur valeur dépend du thème de la section (.theme-light / .theme-dark)
                'surface': {
                    DEFAULT: 'rgb(var(--surface) / <alpha-value>)',
                    2: 'rgb(var(--surface-2) / <alpha-value>)',
                    3: 'rgb(var(--surface-3) / <alpha-value>)',
                },
                'fg': {
                    DEFAULT: 'rgb(var(--fg) / <alpha-value>)',
                    muted: 'rgb(var(--fg-muted) / <alpha-value>)',
                    soft: 'rgb(var(--fg-soft) / <alpha-value>)',
                },
                'line': 'rgb(var(--line) / <alpha-value>)',
                'accent': 'rgb(var(--accent) / <alpha-value>)',
                'secondary': '#1A1A1A',
            },
        },
    },

    plugins: [forms],
};
