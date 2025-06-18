@extends('layouts.app')

@section('title', 'Login - Animeverse')
@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f1116;
        }

        .anime-bg {
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
@endpush
@section('content')
    <div class="flex items-center justify-center p-4">
        <div class="w-full max-w-4xl flex overflow-hidden rounded-xl shadow-2xl bg-gray-800 glow-effect">
            <!-- Bagian Anime Illustration - Sembunyikan di mobile -->
            <div class="hidden md:block w-1/2 relative anime-bg" style="background-image: url('{{ asset('assets/system/run.gif') }}'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-8 text-white z-10">
                    <h2 class="text-2xl font-bold mb-2">Anime Verse</h2>
                    <p class="text-sm opacity-80">Bergabunglah dan mulai koleksi animemu</p>
                </div>
            </div>


            <!-- Bagian Form Login -->
            <div class="w-full md:w-1/2 p-8 bg-gray-900">
                <div class="mb-8 text-center">
                    {{-- <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-purple-700 flex items-center justify-center glow-effect">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div> --}}
                    <h1 class="text-2xl font-bold text-white">Selamat Datang Lagi</h1>
                    <p class="text-gray-400 mt-2">Masuk ke akun Animeverse anda</p>
                </div>

                {{-- Error Message --}}
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-900/50 border-l-4 border-red-500 text-red-200 flex items-center rounded-r">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-900/50 border-l-4 border-green-500 text-green-200 flex items-center rounded-r">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif


                <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                    @csrf
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
                            <input id="username" name="username" type="text" required class="input-dark block w-full pl-10 pr-3 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Masukkan username" />
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
                            <input id="password" name="password" type="password" required class="input-dark block w-full pl-10 pr-10 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Masukkan password" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePassword()" class="text-gray-400 hover:text-gray-300 focus:outline-none">
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.185A10.004 10.004 0 009.999 3a9.956 9.956 0 00-4.744 1.194L3.28 2.22zM7.752 6.69l1.092 1.092a2.5 2.5 0 013.374 3.373l1.091 1.092a4 4 0 00-5.557-5.557z"
                                            clip-rule="evenodd" />
                                        <path d="M10.748 13.93l2.523 2.523a9.987 9.987 0 01-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 010-1.186A10.007 10.007 0 012.839 6.02L6.07 9.252a4 4 0 004.678 4.678z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-600 rounded bg-gray-700" />
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
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-700 hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors btn-glow">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-400">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-purple-400 hover:text-purple-300">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-900 text-gray-400">Atau masuk dengan</span>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <!-- Google Auth Button -->
                        <button id="google-auth" type="button" class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-700 rounded-lg shadow-sm bg-gray-800 text-sm font-medium text-gray-400 hover:bg-gray-700 transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.787-1.676-4.139-2.701-6.735-2.701-5.522 0-10.001 4.478-10.001 10s4.479 10 10.001 10c8.396 0 10.249-7.85 9.426-11.748l-9.426 0.081z" />
                            </svg>
                            <span>Google</span>
                        </button>

                        <!-- GitHub Auth Button -->
                        <button id="github-auth" type="button" class="w-full inline-flex justify-center items-center py-2 px-4 border border-gray-700 rounded-lg shadow-sm bg-gray-800 text-sm font-medium text-gray-400 hover:bg-gray-700 transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 .5C5.648.5.5 5.648.5 12c0 5.086 3.292 9.387 7.863 10.91.575.106.786-.25.786-.555 0-.273-.01-1-.016-1.961-3.2.695-3.878-1.543-3.878-1.543-.523-1.328-1.277-1.681-1.277-1.681-1.045-.715.079-.701.079-.701 1.155.082 1.762 1.186 1.762 1.186 1.028 1.76 2.699 1.251 3.357.957.104-.745.402-1.251.73-1.539-2.553-.291-5.238-1.277-5.238-5.682 0-1.255.449-2.28 1.186-3.084-.119-.291-.515-1.462.114-3.05 0 0 .968-.31 3.17 1.178A11.041 11.041 0 0 1 12 6.844c.98.004 1.966.132 2.887.387 2.2-1.487 3.166-1.178 3.166-1.178.631 1.588.235 2.759.116 3.05.74.804 1.184 1.829 1.184 3.084 0 4.416-2.691 5.387-5.256 5.673.41.354.777 1.049.777 2.114 0 1.528-.014 2.76-.014 3.136 0 .308.208.666.792.553C20.713 21.384 24 17.084 24 12c0-6.352-5.148-11.5-12-11.5z" />
                            </svg>
                            <span>GitHub</span>
                        </button>
                    </div>


                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            $(document).ready(function() {
                $('#google-auth').on('click', function() {
                    window.location.href = '/auth/google';
                });

                $('#github-auth').on('click', function() {
                    window.location.href = '/auth/github';
                });
            });
        </script>
    @endpush
