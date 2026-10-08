<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Demo Storefront</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta
        name="description"
        content="Example of an ecommerce storefront built with Lunar."
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
