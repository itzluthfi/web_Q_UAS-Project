<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App Title')</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Vite integration for CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <!-- Styles for layout -->
    {{-- <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f1116;
        }

        .glow-effect {
            box-shadow: 0 0 15px rgba(101, 31, 255, 0.4);
        }

        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(101, 31, 255, 0.6);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(101, 31, 255, 0.5);
        }

        .input-dark {
            background-color: rgba(30, 32, 44, 0.8);
            border-color: #2e3346;
            color: #e2e8f0;
        }

        .input-dark::placeholder {
            color: #64748b;
        }

        .input-dark:focus {
            border-color: #651fff;
            box-shadow: 0 0 0 2px rgba(101, 31, 255, 0.2);
        }

        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1f2937;
        }

        ::-webkit-scrollbar-thumb {
            background: #4c1d95;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6d28d9;
        }
    </style> --}}

    <!-- Push styles from individual views -->
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800">
    
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
