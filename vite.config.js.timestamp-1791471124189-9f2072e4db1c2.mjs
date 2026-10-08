// vite.config.js
import { defineConfig } from "file:///var/www/public_html/raggomitolando/node_modules/vite/dist/node/index.js";
import laravel from "file:///var/www/public_html/raggomitolando/node_modules/laravel-vite-plugin/dist/index.mjs";
import tailwindcss from "file:///var/www/public_html/raggomitolando/node_modules/tailwindcss/lib/index.js";
import autoprefixer from "file:///var/www/public_html/raggomitolando/node_modules/autoprefixer/lib/autoprefixer.js";
var vite_config_default = defineConfig({
  server: {
    // host: '0.0.0.0', // Permette a Docker di ascoltare dall'esterno
    host: "raggomitolando.local",
    // Permette a Docker di ascoltare dall'esterno
    port: 5173,
    // La porta su cui gira Vite
    strictPort: true,
    cors: true,
    https: false,
    /*
    proxy: {
        '/api': {
          target: 'http://raggomitolando.local:100', // URL del server backend
          changeOrigin: true,             // Modifica l'header 'Host' per matchare il target
          secure: false,                  // Imposta a true se il backend usa HTTPS con certificato valido
          // Rimuove '/api' dall'URL prima di inviarlo al backend
          // rewrite: (path) => path.replace(/^\/api/, '')
        }
    },    
    hmr: {
        host: 'raggomitolando.local', // L'host che il tuo browser usa per contattare Vite
        port: 5173,                 // La porta a cui si connette il browser
       // protocol: 'ws',             // Usa 'wss' solo se stai usando HTTPS
    }, */
    watch: {
      usePolling: true
      // Necessario se i cambi ai file Blade/JS non aggiornano automaticamente il browser
    }
  },
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true
      // refresh: [`resources/views/**/*`],
    })
  ],
  css: {
    postcss: {
      plugins: [
        tailwindcss(),
        autoprefixer()
      ]
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvdmFyL3d3dy9wdWJsaWNfaHRtbC9yYWdnb21pdG9sYW5kb1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiL3Zhci93d3cvcHVibGljX2h0bWwvcmFnZ29taXRvbGFuZG8vdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL3Zhci93d3cvcHVibGljX2h0bWwvcmFnZ29taXRvbGFuZG8vdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHRhaWx3aW5kY3NzIGZyb20gJ3RhaWx3aW5kY3NzJztcbmltcG9ydCBhdXRvcHJlZml4ZXIgZnJvbSAnYXV0b3ByZWZpeGVyJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBzZXJ2ZXI6IHtcbiAgICAgICAvLyBob3N0OiAnMC4wLjAuMCcsIC8vIFBlcm1ldHRlIGEgRG9ja2VyIGRpIGFzY29sdGFyZSBkYWxsJ2VzdGVybm9cbiAgICAgICAgaG9zdDogJ3JhZ2dvbWl0b2xhbmRvLmxvY2FsJywgLy8gUGVybWV0dGUgYSBEb2NrZXIgZGkgYXNjb2x0YXJlIGRhbGwnZXN0ZXJub1xuICAgICAgICBwb3J0OiA1MTczLCAvLyBMYSBwb3J0YSBzdSBjdWkgZ2lyYSBWaXRlXG4gICAgICAgIHN0cmljdFBvcnQ6IHRydWUsXG4gICAgICAgIGNvcnM6IHRydWUsIFxuICAgICAgICBodHRwczogZmFsc2UsXG4gICAgICAgIC8qXG4gICAgICAgIHByb3h5OiB7XG4gICAgICAgICAgICAnL2FwaSc6IHtcbiAgICAgICAgICAgICAgdGFyZ2V0OiAnaHR0cDovL3JhZ2dvbWl0b2xhbmRvLmxvY2FsOjEwMCcsIC8vIFVSTCBkZWwgc2VydmVyIGJhY2tlbmRcbiAgICAgICAgICAgICAgY2hhbmdlT3JpZ2luOiB0cnVlLCAgICAgICAgICAgICAvLyBNb2RpZmljYSBsJ2hlYWRlciAnSG9zdCcgcGVyIG1hdGNoYXJlIGlsIHRhcmdldFxuICAgICAgICAgICAgICBzZWN1cmU6IGZhbHNlLCAgICAgICAgICAgICAgICAgIC8vIEltcG9zdGEgYSB0cnVlIHNlIGlsIGJhY2tlbmQgdXNhIEhUVFBTIGNvbiBjZXJ0aWZpY2F0byB2YWxpZG9cbiAgICAgICAgICAgICAgLy8gUmltdW92ZSAnL2FwaScgZGFsbCdVUkwgcHJpbWEgZGkgaW52aWFybG8gYWwgYmFja2VuZFxuICAgICAgICAgICAgICAvLyByZXdyaXRlOiAocGF0aCkgPT4gcGF0aC5yZXBsYWNlKC9eXFwvYXBpLywgJycpXG4gICAgICAgICAgICB9XG4gICAgICAgIH0sICAgIFxuICAgICAgICBobXI6IHtcbiAgICAgICAgICAgIGhvc3Q6ICdyYWdnb21pdG9sYW5kby5sb2NhbCcsIC8vIEwnaG9zdCBjaGUgaWwgdHVvIGJyb3dzZXIgdXNhIHBlciBjb250YXR0YXJlIFZpdGVcbiAgICAgICAgICAgIHBvcnQ6IDUxNzMsICAgICAgICAgICAgICAgICAvLyBMYSBwb3J0YSBhIGN1aSBzaSBjb25uZXR0ZSBpbCBicm93c2VyXG4gICAgICAgICAgIC8vIHByb3RvY29sOiAnd3MnLCAgICAgICAgICAgICAvLyBVc2EgJ3dzcycgc29sbyBzZSBzdGFpIHVzYW5kbyBIVFRQU1xuICAgICAgICB9LCAqLyBcbiAgICAgICAgd2F0Y2g6IHtcbiAgICAgICAgICAgIHVzZVBvbGxpbmc6IHRydWUsIC8vIE5lY2Vzc2FyaW8gc2UgaSBjYW1iaSBhaSBmaWxlIEJsYWRlL0pTIG5vbiBhZ2dpb3JuYW5vIGF1dG9tYXRpY2FtZW50ZSBpbCBicm93c2VyXG4gICAgICAgIH0sXG4gICAgfSwgIFxuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogWydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLCAncmVzb3VyY2VzL2pzL2FwcC5qcyddLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgICAgIC8vIHJlZnJlc2g6IFtgcmVzb3VyY2VzL3ZpZXdzLyoqLypgXSxcbiAgICAgICAgfSksXG4gICAgXSxcbiAgICBjc3M6IHtcbiAgICAgICAgcG9zdGNzczoge1xuICAgICAgICAgICAgcGx1Z2luczogW1xuICAgICAgICAgICAgICAgIHRhaWx3aW5kY3NzKCksXG4gICAgICAgICAgICAgICAgYXV0b3ByZWZpeGVyKCksXG4gICAgICAgICAgICBdLFxuICAgICAgICB9LFxuICAgIH0sICAgIFxufSk7Il0sCiAgIm1hcHBpbmdzIjogIjtBQUEyUixTQUFTLG9CQUFvQjtBQUN4VCxPQUFPLGFBQWE7QUFDcEIsT0FBTyxpQkFBaUI7QUFDeEIsT0FBTyxrQkFBa0I7QUFFekIsSUFBTyxzQkFBUSxhQUFhO0FBQUEsRUFDeEIsUUFBUTtBQUFBO0FBQUEsSUFFSixNQUFNO0FBQUE7QUFBQSxJQUNOLE1BQU07QUFBQTtBQUFBLElBQ04sWUFBWTtBQUFBLElBQ1osTUFBTTtBQUFBLElBQ04sT0FBTztBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBLElBZ0JQLE9BQU87QUFBQSxNQUNILFlBQVk7QUFBQTtBQUFBLElBQ2hCO0FBQUEsRUFDSjtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTyxDQUFDLHlCQUF5QixxQkFBcUI7QUFBQSxNQUN0RCxTQUFTO0FBQUE7QUFBQSxJQUViLENBQUM7QUFBQSxFQUNMO0FBQUEsRUFDQSxLQUFLO0FBQUEsSUFDRCxTQUFTO0FBQUEsTUFDTCxTQUFTO0FBQUEsUUFDTCxZQUFZO0FBQUEsUUFDWixhQUFhO0FBQUEsTUFDakI7QUFBQSxJQUNKO0FBQUEsRUFDSjtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
