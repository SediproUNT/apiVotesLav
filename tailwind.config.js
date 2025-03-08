import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Colores personalizados de SEDIPRO
                azulOscuro: '#292d66', // Azul oscuro
                azul: '#3154a2',      // Azul
                morado: '#672577',    // Morado
                
                // Variantes para cada color
                'azulOscuro-light': '#3c4080',
                'azulOscuro-dark': '#1d214d',
                'azul-light': '#4166b4',
                'azul-dark': '#264280',  
                'morado-light': '#7a3089',
                'morado-dark': '#541b65',
                
                // Mantener colores existentes
                primary: {
                    DEFAULT: '#292d66', // Ahora usa azul oscuro como primary
                    foreground: '#ffffff',
                },
                destructive: {
                    DEFAULT: '#ef4444',
                    foreground: '#ffffff',
                },
                muted: {
                    DEFAULT: '#f1f5f9',
                    foreground: '#64748b',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
