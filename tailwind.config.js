import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                hub: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#f97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                },
            },
            boxShadow: {
                glow: '0 0 32px -8px rgba(34, 211, 238, 0.45)',
                'glow-sm': '0 0 20px -6px rgba(34, 211, 238, 0.35)',
                'glow-orange': '0 0 32px -8px rgba(249, 115, 22, 0.55)',
                'glow-orange-sm': '0 0 20px -6px rgba(249, 115, 22, 0.40)',
                'glow-green': '0 0 24px -6px rgba(34, 197, 94, 0.45)',
                'glow-amber': '0 0 24px -6px rgba(251, 191, 36, 0.40)',
            },
            backgroundImage: {
                'neo-gradient':
                    'radial-gradient(ellipse 100% 70% at 50% -15%, rgba(34, 211, 238, 0.18), transparent), linear-gradient(180deg, #042f2e 0%, #0c1920 42%, #020617 100%)',
                'food-gradient':
                    'radial-gradient(ellipse 120% 80% at 60% -20%, rgba(249,115,22,0.22), transparent 60%), radial-gradient(ellipse 80% 60% at 0% 80%, rgba(251,146,60,0.10), transparent 50%), linear-gradient(165deg, #0d0f18 0%, #0a0c14 60%, #050608 100%)',
                'kitchen-gradient':
                    'linear-gradient(180deg, #050608 0%, #080a10 100%)',
            },
            animation: {
                'slide-in-right': 'slideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1)',
                'slide-in-up': 'slideInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1)',
                'fade-in': 'fadeIn 0.3s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'bounce-once': 'bounceOnce 0.5s ease-out',
                'ping-once': 'pingOnce 0.6s ease-out',
            },
            keyframes: {
                slideInRight: {
                    '0%': { transform: 'translateX(30px)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                slideInUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                bounceOnce: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-8px)' },
                },
                pingOnce: {
                    '0%': { transform: 'scale(1)', opacity: '1' },
                    '80%': { transform: 'scale(1.5)', opacity: '0' },
                    '100%': { transform: 'scale(1.5)', opacity: '0' },
                },
            },
        },
    },

    plugins: [forms],
};
