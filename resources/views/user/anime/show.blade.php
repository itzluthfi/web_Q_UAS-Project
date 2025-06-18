@extends('layouts.app')

@section('title', 'Detail Anime - AnimeVerse')

@push('styles')
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
@endpush

@section('content')
{{-- @dd($anime); --}}
    <div class="anime-backdrop">
        <div class="max-w-4xl mx-auto bg-gray-800 shadow-xl rounded-lg overflow-hidden glow-effect">
            <!-- Title and Image -->
            <div class="md:flex p-6">
                <div class="md:w-64 flex-shrink-0 mb-6 md:mb-0">
                    <!-- Gambar dengan fallback -->
                    <img class="w-full h-auto rounded-lg shadow-lg border border-gray-700"
                        src="{{ $anime->image_url ?? $anime['images']['webp']['image_url'] ?? asset('assets/image-notFound.jpg') }}"
                        alt="{{ $anime->title ?? 'Untitled' }}">

                    <!-- Score dengan fallback -->
                    <div class="mt-4 bg-gray-700 rounded-lg p-3 text-center">
                        <div class="text-3xl font-bold text-yellow-400">
                            {{ $anime->score ?? 'N/A' }}
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
                        {{ $anime->title ?? 'Untitled' }}
                    </h1>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <!-- Status dengan fallback -->
                        <span class="bg-purple-900/50 text-purple-200 px-3 py-1 rounded-full text-sm">
                            {{ $anime->status ?? 'Unknown' }}
                        </span>

                        <!-- Episode dengan fallback -->
                        <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm">
                            {{ $anime->episodes ?? 'Unknown' }} Episode
                        </span>

                        <!-- Rating dengan fallback -->
                        <span class="bg-gray-700 text-gray-300 px-3 py-1 rounded-full text-sm">
                            {{ $anime['rating'] ?? 'Not Rated' }}
                        </span>
                    </div>

                    <div class="mb-4 text-gray-400">
                        <!-- Aired dengan fallback -->
                        <p class="mb-1"><strong class="text-gray-300">Tayang:</strong> 
                            {{ $anime->aired_to ?? 'Unknown' }} - {{ $anime->aired_from ?? 'Unknown' }}
                        </p>

                        {{-- <!-- Studio dengan fallback -->
                        <p class="mb-1"><strong class="text-gray-300">Studio:</strong> 
                            @if (!empty($anime['studios']))
                                {{ $anime['studios'][0]['name'] ?? 'Unknown' }}
                            @else
                                Unknown
                            @endif
                        </p> --}}

                        <!-- Genre dengan fallback -->
                        <p class="mb-1">
                            <strong class="text-gray-300">Genre:</strong> 
                            @if ($anime->genres->isNotEmpty())
                                {{ $anime->genres->pluck('name')->implode(', ') }}
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-xl font-semibold text-purple-300 mb-2">Sinopsis</h3>
                        <div class="text-gray-300 leading-relaxed">
                            <!-- Sinopsis dengan fallback -->
                            @if (!empty($anime->synopsis))
                                <p>{!! nl2br(e($anime->synopsis)) !!}</p>
                            @else
                                <p class="text-gray-500 italic">Sinopsis tidak tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <div class="watch-buttons">
                            <a href="{{ $anime['url'] ?? '#' }}" target="_blank" class="watch-button watch-now">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                                Tonton Sekarang
                            </a>

                            @if (!empty($anime['trailer']['embed_url']))
                            <a href="javascript:void(0);" onclick="watchTrailer('{{ $anime['trailer']['embed_url'] }}')" class="watch-button watch-trailer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                                Tonton Trailer
                            </a>
                            @endif
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
            <h2 class="text-2xl font-semibold mb-6 text-purple-300 flex items-center header-komentar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Komentar
            </h2>

            <!-- Form Komentar -->
                <form id="form-komentar" method="POST" action="{{ route('comments.store') }}" class="mb-8">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id" value=""> <!-- Untuk menyimpan ID komentar jika ada balasan -->
                    <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
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
                    <div class="p-4 bg-gray-700/50 border border-gray-600 rounded-lg shadow-md comment-item comment-item"
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
                                    >
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
                                    <div class="p-3 bg-gray-700/30 border border-gray-600 rounded-lg shadow-sm mt-2" id="comment-reply-{{ $reply->id }}">
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

        {{-- @dd($relatedAnimes); --}}

        <!-- Related Anime Section (Optional) -->
        <div class="max-w-4xl mx-auto mt-8 mb-12 px-4">
            <h2 class="text-2xl font-semibold mb-6 text-purple-300">Anime Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($relatedAnimes as $relatedAnime)
                    <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 hover:border-purple-500 transition related-anime-card">
                        
                        <img src="{{ 
                            $relatedAnime->image_url ?? 
                            $relatedAnime->image_url ?? 
                            'https://via.placeholder.com/400x600?text=No+Image ' 
                        }}" 
                        alt="{{ $anime['title'] ?? 'Anime Title' }}" class="w-full h-48 object-cover">
                        <div class="p-2">
                            <p class="text-sm font-medium text-white truncate">{{ $relatedAnime['title'] }}</p>
                            <p class="text-xs text-gray-400">{{ $relatedAnime['type'] }} • {{ $relatedAnime['episodes'] ?? 'N/A' }} Eps</p>
                            <a href="{{ route('anime.show', ['id' => $relatedAnime['mal_id']]) }}" class="mt-2 inline-block text-xs text-purple-400 hover:text-purple-200">View Detail</a>
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

