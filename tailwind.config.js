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
            colors:{
                //https://www.canva.com/colors/color-palettes/foil-covered-sneakers/
                pewter: {
                    DEFAULT: "#e9eaec",
                    100: "#c2c0ef",
                },
                bluegray: {
                    DEFAULT: "#90adc6",
                },
                darkblue: {
                    DEFAULT: "#333652",
                },
                yellow: {
                    DEFAULT: "#fad02c",
                },
            },
        },
    },

    plugins: [forms],
};
