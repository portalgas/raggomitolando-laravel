/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/lunarphp/stripe-payments/resources/views/**/*.blade.php',

       './node_modules/flowbite'
    ],
    // Aggiungi la safelist per le classi grid-cols
    safelist: [
        {
           pattern: /^grid-cols-[1-9]|1[0-2]$/,
        }
    ],    
    theme: {
        extend: {                    
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
    ],
};