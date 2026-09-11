<ul class="flex items-center space-x-1 text-sm font-medium text-gray-700 ml-auto justify-end">
  
  <!-- Eventi (Dropdown 1° livello) -->
  <li 
    class="relative" 
    x-data="{ open: false }" 
    @mouseenter="open = true" 
    @mouseleave="open = false"
    @click.outside="open = false"
  >
    <button 
      type="button" 
      @click="open = !open"
      class="inline-flex items-center px-3 py-2 rounded-md hover:bg-gray-100 hover:text-gray-900 focus:outline-none transition-colors"
    >
      Eventi
      <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
      </svg>
    </button>

    <!-- Sub-menu Eventi (2° livello) -->
    <div 
      x-show="open" 
      x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="absolute left-0 top-full w-64 pt-1 z-50"
      style="display: none;"
    >
      <ul class="bg-white border border-gray-100 rounded-md shadow-lg py-1">
        <li><a href="https://www.raggomitolando.com/lezioni-individuali/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Lezioni individuali</a></li>
        <li><a href="https://www.raggomitolando.com/settembre-2026-corsi-di-maglia-uncinetto-workshop-e-molto-altro/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Settembre 2026</a></li>
        <li><a href="https://www.raggomitolando.com/giugno-2026-corsi-di-maglia-uncinetto-workshop-e-molto-altro/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Giugno 2026</a></li>
        <li><a href="https://www.raggomitolando.com/maggio-2026-corsi-di-maglia-uncinetto-workshop-e-molto-altro/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Maggio 2026</a></li>
        <li><a href="https://www.raggomitolando.com/aprile-2026-corsi-di-maglia-uncinetto-workshop-e-molto-altro/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Aprile 2026</a></li>
        <li><a href="https://www.raggomitolando.com/eventi-marzo-2025-2/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Marzo 2026</a></li>
        <li><a href="https://www.raggomitolando.com/febbraio-2026-corsi-di-magliauncinetto-e-molto-altro/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Febbraio 2026</a></li>
        <li><a href="https://www.raggomitolando.com/gennaio-2026-corsi-di-magliauncinetto-e-molto-altro/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Gennaio 2026</a></li>
    </ul> 

  <!-- Il nostro progetto -->
  <li 
    class="relative" 
    x-data="{ open: false }" 
    @mouseenter="open = true" 
    @mouseleave="open = false"
    @click.outside="open = false"
  >
    <a 
      href="https://www.raggomitolando.com/il-nostro-progetto/" 
      class="inline-flex items-center px-3 py-2 rounded-md font-semibold text-gray-900 bg-gray-100 transition-colors"
    >
      Il nostro progetto
      <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
      </svg>
    </a>
    <div 
      x-show="open" 
      x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95"
      class="absolute left-0 top-full w-56 pt-1 z-50"
      style="display: none;"
    >
      <ul class="bg-white border border-gray-100 rounded-md shadow-lg py-1">
        <li><a href="https://www.raggomitolando.com/ritrovarci-tra-i-fili-2/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Ritrovarci tra i fili</a></li>
        <li><a href="https://www.raggomitolando.com/la-nostra-filosofia/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">la nostra FILOsofia</a></li>
        <li><a href="https://www.raggomitolando.com/chi-siamo/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Chi siamo</a></li>
        <li><a href="https://www.raggomitolando.com/la-nostra-storia/" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">la nostra storia</a></li>
        <li><a href="https://game.raggomitolando.com" target="_blank" rel="noopener noreferrer" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900">Game</a></li>
      </ul>
    </div>
  </li>

  <!-- I miei dati -->
  <li>
    <a href="https://www.raggomitolando.com/my-account/" class="block px-3 py-2 rounded-md hover:bg-gray-100 hover:text-gray-900 transition-colors">
      I miei dati
    </a>
  </li>

  <!-- Logout -->
  <li>
    <a href="https://www.raggomitolando.com/my-login-raggo22_to/?action=logout&amp;redirect_to=https%3A%2F%2Fwww.raggomitolando.com%2Fil-nostro-progetto%2F&amp;_wpnonce=5d752ca3de" class="block px-3 py-2 rounded-md text-red-600 hover:bg-red-50 transition-colors">
      Logout
    </a>
  </li>

</ul>