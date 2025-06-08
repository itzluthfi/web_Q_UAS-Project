@extends('layouts.dashboard')

@section('title', 'Sinkronisasi Anime')

@push('styles')
    <style>
        .sync-container {
            background: linear-gradient(145deg, #161921, #13151c);
            border: 1px solid rgba(101, 31, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(101, 31, 255, 0.1);
        }

        .sync-header {
            background: rgba(101, 31, 255, 0.1);
            border-bottom: 1px solid rgba(101, 31, 255, 0.2);
        }

        .sync-title {
            background: linear-gradient(90deg, #fff, #d6c5ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .sync-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, rgba(101, 31, 255, 0.8), rgba(101, 31, 255, 0.3));
            border-radius: 3px;
        }

        .form-label {
            color: #d6c5ff;
            font-weight: 500;
        }

        .form-select {
            background-color: rgba(30, 32, 40, 0.8);
            border: 1px solid rgba(101, 31, 255, 0.3);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: rgba(101, 31, 255, 0.8);
            box-shadow: 0 0 0 2px rgba(101, 31, 255, 0.2);
        }

        .form-select option {
            background-color: #1e2028;
        }

        .sync-btn {
            background: linear-gradient(135deg, rgba(101, 31, 255, 0.8), rgba(86, 24, 220, 0.9));
            border: none;
            box-shadow: 0 4px 12px rgba(101, 31, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sync-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(101, 31, 255, 0.4);
        }

        .sync-btn:active {
            transform: translateY(0);
        }

        .sync-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .sync-btn:hover::after {
            left: 100%;
        }

        .sync-icon {
            display: inline-block;
            margin-right: 8px;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .rotating {
            animation: rotate 1.5s linear infinite;
        }

        .status-card {
            border-left: 4px solid;
            background-color: rgba(30, 32, 40, 0.6);
        }

        .status-success {
            border-color: #10b981;
        }

        .status-error {
            border-color: #ef4444;
        }

        .sync-stats {
            background: rgba(30, 32, 40, 0.6);
            border: 1px solid rgba(101, 31, 255, 0.2);
        }

        .stat-item {
            border-right: 1px solid rgba(101, 31, 255, 0.1);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-value {
            color: #d6c5ff;
            font-weight: 600;
        }

        .sync-history {
            max-height: 200px;
            overflow-y: auto;
        }

        .sync-history::-webkit-scrollbar {
            width: 6px;
        }

        .sync-history::-webkit-scrollbar-track {
            background: rgba(30, 32, 40, 0.6);
        }

        .sync-history::-webkit-scrollbar-thumb {
            background: rgba(101, 31, 255, 0.4);
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
    <div class="sync-container p-0 rounded-2xl overflow-hidden">
        <!-- Header Section -->
        <div class="sync-header p-6 mb-6">
            <div class="flex items-center justify-between">
                <h1 class="sync-title text-2xl font-bold">Sinkronisasi Anime</h1>
                <div class="text-sm text-gray-400">
                    <span>Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 pt-0">
            <!-- Stats Overview -->
            <div class="sync-stats grid grid-cols-4 gap-4 p-4 rounded-xl mb-6">
                <div class="stat-item p-3 text-center">
                    <div class="text-xs uppercase tracking-wider text-gray-400">Total Anime</div>
                    <div class="stat-value text-xl mt-1">2,458</div>
                </div>
                <div class="stat-item p-3 text-center">
                    <div class="text-xs uppercase tracking-wider text-gray-400">Terakhir Sync</div>
                    <div class="stat-value text-xl mt-1">2 jam lalu</div>
                </div>
                <div class="stat-item p-3 text-center">
                    <div class="text-xs uppercase tracking-wider text-gray-400">Ditambahkan Hari Ini</div>
                    <div class="stat-value text-xl mt-1">24</div>
                </div>
                <div class="stat-item p-3 text-center">
                    <div class="text-xs uppercase tracking-wider text-gray-400">Status API</div>
                    <div class="stat-value text-xl mt-1 flex items-center justify-center">
                        <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                        Online
                    </div>
                </div>
            </div>

            <!-- Sync Form -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <form action="{{ route('admin.syncAnime') }}" method="POST" class="space-y-6" id="syncForm">
                        @csrf
                        <div class="space-y-2">
                            <label for="category" class="form-label block text-sm">Pilih Kategori Sinkronisasi:</label>
                            <select name="category" id="category" class="form-select w-full p-3 rounded-xl text-sm">
                                <option value="top">Top Anime</option>
                                <option value="popular">Popular Anime</option>
                                <option value="upcoming">Upcoming Anime</option>
                                <option value="current-season">Current Season Anime</option>
                                <option value="all">Semua Kategori</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="limit" class="form-label block text-sm">Jumlah Data:</label>
                            <select name="limit" id="limit" class="form-select w-full p-3 rounded-xl text-sm">
                                <option value="25">25 Anime</option>
                                <option value="50">50 Anime</option>
                                <option value="100">100 Anime</option>
                                <option value="250">250 Anime</option>
                                <option value="500">500 Anime</option>
                                <option value="1000">1000 Anime</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="form-label block text-sm">Opsi Tambahan:</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="update_existing" name="update_existing"
                                        class="rounded bg-transparent border-gray-600 text-purple-600 focus:ring-purple-500">
                                    <label for="update_existing" class="ml-2 text-sm text-gray-300">Update yang sudah
                                        ada</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="force_sync" name="force_sync"
                                        class="rounded bg-transparent border-gray-600 text-purple-600 focus:ring-purple-500">
                                    <label for="force_sync" class="ml-2 text-sm text-gray-300">Paksa sinkronisasi</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="sync-btn w-full py-3 px-6 text-white font-medium rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="sync-icon h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Sinkronkan Sekarang
                        </button>
                    </form>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-opacity-20 bg-gray-800 p-4 rounded-xl">
                        <h3 class="text-sm font-medium text-gray-300 mb-3">Riwayat Sinkronisasi</h3>
                        <div class="sync-history space-y-3">
                            <div class="p-3 bg-opacity-30 bg-gray-800 rounded-lg text-xs">
                                <div class="flex justify-between text-gray-400">
                                    <span>Top Anime</span>
                                    <span>2 jam lalu</span>
                                </div>
                                <div class="mt-1 text-green-400">Berhasil - 50 anime</div>
                            </div>
                            <div class="p-3 bg-opacity-30 bg-gray-800 rounded-lg text-xs">
                                <div class="flex justify-between text-gray-400">
                                    <span>Current Season</span>
                                    <span>5 jam lalu</span>
                                </div>
                                <div class="mt-1 text-green-400">Berhasil - 25 anime</div>
                            </div>
                            <div class="p-3 bg-opacity-30 bg-gray-800 rounded-lg text-xs">
                                <div class="flex justify-between text-gray-400">
                                    <span>Upcoming</span>
                                    <span>1 hari lalu</span>
                                </div>
                                <div class="mt-1 text-red-400">Gagal - API error</div>
                            </div>
                            <div class="p-3 bg-opacity-30 bg-gray-800 rounded-lg text-xs">
                                <div class="flex justify-between text-gray-400">
                                    <span>Popular</span>
                                    <span>1 hari lalu</span>
                                </div>
                                <div class="mt-1 text-green-400">Berhasil - 100 anime</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Messages -->
            @if (session('success'))
                <div class="status-card status-success mt-6 p-4 rounded-lg flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-green-500">Sinkronisasi Berhasil</h4>
                        <p class="text-sm text-gray-300 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="status-card status-error mt-6 p-4 rounded-lg flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-3 mt-0.5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-red-500">Sinkronisasi Gagal</h4>
                        <p class="text-sm text-gray-300 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add a loading state to the sync button when clicked
        document.addEventListener('DOMContentLoaded', function() {
            const syncForm = document.querySelector('#syncform');
            const syncBtn = syncForm.querySelector('button[type="submit"]');
            const syncIcon = syncBtn.querySelector('.sync-icon');

            syncForm.addEventListener('submit', function() {
                console.log('sedang sinkronisasi...');
                syncBtn.disabled = true;
                syncBtn.classList.add('opacity-75');
                syncIcon.classList.add('rotating');
                syncBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="sync-icon rotating h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Sedang Sinkronisasi...
            `;
            });
        });
    </script>
@endpush
