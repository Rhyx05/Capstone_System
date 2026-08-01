<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Document Tracking System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">

<div
class="relative min-h-screen overflow-hidden bg-gradient-to-br from-sky-900 via-blue-800 to-indigo-900">

    {{-- Decorative Background --}}
    <div class="absolute inset-0">

        <div class="absolute -top-40 -left-40 h-96 w-96 rounded-full bg-blue-500/20 blur-3xl"></div>

        <div class="absolute bottom-0 right-0 h-[500px] w-[500px] rounded-full bg-cyan-400/10 blur-3xl"></div>

        <div class="absolute top-1/2 left-1/2 h-[450px] w-[450px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/5 blur-3xl"></div>

    </div>

    {{-- Main --}}
    <div class="relative z-10 flex min-h-screen items-center justify-center px-6 py-10">

        <div class="grid w-full max-w-6xl grid-cols-1 gap-10 lg:grid-cols-2">

            {{-- Left Side --}}
            <div class="hidden lg:flex flex-col justify-center text-white">

                <div class="flex items-center gap-5">

<img
    src="{{ asset('images/sta-logo.jpg') }}"
    alt="Municipality Logo"
    class="h-24 w-24 rounded-full object-cover shadow-xl">

                    <div>

                        <h1 class="text-4xl font-bold">

                            Municipality of Sta. Cruz

                        </h1>

                        <p class="mt-2 text-lg text-blue-100">

                            Province of Davao del Sur

                        </p>

                    </div>

                </div>

                <div class="mt-10 max-w-lg">

                    <h2 class="text-3xl font-bold leading-tight">

                        Document Tracking and Electronic Filing System

                    </h2>

                    <p class="mt-5 text-lg leading-8 text-blue-100">

                        A centralized platform for secure document submission,
                        routing, approval, monitoring, and electronic filing.

                    </p>

                </div>

            </div>

            {{-- Login Card --}}
            <div class="flex items-center justify-center">

                <div
                    class="relative w-full max-w-md overflow-hidden rounded-3xl border border-white/30 bg-white/90 shadow-2xl backdrop-blur-xl">

                    {{-- Watermark Logo --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">

                        <img
                            src="{{ asset('images/sta-logo.png') }}"
                            class="w-80 opacity-[0.07] blur-[2px]">

                    </div>

                    {{-- Card Content --}}
                    <div class="relative z-10 p-8">

                        {{-- Mobile Logo --}}
                        <div class="mb-8 text-center lg:hidden">

                            <img
                                src="{{ asset('images/sta-logo.png') }}"
                                class="mx-auto h-20 w-20 rounded-full shadow-lg">

                            <h2 class="mt-4 text-2xl font-bold text-gray-800">

                                Municipality of Sta. Cruz

                            </h2>

                            <p class="text-sm text-gray-500">

                                Document Tracking System

                            </p>

                        </div>

                        {{ $slot }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>