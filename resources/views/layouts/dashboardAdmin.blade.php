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

    @include('components.footer')

<!-- Scripts Dinamis -->
@stack('scripts')

</body>
</html>