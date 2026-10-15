/*
 impostata la porta 5173 sul container nginx
 nginx default.conf server {listen 5173; ...
*/
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {  
        host: '0.0.0.0',  // Permette l'accesso da qualsiasi host/IP sulla rete locale
        port: 5173,
        strictPort: true,        
        cors: true, 
        origin: 'http://raggomitolando.local:5173',        
        // Configura l'origine esatta per l'HMR (Hot Module Replacement)
        hmr: {
            host: 'raggomitolando.local', 
        },
    },    
});
