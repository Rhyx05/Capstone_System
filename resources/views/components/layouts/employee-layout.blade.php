<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Portal</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-100 overflow-x-hidden">

    <x-employee.sidebar />

    <div class="ml-64 min-h-screen flex flex-col">

        <x-employee.navbar />

        <main class="flex-1 p-8">

            {{ $slot }}

        </main>

    </div>


</body>

</html>