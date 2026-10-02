import '../css/app.css'; // si potrà togliere
import 'preline';
import HSDropdown from "@preline/dropdown/non-auto";

// Helper per reinizializzare la libreria Preline sui nodi DOM aggiornati
const reinitPreline = () => {
    if (window.HSStaticMethods && typeof window.HSStaticMethods.autoInit === 'function') {
        window.HSStaticMethods.autoInit();
    }
};

// Primo caricamento della pagina
document.addEventListener('DOMContentLoaded', reinitPreline);

// Supporto per navigazione SPA (Livewire navigate)
document.addEventListener('livewire:navigated', reinitPreline);

// Supporto per re-render dei singoli componenti Livewire (es. filtri, carrello, menu)
document.addEventListener('livewire:init', () => {
    Livewire.hook('morph.updated', () => {
        reinitPreline();
    });
});



document.addEventListener("DOMContentLoaded", () => {
  HSDropdown.autoInit();
});