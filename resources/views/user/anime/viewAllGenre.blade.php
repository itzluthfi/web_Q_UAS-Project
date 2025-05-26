@extends('layouts.app')

@section('title', 'Genres - AnimeVerse')

@push('styles')
<style>
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

::-webkit-scrollbar {
    width: 6px;
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

.genre-list-item {
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.genre-list-item:hover {
    border-left-color: #651fff;
    background-color: rgba(101, 31, 255, 0.1);
    transform: translateX(5px);
}

.genre-badge {
    background: linear-gradient(135deg, #651fff, #a36bff);
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.page-title {
    background: linear-gradient(90deg, #651fff, #a36bff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: inline-block;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.view-btn {
    background: linear-gradient(135deg, #651fff, #7c4dff);
    border: none;
    border-radius: 0.375rem;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    text-align: center;
    display: inline-block;
}

.view-btn:hover {
    background: linear-gradient(135deg, #7c4dff, #651fff);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(101, 31, 255, 0.4);
}
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="flex items-center justify-center mb-8">
        <h1 class="page-title text-2xl md:text-3xl">Daftar Genre Anime</h1>
    </div>

    <!-- Alert Message -->
    @if(session('error_message'))
        <div class="p-3 bg-red-900/50 border-l-4 border-red-500 text-red-200 flex items-center rounded-r mb-6 max-w-2xl mx-auto">
            <span>{{ session('error_message') }}</span>
        </div>
    @endif

    <!-- Genre List -->
    @if(!empty($genres))
        <div class="bg-gray-800/50 rounded-lg overflow-hidden shadow-lg border border-gray-700/50 divide-y divide-gray-700/50">
            @foreach($genres as $genre)
                <div class="genre-list-item p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <h3 class="text-lg font-medium text-white">{{ $genre['name'] }}</h3>
                        <div class="genre-badge ml-3">
                            {{ $genre['count'] ?? '0' }} Anime
                        </div>
                    </div>
                    <a href="{{ route('anime.showByGenre', ['id' => $genre['mal_id']]) }}" class="view-btn">
                        Lihat Anime
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-6 text-center max-w-md mx-auto">
            <p class="text-gray-400">Tidak ada genre ditemukan.</p>
        </div>
    @endif
</div>
@endsection