@if (session('new_comment_id'))
    <script>
        localStorage.setItem('newCommentId', '{{ session('new_comment_id') }}');
    </script>
@endif


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
            background-image: url('{{ $anime->large_image_url ?? $anime->image_url }}');
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
function watchTrailer(embedUrl) {
    const modalHtml = `
        <div id="trailer-modal" style="
            position: fixed;
            inset: 0;
            background-color: rgba(107, 33, 168, 0.3); 
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeInScale 0.3s ease-out forwards;
        ">
            <div style="
                position: relative;
                background: rgba(107, 33, 168, 0.78);
                padding: 1rem;
                border-radius: 1rem;
                max-width: 640px;
                width: 90%;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                transform: scale(0.9);
                opacity: 0;
                animation: fadeInScale 0.3s ease-out forwards;
            ">
                <button onclick="closeTrailer()" style="
                    position: absolute;
                    top: 0.5rem;
                    right: 0.5rem;
                    background: #ef4444;
                    color: white;
                    border: none;
                    border-radius: 9999px;
                    width: 2rem;
                    height: 2rem;
                    font-size: 1.25rem;
                    cursor: pointer;
                ">×</button>
                <iframe width="100%" height="360" src="${embedUrl}" frameborder="0" allowfullscreen style="
                    border-radius: 0.5rem;
                    width: 100%;
                "></iframe>
            </div>
        </div>
        <style>
            @keyframes fadeInScale {
                0% { opacity: 0; transform: scale(0.9); }
                100% { opacity: 1; transform: scale(1); }
            }
        </style>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

function closeTrailer() {
    const modal = document.getElementById('trailer-modal');
    if (modal) modal.remove();
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // =========================
    // Navbar Scroll Effect
    // =========================
    const navbar = document.querySelector('.navbar-fixed');

    function handleScroll() {
        if (window.scrollY > 10) {
            navbar?.classList.add('bg-gray-900/95', 'shadow-md');
        } else {
            navbar?.classList.remove('bg-gray-900/95', 'shadow-md');
        }
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // =========================
    // Komentar & Balasan
    // =========================
    const replyToggles = document.querySelectorAll('.reply-toggle');
    const cancelReplies = document.querySelectorAll('.cancel-reply');
    const toggleRepliesButtons = document.querySelectorAll('.toggle-replies');
    const commentForm = document.getElementById('form-komentar');
    const parentIdInput = document.getElementById('parent_id');
    const commentInput = document.getElementById('comment-input');

    
    // Tombol "Balas" diklik
    replyToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            
            if (parentIdInput) {
                parentIdInput.value = commentId;
                localStorage.setItem('lastReplyCommentId', commentId);
            }
            
            commentInput.placeholder = 'Tulis komentar kamu...';
            
            const replyForm = document.getElementById('form-komentar');
            if (replyForm) {
                const formOffset = replyForm.getBoundingClientRect().top + window.scrollY;
                const centerOffset = window.innerHeight / 2 - replyForm.offsetHeight / 2;
                
                window.scrollTo({
                    top: formOffset - centerOffset,
                    behavior: 'smooth'
                });
                
                setTimeout(() => commentInput.focus(), 500);
            }
        });
    });
    
    let isSubmitting = false;
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            if (commentInput.value.trim() === '') {
                e.preventDefault();
                alert('Komentar tidak boleh kosong.');
                return;
            }
            
            if (isSubmitting) {
                e.preventDefault();
                return; // Cegah submit ganda
            }
            
            isSubmitting = true;
            
            // Optional: ubah tombol agar tidak bisa ditekan ulang
            const submitButton = commentForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = 'Mengirim...';
        }
    });
    }

   const lastCommentId = localStorage.getItem('newCommentId');
if (lastCommentId) {
    // Coba cari elemen komentar biasa dulu
    let targetElement = document.getElementById(`comment-${lastCommentId}`);
    console.log(" Target element :", targetElement);

    // Kalau tidak ada, cari sebagai balasan (reply)
    if (!targetElement) {
        targetElement = document.getElementById(`comment-reply-${lastCommentId}`);
        console.log(" Target element reply:", targetElement);

        if (targetElement) {
            // Dapatkan parent replies container dan tampilkan jika tersembunyi
            const parentRepliesContainer = targetElement.closest('.replies-container');
            console.log(" Parent replies container:", parentRepliesContainer);
            if (parentRepliesContainer && parentRepliesContainer.classList.contains('hidden')) {
                parentRepliesContainer.classList.remove('hidden');

                // Scroll harus dilakukan *setelah* container dimunculkan
                setTimeout(() => {
                    const offset = targetElement.getBoundingClientRect().top + window.scrollY;
                    const centerOffset = window.innerHeight / 2 - targetElement.offsetHeight / 2;

                    window.scrollTo({
                        top: offset - centerOffset,
                        behavior: 'smooth'
                    });
                }, 100); // Delay kecil agar DOM sempat render
            } else {
                // Container sudah terlihat, langsung scroll
                const offset = targetElement.getBoundingClientRect().top + window.scrollY;
                const centerOffset = window.innerHeight / 2 - targetElement.offsetHeight / 2;

                window.scrollTo({
                    top: offset - centerOffset,
                    behavior: 'smooth'
                });
            }
        }
    } else {
        // Jika komentar biasa
        const offset = targetElement.getBoundingClientRect().top + window.scrollY;
        const centerOffset = window.innerHeight / 2 - targetElement.offsetHeight / 2;

        window.scrollTo({
            top: offset - centerOffset,
            behavior: 'smooth'
        });
    }

    // Bersihkan localStorage
    localStorage.removeItem('newCommentId');
}





    // Tombol "Batal Balas"
    cancelReplies.forEach(button => {
        button.addEventListener('click', function () {
            if (parentIdInput) {
                parentIdInput.value = '';
            }
            commentInput.placeholder = 'Tulis komentar kamu...';
        });
    });

    // Toggle tampilkan/sembunyikan balasan
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

            this.innerHTML = repliesContainer.classList.contains('show') ?
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/></svg><span class="replies-count">${count}</span> Sembunyikan Balasan`
                :
                `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg><span class="replies-count">${count}</span> Balasan`;
        });
    });

    // Custom fungsi balas + placeholder username
    window.handleReplyClick = function (commentId) {
        if (!commentInput) return;

        const username = document.querySelector(`[data-comment-id="${commentId}"]`)?.closest('.comment-item')?.querySelector('.font-semibold')?.textContent || '';
        commentInput.placeholder = username ? `Balas kepada @${username}` : 'Tulis komentar kamu...';

        commentInput.focus();
        commentInput.scrollIntoView({ behavior: 'smooth', block: 'center' });

        if (parentIdInput) {
            parentIdInput.value = commentId;
        }
    };

    // =========================
    // Sidebar (Responsive)
    // =========================
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebar = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function toggleDesktopSidebar() {
        if (window.innerWidth >= 768) {
            sidebar?.classList.toggle('collapsed');
            mainWrapper?.classList.toggle('sidebar-collapsed');
            mainWrapper.style.marginLeft = sidebar?.classList.contains('collapsed') ? '70px' : '260px';
        }
    }

    function openMobileSidebar() {
        if (window.innerWidth < 768 && sidebar && mainWrapper) {
            sidebar.classList.add('show');
            sidebarOverlay?.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileSidebar() {
        sidebar?.classList.remove('show');
        sidebarOverlay?.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (window.innerWidth >= 768) {
                toggleDesktopSidebar();
            } else {
                sidebar?.classList.contains('show') ? closeMobileSidebar() : openMobileSidebar();
            }
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    // =========================
    // Dropdown User Menu
    // =========================
    const userMenu = document.getElementById('user-menu');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenu && userDropdown) {
        userMenu.addEventListener('click', function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function () {
            userDropdown.classList.remove('show');
        });
    }

   
});
</script>

@endpush

