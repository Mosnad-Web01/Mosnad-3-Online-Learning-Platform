<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="grid h-screen grid-rows-[auto_1fr_auto] grid-cols-[auto_1fr] lg:grid-cols-[250px_1fr]">
            <!-- Navbar and Sidebar -->
            <header class="row-start-1 row-end-2 col-span-2 bg-gray-100 dark:bg-gray-900 lg:col-span-1 lg:col-end-3 flex flex-col lg:flex-row">
                <x-navbar />
            </header>

            <!-- Main Content -->
            <main class="row-start-2 row-end-3 col-start-1 bg-white dark:bg-gray-900 text-gray-900 dark:text-white lg:col-start-2 col-end-3 overflow-y-auto p-4">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="row-start-3 row-end-4 col-span-2 bg-gray-200 dark:bg-gray-900">
                <x-footer />
            </footer>
        </div>
    </body>
</html>
