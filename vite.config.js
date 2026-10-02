import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0', // FONDAMENTALE per Docker
        port: 5173,
        strictPort: true,
        cors: true,
        hmr: {
            host: 'localhost', // L'host che il tuo browser usa per contattare Vite
        },
        watch: {
            usePolling: true, // Necessario se i cambi ai file Blade/JS non aggiornano automaticamente il browser
        },
    },  
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});