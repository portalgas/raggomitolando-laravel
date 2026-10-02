/*
 * Definisce i percorsi dei template in content e le estensioni del tema
*/
import forms from '@tailwindcss/forms';
// import preline from 'preline/plugin';

// module.exports = {  package.json usa "type": "module"
export default {    
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/lunarphp/stripe-payments/resources/views/**/*.blade.php',
        './node_modules/preline/dist/*.js',
        './node_modules/@preline/dropdown/*.js',
    ],
    content: [],
    theme: {
        extend: {
            colors: {
                border: 'var(--border, #e5e7eb)',
            },
          }
    },
    plugins: [
        // require('@tailwindcss/forms'), require('preline/plugin')
        forms,
    ],
};

