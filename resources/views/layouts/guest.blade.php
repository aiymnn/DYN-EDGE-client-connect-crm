<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'ClientConnect CRM') }}</title>

    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Image -->
        <div class="hidden md:block md:w-1/2">
            <img src="https://i.pinimg.com/1200x/af/32/bc/af32bc373717ad42003e997e6591528a.jpg" alt="CRM Login Image"
                class="object-cover h-full w-full">
        </div>

        <!-- Form -->
        <div class="w-full md:w-1/2 p-8 sm:p-10 flex items-center justify-center">
            <div class="w-full max-w-md">
                <div class="flex justify-center mb-6">
                    <a href="/">
                        <x-application-logo class="w-16 h-16 text-indigo-600" />
                    </a>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
