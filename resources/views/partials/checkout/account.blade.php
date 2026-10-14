<!-- Banner in evidenza per utenti non loggati -->
@guest
    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3" 
         x-data="{ showLoginModal: false }">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-sm text-gray-700 font-medium">
                Sei già un cliente?
            </span>
        </div>
        <button @click="showLoginModal = true" 
                type="button" 
                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 underline focus:outline-none">
            Fai clic qui per accedere
        </button>

        <!-- Modale di Login -->
        <div x-show="showLoginModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" 
             style="display: none;"
             x-cloak>
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 relative" 
                 @click.away="showLoginModal = false">
                
                <!-- Pulsante chiusura (X) -->
                <button @click="showLoginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <h3 class="text-xl font-bold text-gray-900 mb-4">Accedi al tuo account</h3>

                <!-- Form di Login gestito da Livewire -->
                <form wire:submit.prevent="loginAtCheckout">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email5" wire:model="loginEmail" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5" 
                               required>
                        @error('loginEmail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" wire:model="loginPassword" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5" 
                               required>
                        @error('loginPassword') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="showLoginModal = false" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200">
                            Annulla
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 shadow-sm">
                            Accedi e compila i dati
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endguest