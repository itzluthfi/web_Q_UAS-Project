<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App Title')</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Vite integration for CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <!-- Push styles from individual views -->
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-anime-dark-900 to-black text-gray-100">
    
    <!-- Navbar component -->
    @include('components.navbar')

    <main class="flex-grow container mx-auto px-4 py-6">
        <!-- Content of each page will go here -->
        @yield('content')
    </main>

    <!-- Footer component -->
    @include('components.footer')

    <!-- Push scripts from individual views -->
    @stack('scripts')
</body>
</html>
