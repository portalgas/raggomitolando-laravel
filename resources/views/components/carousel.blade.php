@php
    $imgs = [];
    $imgs[] = random_int(1, 150);
    $imgs[] = random_int(1, 150);
    $imgs[] = random_int(1, 150);
    $imgs[] = random_int(1, 150);
    $imgs[] = random_int(1, 150);
@endphp
<div id="ecommerce-carousel" class="relative w-full" data-carousel="slide">
    <!-- Carousel wrapper (Altezza personalizzabile: es. h-96 su mobile, h-[550px] su desktop) -->
    <div class="relative h-80 overflow-hidden w-full md:h-[500px]">
        
        @foreach ($imgs as $numResult => $img)
            <!-- Slide {{ $numResult +1 }} -->
            <div class="hidden duration-700 ease-in-out" @if($numResult==0) data-carousel-item="active" @else data-carousel-item @endif>
                <img src="https://picsum.photos/id/{{ $img }}/2500/1667" class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Offerta Primavera">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                    <div class="text-center text-white px-4">
                        <h2 class="text-3xl md:text-5xl font-bold mb-2">Nuova Collezione</h2>
                        <p class="text-lg md:text-xl mb-4">Scopri i nuovi arrivi nel catalogo</p>
                        <a href="#shop" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition">Acquista Ora</a>
                    </div>
                </div>
            </div>        
        @endforeach

    </div>

    <!-- Indicatori (Pallini in basso) -->
    <div class="absolute z-35 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        @foreach ($imgs as $numResult => $img)
            <button type="button" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white" aria-current="true" aria-label="Slide {{ $numResult +1 }}" data-carousel-slide-to="{{ $numResult }}"></button>      
        @endforeach
    </div>

    <!-- Controlli Slider (Frecce Avanti/Indietro) -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white text-white">
            <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Precedente</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white text-white">
            <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Successivo</span>
        </span>
    </button>
</div>