/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        // WhatsApp Color Palette - Pixel Perfect
        'wa': {
          'green': '#25D366',
          'dark-green': '#075E54',
          'light-bg': '#ECE5DD',
          'dark-bg': '#0A0E27',
          'text-dark': '#111B21',
          'text-light': '#667781',
          'border': '#E9EDEF',
          'border-dark': '#2A2F32',
          'bubble-in': '#E7FFDE',
          'bubble-out': '#DCF8C6',
          'sidebar': '#FFFFFF',
          'sidebar-dark': '#111B21',
          'hover': '#F0F0F0',
          'hover-dark': '#1F2937',
          'msg-bg': '#ECE5DD',
          'msg-bg-dark': '#0A0E27',
        },
      },
      fontFamily: {
        'sans': ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
      },
      fontSize: {
        'xs': ['12px', { lineHeight: '16px' }],
        'sm': ['13px', { lineHeight: '19px' }],
        'base': ['15px', { lineHeight: '20px' }],
        'lg': ['17px', { lineHeight: '22px' }],
        'xl': ['20px', { lineHeight: '24px' }],
      },
      spacing: {
        '72': '18rem',
        '80': '20rem',
        '88': '22rem',
        '96': '24rem',
      },
      width: {
        'sidebar': '72px',
        'sidebar-expanded': '360px',
      },
      maxWidth: {
        'msg': '55%',
      },
      borderRadius: {
        'xl': '12px',
        '2xl': '16px',
        '3xl': '20px',
      },
      boxShadow: {
        'wa': '0 1px 2px rgba(0, 0, 0, 0.1)',
        'wa-md': '0 2px 8px rgba(0, 0, 0, 0.15)',
        'wa-lg': '0 8px 24px rgba(0, 0, 0, 0.12)',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'slide-out': 'slideOut 0.3s ease-out',
        'pulse-dot': 'pulseDot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'bounce-msg': 'bounceMsg 0.5s ease-out',
        'expand': 'expand 0.3s ease-out',
        'collapse': 'collapse 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideIn: {
          '0%': { transform: 'translateX(-10px)', opacity: '0' },
          '100%': { transform: 'translateX(0)', opacity: '1' },
        },
        slideOut: {
          '0%': { transform: 'translateX(0)', opacity: '1' },
          '100%': { transform: 'translateX(-10px)', opacity: '0' },
        },
        pulseDot: {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.5' },
        },
        bounceMsg: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        expand: {
          '0%': { width: '72px' },
          '100%': { width: '360px' },
        },
        collapse: {
          '0%': { width: '360px' },
          '100%': { width: '72px' },
        },
      },
      transitionDuration: {
        '250': '250ms',
        '350': '350ms',
      },
    },
  },
  plugins: [require('@tailwindcss/forms')],
};
