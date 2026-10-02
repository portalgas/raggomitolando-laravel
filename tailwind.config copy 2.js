import forms from '@tailwindcss/forms';
import preline from 'preline/plugin';

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/lunarphp/stripe-payments/resources/views/**/*.blade.php',
        './node_modules/preline/dist/*.js',
        './node_modules/@preline/dropdown/*.js',
    ],
    content: [],
    theme: {
        extend: {},
    },
    plugins: [forms, preline],
};

