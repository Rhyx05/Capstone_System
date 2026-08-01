<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrator Portal</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100 overflow-x-hidden">

    <x-admin.sidebar />

    <div class="ml-64 min-h-screen flex flex-col">

        <x-admin.navbar />

        <main class="flex-1 p-8">

            {{ $slot }}

        </main>

    </div>

</body>

</html>