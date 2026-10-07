// Importa Flowbite e la funzione di inizializzazione
import 'flowbite';
import { initFlowbite } from 'flowbite';

// Re-inizializzazione automatica per navigazione Livewire 3
document.addEventListener('livewire:navigated', () => {
    initFlowbite();
});

// Se utilizzi re-render dinamici senza cambio URL
document.addEventListener('livewire:initialized', () => {
    Livewire.hook('morph.updated', () => {
        initFlowbite();
    });
});
