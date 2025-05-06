<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - Anime Error Page</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'anime-purple': '#9D4EDD',
                    'anime-dark': '#0F0A1A',
                    'anime-accent': '#C77DFF'
                },
            }
        }
    }
    </script>
</head>

<body class="bg-anime-dark text-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-gray-900 rounded-lg shadow-xl overflow-hidden border border-anime-purple/30">

        <!-- Fire Force Banner -->
        <div class="flex justify-center">
            <img src="{{ asset('storage/' . 'system/run.gif') }}" alt="Fire Force Banner"
                class="w-full max-h-48 object-cover rounded-t-lg border-b-2 border-anime-purple">
        </div>

        <div class="p-6">

            <!-- Error code and message -->
            <div class="text-center mb-6">
                <h1 class="text-6xl font-bold text-anime-purple mb-2">404</h1>
                <h2 class="text-xl font-medium mb-2">Page Not Found</h2>
                <p class="text-gray-400 text-sm">The page you're looking for doesn't seem to exist.</p>
            </div>

            <!-- Divider -->
            <div class="flex items-center justify-center mb-6">
                <div class="h-px w-16 bg-anime-purple opacity-50"></div>
                <div class="mx-2">
                    <i class="fas fa-star text-anime-purple text-xs"></i>
                </div>
                <div class="h-px w-16 bg-anime-purple opacity-50"></div>
            </div>

            <!-- Back button -->
            <div class="flex justify-center">
                <a href="javascript:history.back()"
                    class="btn bg-anime-purple hover:bg-anime-accent border-none text-white">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Go Back
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-950 p-3 text-center text-xs text-gray-500">
            <p>Your journey continues elsewhere...</p>
        </div>
    </div>

    <!-- Floating Icons -->
    <div class="fixed top-10 left-10 animate-pulse opacity-20">
        <i class="fas fa-moon text-anime-purple text-xl"></i>
    </div>
    <div class="fixed bottom-10 right-10 animate-pulse opacity-20">
        <i class="fas fa-star text-anime-purple text-xl"></i>
    </div>
</body>

</html>