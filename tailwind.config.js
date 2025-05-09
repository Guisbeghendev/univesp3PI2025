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
                'verde': '#154f31',
                'cinza1': '#d8d4c7',
                'cinza2': '#868b8a',
                'dourado1': '#9b8950',
            },
            container: {
                center: true,
                padding: '2rem', // Ajuste o padding para o container
            },
            screens: {
                sm: '640px',  // Responsividade para telas pequenas
                md: '768px',  // Responsividade para tablets
                lg: '1024px', // Responsividade para telas médias
                xl: '1280px', // Responsividade para telas grandes
                '2xl': '1536px', // Responsividade para telas maiores
            },
            maxWidth: {
                'screen-xs': '100%',  // Largura 100% para tela extra pequena
                'screen-sm': '100%',  // Largura 100% para telas pequenas
                'screen-md': '100%',  // Largura 100% para telas médias
                'screen-lg': '100%',  // Largura 100% para telas grandes
                'screen-xl': '100%',  // Largura 100% para telas XL
                'screen-2xl': '100%', // Largura 100% para telas 2XL
            },
        },
    },

    plugins: [forms],
};
