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
            backgroundImage: {
                'gradient-emerald': 'linear-gradient(135deg, #15803d 0%, #22c55e 50%, #4ade80 100%)',
                'gradient-emerald-dark': 'linear-gradient(135deg, #052e16 0%, #14532d 50%, #166534 100%)',
                'gradient-fresh': 'linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)',
                'gradient-hero': 'linear-gradient(135deg, #052e16 0%, #14532d 40%, #15803d 100%)',
                'gradient-harvest': 'linear-gradient(135deg, #22c55e 0%, #f59e0b 100%)',
                'gradient-petani': 'linear-gradient(135deg, #14532d 0%, #22c55e 100%)',
                'gradient-pembeli': 'linear-gradient(135deg, #134e4a 0%, #14b8a6 100%)',
                'mesh-emerald': 'radial-gradient(at 20% 50%, rgba(34,197,94,0.3) 0px, transparent 50%), radial-gradient(at 80% 20%, rgba(21,128,61,0.2) 0px, transparent 50%), radial-gradient(at 60% 80%, rgba(245,158,11,0.1) 0px, transparent 50%)',
            },
            fontFamily: {
                heading: ['"Instrument Sans"', 'Inter', 'sans-serif'],
                body: ['Inter', 'sans-serif'],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                primary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                },
                emerald: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                },
                water: {
                    400: '#5eead4',
                    500: '#2dd4bf',
                    600: '#14b8a6',
                },
                leaf: {
                    400: '#bef264',
                    500: '#a3e635',
                    600: '#84cc16',
                },
                success: '#22c55e',
                warning: '#d97706',
                danger: '#dc2626',
                info: '#2563eb',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'soft-md': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 30px -5px rgba(0, 0, 0, 0.04)',
                'soft-lg': '0 10px 40px -10px rgba(0, 0, 0, 0.15), 0 25px 50px -12px rgba(0, 0, 0, 0.05)',
                'elegant': '0 4px 24px rgba(0,0,0,0.04), 0 1px 4px rgba(0,0,0,0.02)',
                'elevation': '0 2px 16px rgba(0,0,0,0.06)',
                'card': '0 1px 3px rgba(0,0,0,0.05), 0 4px 12px rgba(0,0,0,0.04)',
                'card-hover': '0 8px 30px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.06)',
                'glow-em': '0 0 25px rgba(34,197,94,0.35)',
                'glow-em-lg': '0 0 50px rgba(34,197,94,0.25)',
                'glow-green': '0 0 20px rgba(34,197,94,0.35)',
                'glow-teal': '0 0 20px rgba(20,184,166,0.35)',
                'inner-glow': 'inset 0 1px 0 rgba(255,255,255,0.15)',
            },
            borderRadius: {
                '4xl': '2rem',
            },
            animation: {
                'gradient-x': 'gradient-x 8s ease infinite',
                'float': 'float 6s ease-in-out infinite',
                'pulse-soft': 'pulse-soft 2s ease-in-out infinite',
                'bounce-soft': 'bounce-soft 0.4s ease',
                'shimmer-sweep': 'shimmer-sweep 1.5s ease-in-out infinite',
                'fade-up': 'fadeUp 0.5s ease-out both',
                'fade-in': 'fadeIn 0.4s ease-out both',
                'scale-in': 'scaleIn 0.4s ease-out both',
                'slide-right': 'slideRight 0.4s ease-out both',
                'shimmer': 'shimmer 1.5s linear infinite',
                'float-slow': 'float 5s ease-in-out infinite',
                'spin-slow': 'spin 8s linear infinite',
                'pulse-glow': 'pulseGlow 2.5s ease-in-out infinite',
            },
            keyframes: {
                'gradient-x': {
                    '0%, 100%': { backgroundPosition: '0% 50%' },
                    '50%': { backgroundPosition: '100% 50%' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0) translateX(0) scale(1)', opacity: '0.6' },
                    '25%': { transform: 'translateY(-20px) translateX(10px) scale(1.05)', opacity: '0.8' },
                    '50%': { transform: 'translateY(-10px) translateX(-5px) scale(0.95)', opacity: '0.5' },
                    '75%': { transform: 'translateY(-30px) translateX(8px) scale(1.02)', opacity: '0.7' },
                },
                'pulse-soft': {
                    '0%, 100%': { transform: 'scale(1)', opacity: '1' },
                    '50%': { transform: 'scale(1.12)', opacity: '0.85' },
                },
                'bounce-soft': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-4px)' },
                },
                'shimmer-sweep': {
                    '0%': { backgroundPosition: '200% 0' },
                    '100%': { backgroundPosition: '-200% 0' },
                },
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.9)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                slideRight: {
                    '0%': { opacity: '0', transform: 'translateX(-20px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                pulseGlow: {
                    '0%, 100%': { boxShadow: '0 0 0 0 rgba(16,185,129,0)' },
                    '50%': { boxShadow: '0 0 30px 8px rgba(16,185,129,0.2)' },
                },
                gradientX: {
                    '0%, 100%': { backgroundSize: '200% 200%', backgroundPosition: 'left center' },
                    '50%': { backgroundSize: '200% 200%', backgroundPosition: 'right center' },
                },
            },
        },
    },

    plugins: [forms],
};
