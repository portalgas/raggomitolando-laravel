<!-- definito in config/livewire.php 'layout' => 'layouts.storefront' -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Raggomitolando</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap" rel="stylesheet">   
    <!-- @import url('https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two&display=swap'); --> 
    <style>
        .color-primary {
            color: #549d51;
        }
    </style>
</head>

<body class="antialiased text-gray-900">

    @livewire('components.menu-top')
    @livewire('components.navigation')
   
    <main>
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script> <!-- fractis -->

</body>

</html>
