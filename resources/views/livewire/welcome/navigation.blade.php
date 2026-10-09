<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; 

?>

<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a href="#" id="topMenuProfilo" data-dropdown-toggle="multi-dropdown-profile" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100 hover:text-gray-900 transition-colors">
            {{ auth()->user()->name }}
            <svg class="w-4 h-4 ms-1.5 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
        </a>    
        <!-- Dropdown menu -->
        <div id="multi-dropdown-profile" class="z-[100] hidden bg-white border border-default-medium rounded-base shadow-lg w-44">
            <ul class="p-2 text-sm text-body font-medium" aria-labelledby="topMenuProfilo">
            <li><a href="{{ route('profile') }}" wire:navigate class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">{{ __('Profile') }}</a></li>
            <li><a href="#" wire:click="logout" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">{{ __('Log Out') }}</a></li>
            </ul>
        </div>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Register
            </a>
        @endif
    @endauth
</nav>
