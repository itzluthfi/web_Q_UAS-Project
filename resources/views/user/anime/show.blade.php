@extends('layouts.app')

@section('title', 'Detail Anime - AnimeVerse')

@section('content')
<style>
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
    /* Watch buttons styling */
    .watch-buttons {
        display: flex;
        gap: 10px;
        margin-top: 16px;
        flex-wrap: wrap;
    }
    .watch-button {
        flex: 1;
        min-width: 140px;
        padding: 10px 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .watch-now {
        background-color: #9333ea;
        color: white;
    }
    .watch-now:hover {
        background-color: #7e22ce;
        transform: translateY(-2px);
    }
    .watch-trailer {
        background-color: rgba(107, 70, 193, 0.2);
        color: #d8b4fe;
        border: 1px solid #9333ea;
    }
    .watch-trailer:hover {
        background-color: rgba(107, 70, 193, 0.3);
        transform: translateY(-2px);
    }
    /* Reply system styling */
    .replies-container {
        margin-left: 2rem;
        margin-top: 0.75rem;
        border-left: 2px solid #4b5563;
        padding-left: 1rem;
        display: none;
    }
    .replies-container.show {
        display: block;
    }
    .reply-form {
        margin-top: 0.5rem;
        display: none;
    }
    .reply-form.show {
        display: block;
    }
    .comment-actions {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    .comment-action {
        font-size: 0.75rem;
        color: #9ca3af;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    .comment-action:hover {
        color: #d1d5db;
    }
    .comment-action svg {
        width: 0.875rem;
        height: 0.875rem;
        margin-right: 0.25rem;
    }
    </style>
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

                    <!-- Watch buttons -->
                    <div class="watch-buttons">
                        <a href="#" class="watch-button watch-now" onclick="watchNow('{{ $anime['title'] ?? 'Untitled' }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Tonton Sekarang
                        </a>
                        <a href="#" class="watch-button watch-trailer" onclick="watchTrailer('{{ $anime['title'] ?? 'Untitled' }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                            </svg>
                            Tonton Trailer
                        </a>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        Komentar
    </h2>

    <!-- Form Komentar -->
        <form id="form-komentar" method="POST" action="#" class="mb-8">
            @csrf
            <input type="hidden" name="parent_id" id="parent_id" value=""> <!-- Untuk menyimpan ID komentar jika ada balasan -->
            <textarea id="comment-input"
                    name="content"
                    rows="3"
                    placeholder="Tulis komentar kamu..."
                    class="w-full input-dark rounded-lg p-4 mb-3 focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none"></textarea>
            <button type="submit"
                    class="bg-purple-700 text-white px-5 py-2 rounded-lg hover:bg-purple-600 transition flex items-center btn-glow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                        clip-rule="evenodd"/>
                </svg>
                Kirim Komentar
            </button>
        </form>

     <!-- Daftar Komentar -->
     <div id="comments-section" class="space-y-4">
        @forelse ($comments as $comment)
            <div class="p-4 bg-gray-700/50 border border-gray-600 rounded-lg shadow-md comment-item"
                 id="comment-{{ $comment->id }}">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 rounded-full bg-purple-700 flex items-center justify-center mr-3">
                        <span class="font-bold text-white">{{ substr($comment->user->username, 0, 1) }}</span>
                    </div>
                    <p class="font-semibold text-white">{{ $comment->user->username ?? 'Unknown' }}</p>
                    <span class="ml-auto text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                <p class="text-gray-300">{{ $comment->content }}</p>

                <div class="mt-2 flex space-x-4">
                    <!-- Tombol Balas -->
                    <button type="button"
                            class="reply-toggle text-purple-400 hover:text-white"
                            data-comment-id="{{ $comment->id }}"
                            onclick="handleReplyClick({{ $comment->id }})">
                        Balas
                    </button>

                    <!-- Tombol Toggle Balasan -->
                    @if(count($comment->replies ?? []) > 0)
                        <button type="button"
                                class="flex items-center text-blue-400 hover:text-blue-300 toggle-replies"
                                data-comment-id="{{ $comment->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="w-4 h-4 mr-1 reply-icon-show">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="replies-count">{{ count($comment->replies ?? []) }}</span> Balasan
                        </button>
                    @else
                        <span class="text-sm text-gray-500">Belum ada balasan</span>
                    @endif
                </div>

                <!-- Form Balasan -->
                <div id="reply-form-{{ $comment->id }}" class="reply-form mt-3 p-4 bg-gray-800 rounded-md hidden">
                    <form method="POST" action="#">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="body" rows="2" placeholder="Tulis balasan..."
                                  class="w-full input-dark rounded-md p-2 mb-2"></textarea>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeReplyForm({{ $comment->id }})"
                                    class="px-3 py-1 text-sm bg-gray-700 hover:bg-gray-600 rounded">Batal</button>
                            <button type="submit"
                                    class="px-3 py-1 text-sm bg-purple-700 hover:bg-purple-600 rounded btn-glow">Kirim</button>
                        </div>
                    </form>
                </div>

                <!-- Container Balasan -->
                <div id="replies-{{ $comment->id }}" class="replies-container mt-4 pl-6 border-l border-gray-600 hidden">
                    @if(isset($comment->replies) && count($comment->replies) > 0)
                        @foreach($comment->replies as $reply)
                            <div class="p-3 bg-gray-700/30 border border-gray-600 rounded-lg shadow-sm mt-2">
                                <div class="flex items-center mb-1">
                                    <div class="w-6 h-6 rounded-full bg-purple-600 flex items-center justify-center mr-2">
                                        <span class="font-bold text-white text-xs">
                                            {{ substr($reply->user->username, 0, 1) }}
                                        </span>
                                    </div>
                                    <p class="font-medium text-white text-sm">{{ $reply->user->username ?? 'Unknown' }}</p>
                                    <span class="ml-auto text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300 text-sm">{{ $reply->content }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-400 italic text-sm mt-2">Belum ada balasan.</p>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-400 italic">Belum ada komentar.</p>
        @endforelse
    </div>
</div>


        <!-- Related Anime Section (Optional) -->
        <div class="max-w-4xl mx-auto mt-8 mb-12">
            <h2 class="text-2xl font-semibold mb-6 text-purple-300">Anime Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($relatedAnimes as $relatedAnime)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 hover:border-purple-500 transition related-anime-card">
                        <img src="{{ $relatedAnime['images']['jpg']['small_image_url'] }}" alt="{{ $relatedAnime['title'] }}" class="w-full h-32 object-cover">
                        <div class="p-2">
                            <p class="text-sm font-medium text-white truncate">{{ $relatedAnime['title'] }}</p>
                            <p class="text-xs text-gray-400">{{ $relatedAnime['type'] }} • {{ $relatedAnime['episodes'] ?? 'N/A' }} Eps</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-white py-4">
                        <p>Tidak ada anime terkait saat ini.</p>
                    </div>
                @endforelse
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

    // Fungsi untuk menangani scroll navbar
    function handleScroll() {
        if (window.scrollY > 10) {
            navbar?.classList.add('bg-gray-900/95', 'shadow-md');
        } else {
            navbar?.classList.remove('bg-gray-900/95', 'shadow-md');
        }
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Jalankan saat halaman dimuat

    // --- Balasan Komentar ---
    const replyToggles = document.querySelectorAll('.reply-toggle');
    const cancelReplies = document.querySelectorAll('.cancel-reply');
    const toggleRepliesButtons = document.querySelectorAll('.toggle-replies');

    // Toggle form balasan
    replyToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const replyForm = document.getElementById(`reply-form-${commentId}`);

            if (!replyForm) {
                console.error(`Form #reply-form-${commentId} tidak ditemukan`);
                return;
            }

            // Tutup semua form balasan lain
            document.querySelectorAll('.reply-form').forEach(form => {
                if (form.id !== `reply-form-${commentId}`) {
                    form.classList.add('hidden');
                }
            });

            // Toggle form yang sesuai
            replyForm.classList.toggle('hidden');

            // Ganti teks tombol
            this.textContent = this.textContent.includes('Balas') ? 'Sembunyikan' : 'Balas';
        });
    });

    // Tutup form balasan dengan tombol batal
    cancelReplies.forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const replyForm = document.getElementById(`reply-form-${commentId}`);

            if (replyForm) {
                replyForm.classList.add('hidden');
            }
        });
    });

    // Toggle tampilan balasan dari komentar
    toggleRepliesButtons.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const repliesContainer = document.getElementById(`replies-${commentId}`);
            
            if (!repliesContainer) {
                console.error(`#replies-${commentId} tidak ditemukan`);
                return;
            }

            repliesContainer.classList.toggle('show');

            const countSpan = this.querySelector('.replies-count');
            const count = countSpan ? countSpan.textContent : '0';

            // Update ikon dan teks tombol
            if (repliesContainer.classList.contains('show')) {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="replies-count">${count}</span> Sembunyikan Balasan`;
            } else {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="replies-count">${count}</span> Balasan`;
            }
        });
    });

    // --- Sidebar Toggle ---
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Toggle sidebar desktop
    function toggleDesktopSidebar() {
        if (window.innerWidth >= 768) {
            sidebar?.classList.toggle('collapsed');
            mainWrapper?.classList.toggle('sidebar-collapsed');
            if (sidebar?.classList.contains('collapsed')) {
                mainWrapper.style.marginLeft = '70px';
            } else {
                mainWrapper.style.marginLeft = '260px';
            }
        }
    }

    // Buka sidebar mode mobile
    function openMobileSidebar() {
        if (window.innerWidth < 768 && sidebar && mainWrapper) {
            sidebar.classList.add('show');
            sidebarOverlay?.classList.add('show');
            document.body.style.overflow = 'hidden'; // Hindari scroll saat sidebar muncul
        }
    }

    // Tutup sidebar mobile
    function closeMobileSidebar() {
        if (sidebar && mainWrapper) {
            sidebar.classList.remove('show');
            sidebarOverlay?.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    // Event listener tombol toggle
    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (window.innerWidth >= 768) {
                toggleDesktopSidebar();
            } else {
                if (sidebar?.classList.contains('show')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            }
        });
    }

    // Tutup sidebar jika klik di luar
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    // --- Dropdown User Menu ---
    const userMenu = document.getElementById('user-menu');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenu && userDropdown) {
        userMenu.addEventListener('click', function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Close dropdown saat klik di luar
        document.addEventListener('click', function () {
            userDropdown.classList.remove('show');
        });
    }

    // --- Modal Edit ---
    const editModal = document.getElementById('editModal');

    window.openEditModal = function (userId) {
        if (!editModal) {
            console.error("Modal edit tidak ditemukan");
            return;
        }
        document.getElementById('edit-username').value = 'username_' + userId;
        document.getElementById('edit-email').value = 'user' + userId + '@example.com';
        editModal.classList.remove('hidden');
    };

    window.closeEditModal = function () {
        if (editModal) {
            editModal.classList.add('hidden');
        }
    };

    // Tutup modal saat klik di luar area konten
    window.addEventListener('click', function (e) {
        if (editModal && !editModal.classList.contains('hidden')) {
            const modalContent = editModal.querySelector('.inline-block');
            if (modalContent && !modalContent.contains(e.target)) {
                closeEditModal();
            }
        }
    });

    // --- Fungsi Watch Button ---
    window.watchNow = function (title) {
        alert(`Menonton ${title} sekarang`);
        // Tambahkan logika redirect atau video player di sini
    };

    window.watchTrailer = function (title) {
        alert(`Menonton trailer dari ${title}`);
        // Implementasi trailer logic
    };

    function handleReplyClick(commentId) {
    const commentInput = document.getElementById('comment-input');
    if (!commentInput) {
        console.error("Textarea komentar tidak ditemukan");
        return;
    }

    // Ambil username dari komentar
    const usernameEl = document.querySelector(`[data-comment-id="${commentId}"]`)?.closest('.comment-item')?.querySelector('.font-semibold')?.textContent || '';
    
    // Jika username ditemukan, ganti placeholder
    if (usernameEl) {
        commentInput.placeholder = `Balas kepada @${usernameEl}`;
    } else {
        commentInput.placeholder = 'Tulis komentar kamu...';
    }

    // Fokus ke textarea
    commentInput.focus();

    // Scroll ke textarea
    commentInput.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Simpan parent_id jika perlu
    const parentIdInput = document.getElementById('parent_id');
    if (parentIdInput) {
        parentIdInput.value = commentId;
    }
}

});

    </script>
@endpush