<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Raggomitolando</title>
    <meta
        name="description"
        content="cerchi lana? Raggomitolando è un negozio a Torino in cui troverai filati delle migliori marche a prezzi accessibili, gomitoli, accessori per lavori a maglia, all’uncinetto e al punto croce. Negozio online rivenditore drop design"
    >
    <link
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >
    <link
        rel="icon"
        href="{{ asset('favicon.svg') }}"
    >
    @livewireStyles
    @stripeScripts
</head>

<body class="antialiased text-gray-900">
    <header class="relative border-b border-gray-100">
        <div class="flex items-center h-16 px-4 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
            <a
                class="flex items-center flex-shrink-0"
                href="{{ url('/') }}"
            >
                <span class="sr-only">Home</span>

                <x-brand.logo class="w-auto h-6 text-indigo-600" />
            </a>
        </div>
    </header>


    <main>
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>
