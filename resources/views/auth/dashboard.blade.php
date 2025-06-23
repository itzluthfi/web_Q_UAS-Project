@extends('layouts.dashboard')

@section('title', 'Dashboard - AnimeVerse')
@section('page-header', 'Dashboard - AnimeVerse') {{-- Ini akan masuk ke navbar --}}
@push('styles')
@endpush




@section('content')
    <!-- Main Content -->
    @include('components.dashboardContent')
@endsection
</div>

<!-- Edit User Modal -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Edit Pengguna
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="edit-username" class="block text-sm font-medium text-gray-300">Username</label>
                                <input type="text" id="edit-username" class="mt-1 input-dark w-full rounded-md">
                            </div>
                            <div>
                                <label for="edit-email" class="block text-sm font-medium text-gray-300">Email</label>
                                <input type="email" id="edit-email" class="mt-1 input-dark w-full rounded-md">
                            </div>
                            <div>
                                <label for="edit-role" class="block text-sm font-medium text-gray-300">Peran</label>
                                <select id="edit-role" class="mt-1 input-dark w-full rounded-md">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div>
                                <label for="edit-status" class="block text-sm font-medium text-gray-300">Status</label>
                                <select id="edit-status" class="mt-1 input-dark w-full rounded-md">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                    <option value="banned">Diblokir</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditModal()"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
