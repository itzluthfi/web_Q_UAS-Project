@extends('layouts.dashboard')

@section('title', 'Anime Favorit Saya')

@push('styles')
    <style>
        .fav-container {
            background: linear-gradient(145deg, #161921, #13151c);
            border: 1px solid rgba(101, 31, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(101, 31, 255, 0.1);
        }

        .fav-header {
            background: rgba(101, 31, 255, 0.1);
            border-bottom: 1px solid rgba(101, 31, 255, 0.2);
        }

        .fav-title {
            background: linear-gradient(90deg, #fff, #d6c5ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .fav-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, rgba(101, 31, 255, 0.8), rgba(101, 31, 255, 0.3));
            border-radius: 3px;
        }

        .anime-card {
            background: rgba(30, 32, 40, 0.8);
            border: 1px solid rgba(101, 31, 255, 0.15);
            border-radius: 1rem;
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 370px;
        }

        .anime-card:hover {
            box-shadow: 0 8px 32px rgba(101, 31, 255, 0.25);
            transform: translateY(-6px) scale(1.03);
            border-color: #a78bfa;
        }

        .anime-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: #23243a;
            transition: filter 0.2s;
        }

        .anime-card:hover .anime-img {
            filter: brightness(0.92) blur(1px);
        }

        .anime-info {
            padding: 1rem;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .anime-title {
            color: #d6c5ff;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            transition: color 0.2s;
        }

        .anime-card:hover .anime-title {
            color: #a78bfa;
        }

        .anime-meta {
            color: #a1a1aa;
            font-size: 0.9rem;
        }

        .empty-fav {
            color: #a1a1aa;
            text-align: center;
            padding: 2rem 0;
        }

        .remove-fav-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(239, 68, 68, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s, background 0.2s;
            z-index: 2;
            cursor: pointer;
        }

        .anime-card:hover .remove-fav-btn {
            opacity: 1;
        }

        .remove-fav-btn:active {
            background: #b91c1c;
        }

        .search-fav {
            background: rgba(30, 32, 40, 0.8);
            border: 1px solid rgba(101, 31, 255, 0.3);
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
            width: 100%;
            outline: none;
            transition: border 0.2s;
        }

        .search-fav:focus {
            border-color: #a78bfa;
        }

        .toast-fav {
            position: fixed;
            top: 80px;
            right: 30px;
            background: #23243a;
            color: #fff;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 16px rgba(101, 31, 255, 0.15);
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .toast-fav.show {
            opacity: 1;
            pointer-events: auto;
        }

        .toggle-fav-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(251, 191, 36, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s, background 0.2s;
            z-index: 2;
            cursor: pointer;
        }

        .anime-card:hover .toggle-fav-btn {
            opacity: 1;
        }

        .toggle-fav-btn:active {
            background: #f59e42;
        }
    </style>
@endpush

@section('content')
    <div class="fav-container p-0 rounded-2xl overflow-hidden">
        <div class="fav-header p-6 mb-6">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <h1 class="fav-title text-2xl font-bold">Anime Favorit Saya</h1>
                <div class="text-sm text-gray-400">
                    Total: <span id="fav-count">{{ $favorites->count() }}</span> anime
                </div>
            </div>
            <input type="text" id="search-fav" class="search-fav mt-6" placeholder="Cari anime favorit...">
        </div>
        <div class="p-6 pt-0">
            @if ($favorites->count())
                <div id="fav-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($favorites as $anime)
                        <div class="anime-card" data-title="{{ strtolower($anime->title) }}" data-mal="{{ $anime->mal_id }}">
                            {{-- Hapus tombol toggle-fav-btn, hanya tampilkan tombol delete --}}
                            <button class="remove-fav-btn" title="Hapus dari favorit" data-mal="{{ $anime->mal_id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <a href="{{ route('anime.show', ['id' => $anime->mal_id]) }}">
                                <img src="{{ $anime->image_url ?? asset('assets/image-notFound.jpg') }}" alt="{{ $anime->title }}" class="anime-img">
                            </a>
                            <div class="anime-info">
                                <a href="{{ route('anime.show', ['id' => $anime->mal_id]) }}" class="anime-title hover:underline">
                                    {{ $anime->title }}
                                </a>
                                <div class="anime-meta mt-1">
                                    <span>{{ $anime->type ?? '-' }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ $anime->episodes ?? '?' }} eps</span>
                                    <span class="mx-1">•</span>
                                    <span>Score: {{ $anime->score ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-fav">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-2 h-10 w-10 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                    Belum ada anime favorit.<br>
                    Tambahkan anime ke favoritmu dari halaman detail anime!
                </div>
            @endif
        </div>
    </div>
    <div id="toast-fav" class="toast-fav"></div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search/filter
            const searchInput = document.getElementById('search-fav');
            const favList = document.getElementById('fav-list');
            const favCards = favList ? favList.querySelectorAll('.anime-card') : [];
            const favCount = document.getElementById('fav-count');
            const toast = document.getElementById('toast-fav');

            if (searchInput && favList) {
                searchInput.addEventListener('input', function() {
                    const q = searchInput.value.trim().toLowerCase();
                    let visible = 0;
                    favCards.forEach(card => {
                        if (card.dataset.title.includes(q)) {
                            card.style.display = '';
                            visible++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    favCount.textContent = visible;
                    if (visible === 0) {
                        favList.innerHTML += `<div class="empty-fav col-span-full">Tidak ditemukan anime favorit dengan kata kunci tersebut.</div>`;
                    } else {
                        const empty = favList.querySelector('.empty-fav');
                        if (empty) empty.remove();
                    }
                });
            }

            // Remove from favorite (AJAX)
            if (favList) {
                favList.addEventListener('click', function(e) {
                    const btn = e.target.closest('.remove-fav-btn');
                    if (!btn) return;
                    const malId = btn.dataset.mal;
                    if (!confirm('Yakin ingin menghapus anime ini dari favorit?')) return;

                    btn.disabled = true;
                    btn.innerHTML =
                        `<svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>`;

                    fetch(`/anime/${malId}/favorite`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({})
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success' && data.action === 'removed') {
                                const card = btn.closest('.anime-card');
                                card.classList.add('opacity-50', 'scale-95');
                                setTimeout(() => {
                                    card.remove();
                                    favCount.textContent = favList.querySelectorAll('.anime-card').length;
                                    showToast('Anime dihapus dari favorit.');
                                    if (favList.querySelectorAll('.anime-card').length === 0) {
                                        favList.innerHTML = `<div class="empty-fav col-span-full">Belum ada anime favorit.<br>Tambahkan anime ke favoritmu dari halaman detail anime!</div>`;
                                    }
                                }, 350);
                            } else {
                                btn.disabled = false;
                                btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
                                showToast('Gagal menghapus anime dari favorit.', true);
                            }
                        })
                        .catch(() => {
                            btn.disabled = false;
                            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
                            showToast('Terjadi kesalahan koneksi.', true);
                        });
                });
            }

            // Toast feedback
            function showToast(msg, error = false) {
                toast.textContent = msg;
                toast.style.background = error ? '#ef4444' : '#23243a';
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2000);
            }
        });
    </script>
@endpush
