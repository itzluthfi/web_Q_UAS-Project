<?php 
include 'app/views/templates/header.php'; 

?>

<style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f1116;
        }
        .anime-bg {
            background-image: url('https://i.imgur.com/JYmKbGg.jpg');
            background-size: cover;
            background-position: center;
        }
        .glow-effect {
            box-shadow: 0 0 15px rgba(101, 31, 255, 0.4);
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
        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(101, 31, 255, 0.6);
        }
</style>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-gray-900 to-black">
    <div class="w-full max-w-4xl flex overflow-hidden rounded-xl shadow-2xl bg-gray-800 glow-effect">
        <!-- Bagian Anime Illustration - Sembunyikan di mobile -->
        <div class="hidden md:block w-1/2 relative anime-bg">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-8 text-white">
                <h2 class="text-2xl font-bold mb-2">My Anime List</h2>
                <p class="text-sm opacity-80">Temukan dan lacak anime favoritmu</p>
            </div>
        </div>

        <!-- Bagian Form Login -->
        <div class="w-full md:w-1/2 p-8 bg-gray-900">
            <div class="mb-8 text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-purple-700 flex items-center justify-center glow-effect">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white">Selamat Datang</h1>
                <p class="text-gray-400 mt-2">Masuk ke akun MAL Anda</p>
            </div>

            <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="mb-4 p-3 bg-red-900/50 border-l-4 border-red-500 text-red-200 flex items-center rounded-r">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span><?= htmlspecialchars($_SESSION['error_message']) ?></span>
            </div>
            <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="mb-4 p-3 bg-green-900/50 border-l-4 border-green-500 text-green-200 flex items-center rounded-r">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span><?= htmlspecialchars($_SESSION['success_message']) ?></span>
            </div>
            <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <form action="./login/submit" method="POST" class="space-y-6">
                <div class="relative">
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-1">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            required
                            class="input-dark block w-full pl-10 pr-3 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Masukkan username"
                        />
                    </div>
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="input-dark block w-full pl-10 pr-10 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            placeholder="Masukkan password"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="text-gray-400 hover:text-gray-300 focus:outline-none"
                            >
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z" clip-rule="evenodd" />
                                    <path d="M10.748 13.93l2.523 2.523a9.987 9.987 0 01-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 010-1.186A10.007 10.007 0 012.839 6.02L6.07 9.252a4 4 0 004.678 4.678z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember-me"
                            name="remember-me"
                            type="checkbox"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-600 rounded bg-gray-700"
                        />
                        <label for="remember-me" class="ml-2 block text-sm text-gray-300">
                            Ingat saya
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-purple-400 hover:text-purple-300">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-700 hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors btn-glow"
                    >
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400">
                    Belum punya akun?
                    <a href="./register" class="font-medium text-purple-400 hover:text-purple-300">
                        Daftar di sini
                    </a>
                </p>
            </div>

            <!-- <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-900 text-gray-400">Atau masuk dengan</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button
                        type="button"
                        class="w-full inline-flex justify-center py-2 px-4 border border-gray-700 rounded-lg shadow-sm bg-gray-800 text-sm font-medium text-gray-400 hover:bg-gray-700 transition-colors"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.787-1.676-4.139-2.701-6.735-2.701-5.522 0-10.001 4.478-10.001 10s4.479 10 10.001 10c8.396 0 10.249-7.85 9.426-11.748l-9.426 0.081z" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="w-full inline-flex justify-center py-2 px-4 border border-gray-700 rounded-lg shadow-sm bg-gray-800 text-sm font-medium text-gray-400 hover:bg-gray-700 transition-colors"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                        </svg>
                    </button>
                </div>
            </div> -->
        </div>
    </div>

<script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>