import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Permette a Docker di ascoltare dall'esterno
        port: 5173, // La porta su cui gira Vite
        strictPort: true,
        cors: true, 
        https: false,
        // Forzare l'origin che Laravel scriverà nel file public/hot e nell'HTML
        // origin: 'http://raggomitolando.local:5173',
        /*
        proxy: {
            '/api': {
              target: 'http://raggomitolando.local:100', // URL del server backend
              changeOrigin: true,             // Modifica l'header 'Host' per matchare il target
              secure: false,                  // Imposta a true se il backend usa HTTPS con certificato valido
              // Rimuove '/api' dall'URL prima di inviarlo al backend
              // rewrite: (path) => path.replace(/^\/api/, '')
            }
        },  */  
        hmr: {
            host: 'raggomitolando.local', // L'host che il tuo browser usa per contattare Vite
            port: 5173,                   // La porta a cui si connette il browser
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