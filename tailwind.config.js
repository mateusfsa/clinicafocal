import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    //presets: [require('@acmecorp/tailwind-base')],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'selector',
    theme: {
        extend: {
            colors: {
                primary: '#1a73e8',
                secondary: '#0d47a1',
                accent: '#4fc3f7',
                light: '#f8fdff',
                dark: '#263238',
                success: '#4caf50',
                warning: '#ff9800',
                danger: '#f44336',
            },
            fontFamily: {
                sans: ['Open Sans', 'sans-serif'],
                montserrat: ['Montserrat', 'sans-serif'],
            },
            boxShadow: {
                custom: '0 4px 12px rgba(0,0,0,0.08)',
                'custom-hover': '0 6px 15px rgba(0,0,0,0.1)',
                'card-hover': '0 10px 25px rgba(0,0,0,0.1)',
            },
        }
    },

    plugins: [forms],
};
