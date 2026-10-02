<header class="relative border-b border-gray-100">
    <div class="flex items-center justify-between h-16 px-4 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a class="flex items-center flex-shrink-0"
               href="{{ url('/') }}"
               wire:navigate
            >
                <span class="sr-only">Home</span>

                <x-brand.logo class="w-auto h-6 text-indigo-600" />
            </a>

            <nav class="hidden lg:gap-4 lg:flex lg:ml-8">

            <div class="flex space-x-8 h-16 items-center">
            @foreach($this->collections as $rootCollection)
                @php
                    $hasChildren = $rootCollection->children->isNotEmpty();
                    $rootUrl = $rootCollection->urls->first()?->slug ?? '#';
                @endphp

                <!-- 1. FONDAMENTALE: 'group' e 'relative' sulla voce principale -->
                <div class="relative group h-full flex items-center">
                    
                    <a href="{{ url($rootUrl) }}" 
                       class="text-gray-800 group-hover:text-pink-600 font-semibold tracking-wide text-sm uppercase flex items-center py-5 transition-colors">
                        {{ $rootCollection->attr('name') }}

                        @if($hasChildren)
                            <svg class="w-4 h-4 ml-1 text-gray-400 group-hover:text-pink-600 transition-transform group-hover:rotate-180" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        @endif
                    </a>

                    <!-- 2. DROPDOWN MEGA MENU -->
                    @if($hasChildren)
                        <!-- top-full attacca il pannello subito sotto la barra senza buchi -->
                        <div class="absolute left-0 top-full hidden group-hover:block w-[700px] bg-white shadow-2xl border border-gray-100 rounded-b-lg p-6 z-50">
                            
                            <div class="grid grid-cols-3 gap-6">
                                @foreach($rootCollection->children as $subCategory)
                                    @php
                                        $subUrl = $subCategory->urls->first()?->slug ?? '#';
                                    @endphp
                                    
                                    <div class="space-y-2">
                                        <!-- Titolo colonna -->
                                        <a href="{{ url($subUrl) }}" class="font-bold text-gray-900 hover:text-pink-600 text-sm block border-b border-gray-100 pb-2">
                                            {{ $subCategory->attr('name') }}
                                        </a>

                                        <!-- Voci sottostanti -->
                                        @if($subCategory->children->isNotEmpty())
                                            <ul class="space-y-1 pt-1">
                                                @foreach($subCategory->children as $child)
                                                    @php
                                                        $childUrl = $child->urls->first()?->slug ?? '#';
                                                    @endphp
                                                    <li>
                                                        <a href="{{ url($childUrl) }}" class="text-gray-600 hover:text-pink-600 text-sm transition-colors block py-0.5">
                                                            {{ $child->attr('name') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif

                </div>
            @endforeach
            </        

            </nav>
        </div>

        <div class="flex items-center justify-between flex-1 ml-4 lg:justify-end">
            <x-header.search class="max-w-sm mr-4" />

            <div class="flex items-center -mr-4 sm:-mr-6 lg:mr-0">
                @livewire('components.cart')

                <div x-data="{ mobileMenu: false }">
                    <button x-on:click="mobileMenu = !mobileMenu"
                            class="grid flex-shrink-0 w-16 h-16 border-l border-gray-100 lg:hidden">
                        <span class="sr-only">Toggle Menu</span>

                        <span class="place-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </span>
                    </button>

                    <div x-cloak
                         x-transition
                         x-show="mobileMenu"
                         class="absolute right-0 top-auto z-50 w-screen p-4 sm:max-w-xs">
                        <ul x-on:click.away="mobileMenu = false"
                            class="p-6 space-y-4 bg-white border border-gray-100 shadow-xl rounded-xl">
                            @foreach ($this->collections as $collection)
                                <li>
                                    <a class="text-sm font-medium"
                                       href="{{ route('collection.view', $collection->defaultUrl->slug) }}"
                                       wire:navigate
                                    >
                                        {{ $collection->translateAttribute('name') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>