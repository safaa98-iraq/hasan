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
            colors: {
                night: 'var(--lapis-deep, #061b2a)',
                deep: 'var(--lapis, #063e61)',
                'deep-soft': 'var(--river, #2a7188)',
                sand: 'var(--sand, #e8d1a4)',
                'sand-muted': 'var(--paper, #f4efe5)',
                accent: 'var(--sun, #efb657)',
                'accent-soft': 'var(--sand, #e8d1a4)',
                bronze: 'var(--river, #2a7188)',
            },
            fontFamily: {
                display: ['Newsreader', '"Noto Naskh Arabic"', 'Georgia', 'serif'],
                sans: ['"DM Sans"', '"Noto Kufi Arabic"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
