import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Permette a Docker di ascoltare dall'esterno
        // hosts: 'raggomitolando.local',
        port: 5173,
        strictPort: true,
        cors: true,
        hmr: {
            host: 'raggomitolando.local', // L'host che il tuo browser usa per contattare Vite
            port: 5173,                 // La porta a cui si connette il browser
           // protocol: 'ws',             // Usa 'wss' solo se stai usando HTTPS
        },
        watch: {
            usePolling: true, // Necessario se i cambi ai file Blade/JS non aggiornano automaticamente il browser
        },
    },  
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // refresh: [`resources/views/**/*`],
        }),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcss(),
                autoprefixer(),
            ],
        },
    },    
});