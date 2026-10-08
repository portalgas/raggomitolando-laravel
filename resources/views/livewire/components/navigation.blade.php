<nav class="bg-neutral-primary-soft border-default">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap text-heading">Flowbite</span>
        </a>
        <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-lg md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-default" aria-controls="mega-menu-full" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
        </button>
        <div id="mega-menu-full" class="items-center justify-between hidden-fractis w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col-fractis mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
                @foreach($this->collections as $rootCollection)
                    @php
                        $hasChildren = $rootCollection->children->isNotEmpty();
                    @endphp  
                    @if($hasChildren>0)
                        <li>
                            <button id="mega-menu-full-dropdown-button-{{ $rootCollection->id }}" data-collapse-toggle="mega-menu-full-dropdown-{{ $rootCollection->id }}" class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                                {{ $rootCollection->attr('name') }}
                                <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                            </button>
                        </li>                    
                    @else
                        <li>
                            <a href="{{ route('collection.view', $rootCollection->defaultUrl->slug) }}" class="block py-2 px-3 text-heading hover:text-fg-brand border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0" aria-current="page">{{ $rootCollection->attr('name') }}</a>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>

    @foreach($this->collections as $rootCollection)
        @php
            $hasChildren = $rootCollection->children->isNotEmpty();
            $rootUrl = $rootCollection->urls->first()?->slug ?? '#';
        @endphp  
        @if($hasChildren>0)    
            <div id="mega-menu-full-dropdown-{{ $rootCollection->id }}" class="hidden mt-1 bg-neutral-primary-soft border-default shadow-xs border-y">
                <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-heading grid-cols-{{ $rootCollection->children->count() }} md:px-6">
                    @foreach($rootCollection->children as $subCollection)
                        @if ($loop->first)
                            <ul aria-labelledby="mega-menu-full-dropdown-button-{{ $rootCollection->id }}">
                        @else
                            <ul>
                        @endif                        
                            <li>
                                <a href="{{ route('collection.view', $subCollection->defaultUrl->slug) }}" class="block p-3 rounded-lg hover:bg-neutral-secondary-medium underline">
                                    <div class="font-semibold">{{ $subCollection->attr('name') }}</div>
                                    <span class="text-sm text-body">{{ $subCollection->attr('description') }}</span>
                                </a>
                            </li>
                            @foreach($subCollection->children as $subSubCollection)
                                <li>
                                    <a href="{{ route('collection.view', $subSubCollection->defaultUrl->slug) }}" class="block p-3 rounded-lg hover:bg-neutral-secondary-medium">
                                        <div class="font-semibold">{{ $subSubCollection->attr('name') }}</div>
                                        <span class="text-sm text-body">{{ $subSubCollection->attr('description') }}</span>
                                    </a>
                                </li>
                            @endforeach                                                          
                        </ul>
                    @endforeach


                </div>
            </div>
        @endif
    @endforeach
</nav>
