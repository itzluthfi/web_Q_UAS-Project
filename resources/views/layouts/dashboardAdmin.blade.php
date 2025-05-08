<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyAnimeList - Admin')</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com "></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins :wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Styles Dinamis -->
    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100 font-poppins">

<!-- Sidebar -->
@include('components.sidebarAdmin')

<!-- Main Content Wrapper -->
<div class="main-wrapper" id="mainWrapper" style="margin-left: 260px;">
    <!-- Top Navbar -->
    @include('components.navbarAdmin')

    <!-- Main Content -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 py-4 px-6 mt-auto">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-gray-400 text-sm mb-4 md:mb-0">
                &copy; {{ date('Y') }}, Dibuat dengan 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-red-500" viewBox="0 0 20 20"
                      fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                          clip-rule="evenodd"/>
                </svg>
                oleh MyAnimeList Team
            </div>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-400 hover:text-white">Bantuan</a>
                <a href="#" class="text-gray-400 hover:text-white">FAQ</a>
                <a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>
</div>

<!-- Scripts Dinamis -->
@stack('scripts')

</body>
</html>