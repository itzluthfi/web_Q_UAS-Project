@extends('layouts.app')

@section('title', 'Detail Anime - MyAnimeList')

@section('content')
    <div class="anime-backdrop">
        <div class="max-w-4xl mx-auto bg-gray-800 shadow-xl rounded-lg overflow-hidden glow-effect">
            <!-- Title and Image -->
            <div class="md:flex p-6">
                <div class="md:w-64 flex-shrink-0 mb-6 md:mb-0">
                    <!-- Gambar dengan fallback -->
                    <img class="w-full h-auto rounded-lg shadow-lg border border-gray-700"
                        src="{{ $anime['images']['jpg']['image_url'] ?? $anime['images']['webp']['image_url'] ?? asset('assets/image-notFound.jpg') }}"
                        alt="{{ $anime['title'] ?? 'Untitled' }}">

                    <!-- Score dengan fallback -->
                    <div class="mt-4 bg-gray-700 rounded-lg p-3 text-center">
                        <div class="text-3xl font-bold text-yellow-400">
                            {{ $anime['score'] ?? 'N/A' }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">SCORE</div>
                    </div>

                    <!-- Tombol Favorite -->
                    <button class="w-full mt-4 px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-500 transition flex items-center justify-center btn-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-.185 1.118.588 1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Tambahkan ke Favorite
                    </button>
                </div>

                <div class="md:ml-6 flex-1">
                    <!-- Judul dengan fallback -->
                    <h1 class="text-3xl font-bold text-purple-400 mb-4">
                        {{ $anime['title'] ?? 'Untitled' }}
                    </h1>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <!-- Status dengan fallback -->
                        <span class="bg-purple-900/50 text-purple-200 px-3 py-1 rounded-full text-sm">
                            {{ $anime['status'] ?? 'Unknown' }}
                        </span>

                        <!-- Episode dengan fallback -->
                        <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm">
                            {{ $anime['episodes'] ?? 'Unknown' }} Episode
                        </span>

                        <!-- Rating dengan fallback -->
                        <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm">
                            {{ $anime['rating'] ?? 'Not Rated' }}
                        </span>
                    </div>

                    <div class="mb-4 text-gray-400">
                        <!-- Aired dengan fallback -->
                        <p class="mb-1"><strong class="text-gray-300">Tayang:</strong> 
                            {{ $anime['aired']['string'] ?? 'Unknown' }}
                        </p>

                        <!-- Studio dengan fallback -->
                        <p class="mb-1"><strong class="text-gray-300">Studio:</strong> 
                            @if (!empty($anime['studios']))
                                {{ $anime['studios'][0]['name'] ?? 'Unknown' }}
                            @else
                                Unknown
                            @endif
                        </p>

                        <!-- Genre dengan fallback -->
                        <p class="mb-1"><strong class="text-gray-300">Genre:</strong> 
                            @if (!empty($anime['genres']))
                                {{ implode(', ', array_column($anime['genres'], 'name')) }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-purple-300 mb-2">Sinopsis</h3>
                        <div class="text-gray-300 leading-relaxed">
                            <!-- Sinopsis dengan fallback -->
                            @if (!empty($anime['synopsis']))
                                <p>{!! nl2br(e($anime['synopsis'])) !!}</p>
                            @else
                                <p class="text-gray-500 italic">Sinopsis tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="px-6 pb-6">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition btn-glow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali ke List
                </a>
            </div>

            <!-- Komentar Section -->
            <div class="border-t border-gray-700 mt-4 px-6 py-8">
                <h2 class="text-2xl font-semibold mb-6 text-purple-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Komentar
                </h2>

                <!-- Form Komentar -->
                <form method="POST" action="#" class="mb-8">
                    @csrf
                    <textarea name="comment" rows="3" placeholder="Tulis komentar kamu..."
                        class="w-full input-dark rounded-lg p-4 mb-3 focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none"></textarea>
                    <button type="submit"
                        class="bg-purple-700 text-white px-5 py-2 rounded-lg hover:bg-purple-600 transition flex items-center btn-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                        </svg>
                        Kirim Komentar
                    </button>
                </form>

                <!-- List Komentar -->
                <div class="space-y-4">
                    @foreach ($comments as $comment)
                        <div class="p-4 bg-gray-700/50 border border-gray-600 rounded-lg shadow-md comment-transition">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 rounded-full bg-purple-700 flex items-center justify-center mr-3">
                                    <span class="font-bold text-white">{{ substr($comment->user->username, 0, 1) }}</span>
                                </div>
                                <p class="font-semibold text-white">{{ $comment->user->username }}</p>
                                <span class="ml-auto text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-300">{{ $comment->body }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Related Anime Section (Optional) -->
        <div class="max-w-4xl mx-auto mt-8 mb-12">
            <h2 class="text-2xl font-semibold mb-6 text-purple-300">Anime Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($relatedAnimes as $relatedAnime)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 hover:border-purple-500 transition related-anime-card">
                        <img src="{{ $relatedAnime['images']['jpg']['small_image_url'] }}" alt="{{ $relatedAnime['title'] }}" class="w-full h-32 object-cover">
                        <div class="p-2">
                            <p class="text-sm font-medium text-white truncate">{{ $relatedAnime['title'] }}</p>
                            <p class="text-xs text-gray-400">{{ $relatedAnime['type'] }} • {{ $relatedAnime['episodes'] ?? 'N/A' }} Eps</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom styles for anime detail page */
        .anime-backdrop {
            position: relative;
        }
        .anime-backdrop::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background-image: url('{{ $anime['images']['jpg']['large_image_url'] ?? $anime['images']['jpg']['image_url'] }}');
            background-size: cover;
            background-position: center;
            filter: blur(10px) brightness(0.3);
            z-index: -1;
        }
        .comment-transition {
            transition: all 0.3s ease;
        }
        .comment-transition:hover {
            transform: translateX(5px);
        }
        /* Fix navbar positioning */
        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
        }
        /* Add proper spacing for content */
        .content-wrapper {
            padding-top: 4rem; /* Adjust based on your navbar height */
        }
        /* Enhance related anime cards */
        .related-anime-card {
            transition: all 0.3s ease;
        }
        .related-anime-card:hover {
            transform: translateY(-5px);
        }
        /* Enhance score badge */
        .score-badge {
            position: relative;
            overflow: hidden;
        }
        .score-badge::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, rgba(255,215,0,0.1), rgba(255,215,0,0.3));
            z-index: 0;
            animation: pulse 2s infinite;
            border-radius: 50%;
        }
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }
            50% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(0.95);
                opacity: 0.7;
            }
        }
        .score-value {
            position: relative;
            z-index: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('.navbar-fixed');

            // Fungsi untuk menangani scroll
            function handleScroll() {
                if (window.scrollY > 10) {
                    navbar.classList.add('bg-gray-900/95', 'shadow-md');
                } else {
                    navbar.classList.remove('bg-gray-900/95', 'shadow-md');
                }
            }

            // Tambahkan event listener untuk scroll
            window.addEventListener('scroll', handleScroll);

            // Panggil sekali saat halaman dimuat
            handleScroll();
        });
    </script>
@endpush