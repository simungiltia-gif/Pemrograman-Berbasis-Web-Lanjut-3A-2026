import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    DEFAULT: '#3B5183',
                    50: '#F0F3F9',
                    100: '#E1E7F3',
                    600: '#3B5183',
                    700: '#2F416A',
                    800: '#253456',
                    900: '#1B2640',
                },
                rust: {
                    DEFAULT: '#833514',
                    50: '#FDF6F0',
                    100: '#FAECE2',
                    500: '#9E3F17',
                    600: '#833514',
                    700: '#6B2B10',
                    800: '#52200C',
                },
                butter: {
                    DEFAULT: '#F5E283',
                    50: '#FEFCF3',
                    100: '#FDF9E7',
                    300: '#FAF0B3',
                    400: '#F5E283',
                    500: '#E6CF60',
                    600: '#C7B03E',
                },
            },
        },
    },

    plugins: [forms],
};
