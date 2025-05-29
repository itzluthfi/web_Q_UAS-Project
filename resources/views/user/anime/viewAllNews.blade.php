@extends('layouts.app')

@section('title', 'Anime News')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Banner --}}
    <div class="relative bg-cover bg-center h-56 rounded-xl mb-10" style="background-image: url('https://wallpaperaccess.com/full/2076081.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white rounded-xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2">Latest Anime News</h1>
                <p class="text-sm text-gray-200">Discover the most recent events and announcements in the anime world.</p>
            </div>
        </div>
    </div>

    {{-- News Grid --}}
    @if (count($news) > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($news as $item)
                <div class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition-shadow rounded-xl overflow-hidden group">
                    
                    {{-- Image Thumbnail --}}
                    @if(isset($item['images']['jpg']['image_url']))
                        <img src="{{ $item['images']['jpg']['image_url'] }}" alt="News Image" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="p-4 flex flex-col h-full justify-between">
                        <div>
                            {{-- Title --}}
                            <h2 class="text-lg font-bold mb-2 line-clamp-2">
                                <a href="{{ $item['url'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $item['title'] }}
                                </a>
                            </h2>

                            {{-- From Anime --}}
                            @if(isset($item['anime']['title']))
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                    <span class="font-medium">From:</span> {{ $item['anime']['title'] }}
                                </p>
                            @endif

                            {{-- Excerpt --}}
                            <p class="text-gray-700 dark:text-gray-200 text-sm mb-3 line-clamp-3">
                                {{ $item['excerpt'] }}
                            </p>
                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($item['date'])->diffForHumans() }}
                            </span>
                            <a href="{{ $item['url'] }}" target="_blank" class="text-sm text-indigo-600 hover:underline font-medium">
                                Read more →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600 dark:text-gray-300">No news available.</p>
    @endif
</div>
@endsection
