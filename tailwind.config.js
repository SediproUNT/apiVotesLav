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
                primary: {
                    DEFAULT: '#0f172a',
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
