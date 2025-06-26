@extends('layouts.dashboard')

@section('title', 'Manage Comments - MyAnimeList Admin')
@push('styles')
    <style>
        Table styling .admin-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table th {
            background-color: #1f2937;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .admin-table tr {
            transition: all 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }

        /* Modal animation */
        .modal {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .modal.hidden {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }

        .modal.show {
            opacity: 1;
            transform: scale(1);
            pointer-events: auto;
            display: flex !important;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(17, 24, 39, 0.75);
            z-index: 40;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <main class="p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="dashboard-card p-4 flex items-center">
                <div class="rounded-full bg-purple-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Komentar</p>
                    <h3 class="text-2xl font-bold text-white">{{ $comments->total() }}</h3>

                </div>
            </div>

            <div class="dashboard-card p-4 flex items-center">
                <div class="rounded-full bg-blue-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Komentar Hari Ini</p>
                    <h3 class="text-2xl font-bold text-white">{{ $todayComments }}</h3>

                </div>
            </div>

            <div class="dashboard-card p-4 flex items-center">
                <div class="rounded-full bg-pink-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Komentar Balasan</p>
                    <h3 class="text-2xl font-bold text-white">{{ $jmlCommentReply }}</h3>

                </div>
            </div>
        </div>

        <!-- Comments Section -->
        {{-- @dd($comments); --}}
        <div class="dashboard-card p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-purple-400">Kelola Komentar</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" placeholder="Cari komentar..." class="input-dark rounded-md pl-10 pr-4 py-2 w-64">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <select class="input-dark rounded-md px-4 py-2">
                        <option value="all">Semua Komentar</option>
                        <option value="anime">Anime</option>
                        <option value="manga">Manga</option>
                        <option value="reported">Dilaporkan</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="admin-table w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Komentar</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Konten</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-8 py-3 text-right text-xs text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        {{-- @dd($comments); --}}
                        @foreach ($comments as $comment)
                            <tr id="comment-row-{{ $comment->id }}">
                                <!-- Username -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">
                                                {{ strtoupper(substr($comment->user->username ?? 'User', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-medium text-white">
                                            {{ $comment->user->username ?? 'Anonymous' }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Isi Komentar -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-300 comment-text" id="comment-text-{{ $comment->id }}">
                                        {{ $comment->content }}
                                    </p>
                                </td>

                                <!-- Judul Anime -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-anime">
                                        {{ $comment->anime->title ?? 'Unknown Title' }}
                                    </span>
                                </td>

                                <!-- Tanggal -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') }}
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="/anime/show/{{ $comment->anime_id }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-150" title="Lihat Komentar" aria-label="Lihat Komentar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <button onclick="openEditModal('{{ $comment->id }}', event)" class="text-purple-400 hover:text-purple-300 transition-colors duration-150" title="Edit Komentar" aria-label="Edit Komentar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button onclick="confirmDelete('{{ $comment->id }}', event)" class="text-red-400 hover:text-red-300 transition-colors duration-150" title="Hapus Komentar" aria-label="Hapus Komentar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $comments->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </main>
@endsection

    <script type="application/json" id="comment-data">
        {
            @foreach ($comments as $comment)
                "{{ $comment->id }}": {
                    "username": "{{ addslashes($comment->user->username ?? 'Anonymous') }}",
                    "content": "{{ addslashes($comment->anime->title ?? 'Unknown Title') }}",
                    "comment": "{{ addslashes($comment->content) }}"
                }@if (!$loop->last),@endif
            @endforeach
        }
    </script>


        <!-- Edit Comment Modal -->

        <!-- Modal Container -->
        <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center">
            <!-- Backdrop -->
            <div class="modal-backdrop absolute inset-0 bg-black bg-opacity-70" onclick="closeEditModal()"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-lg mx-4 z-50 bg-gray-800 rounded-lg shadow-xl">
                <form id="editCommentForm" method="POST" action="{{ route('comment.update', $comment->id) }}" class="w-full">
                    @csrf
                    {{-- @method('PUT') --}}

                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Edit Komentar</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="edit-username" class="block text-sm font-medium text-gray-300">Pengguna</label>
                                        <input type="text" id="edit-username" class="mt-1 input-dark w-full rounded-md" disabled>
                                    </div>
                                    <div>
                                        <label for="edit-content-type" class="block text-sm font-medium text-gray-300">Konten</label>
                                        <input type="text" id="edit-content-type" class="mt-1 input-dark w-full rounded-md" disabled>
                                    </div>
                                    <div>
                                        <label for="edit-comment" class="block text-sm font-medium text-gray-300">Komentar</label>
                                        <textarea name="content" id="edit-comment" rows="4" class="mt-1 input-dark w-full rounded-md"></textarea>
                                    </div>
                                    <input type="hidden" name="id" id="edit-comment-id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

    <!-- Modal Container - Centered -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <!-- Modal Panel -->
        <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-lg w-full mx-auto">
            <!-- Modal Content -->
            <div class="px-6 pt-6 pb-4">
                <div class="flex items-center justify-center mb-4">
                    <!-- Warning Icon -->
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <!-- Modal Title and Description - Centered -->
                <div class="text-center">
                    <h3 class="text-lg font-medium text-white mb-2">
                        Hapus Komentar
                    </h3>
                    <p class="text-sm text-gray-300">
                        Apakah Anda yakin ingin menghapus komentar ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <!-- Modal Actions - Centered -->
            <div class="bg-gray-900 px-6 py-4 flex justify-center space-x-3">
                <button type="button" onclick="deleteComment()"
                    class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-2 bg-red-600 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Hapus
                </button>
                <button type="button" onclick="closeDeleteModal()"
                    class="inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-6 py-2 bg-gray-800 text-sm font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal & state
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');
            let currentCommentId = null;

            // Ambil data komentar dari script tag
            let commentData = {};
            try {
                const commentDataEl = document.getElementById('comment-data');
                if (commentDataEl) {
                    commentData = JSON.parse(commentDataEl.textContent);
                }
            } catch (error) {
                console.error("Error parsing comment data:", error);
            }

            // Modal helpers
            function openModal(modal) {
                modal.classList.remove('hidden');
                modal.classList.add('show');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modal) {
                modal.classList.add('hidden');
                modal.classList.remove('show');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }

            // Edit Modal
            window.openEditModal = function(commentId, event) {
                if (event) event.stopPropagation();
                const comment = commentData[commentId];
                if (!comment) return;

                document.getElementById('edit-username').value = comment.username || '';
                document.getElementById('edit-content-type').value = comment.content || '';
                document.getElementById('edit-comment').value = comment.comment || '';
                document.getElementById('edit-comment-id').value = commentId;

                // Update action form agar sesuai comment ID
                const form = document.getElementById('editModal');
                form.action = `/anime/comment/update/${commentId}`;

                openModal(editModal);
            };

            

            window.saveComment = async function () {
                const commentId = document.getElementById('edit-comment-id').value;
                const newComment = document.getElementById('edit-comment').value;

                if (!commentId || !newComment.trim()) {
                    alert("Harap isi komentar!");
                    return;
                }

                try {
                    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfTokenElement) {
                        throw new Error("CSRF Token tidak ditemukan");
                    }
                    const csrfToken = csrfTokenElement.getAttribute('content');

                    const response = await fetch(`/anime/comment/update/${commentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ content: newComment })
                    });

                    // Cek status HTTP
                    if (!response.ok) {
                        throw new Error(`Server merespons dengan status: ${response.status}`);
                    }

                    // Cek apakah respons adalah JSON
                    const contentType = response.headers.get("content-type");
                    if (!contentType || !contentType.includes("application/json")) {
                        const text = await response.text();
                        console.error("Respons bukan JSON:", text);
                        throw new Error("Server tidak mengembalikan data dalam format JSON.");
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Update cache lokal dan DOM
                        if (commentData[commentId]) {
                            commentData[commentId].comment = newComment;
                        }
                        const commentTextElement = document.getElementById(`comment-text-${commentId}`);
                        if (commentTextElement) {
                            commentTextElement.textContent = newComment;
                        }

                        closeModal(editModal);
                        showNotification("Komentar berhasil diperbarui!", "success");
                    } else {
                        showNotification(data.message || "Gagal memperbarui komentar.", "error");
                    }

                } catch (err) {
                    console.error("Error saat menyimpan komentar:", err);
                    showNotification("Terjadi kesalahan saat menyimpan komentar.", "error");
                }
            };

            // Delete Modal
            window.confirmDelete = function(commentId, event) {
                if (event) event.stopPropagation();
                currentCommentId = commentId;
                openModal(deleteModal);
            };
            window.closeDeleteModal = function() {
                closeModal(deleteModal);
                currentCommentId = null;
            };

            window.deleteComment = function() {
                if (!currentCommentId) return;
                fetch(`/anime/comment/delete/${currentCommentId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const commentRow = document.getElementById(`comment-row-${currentCommentId}`);
                            if (commentRow) commentRow.style.display = 'none';
                            if (commentData[currentCommentId]) delete commentData[currentCommentId];
                            closeModal(deleteModal);
                            showNotification('Komentar berhasil dihapus!', 'success');
                        } else {
                            showNotification(data.message || 'Gagal menghapus komentar!', 'error');
                        }
                    })
                    .catch(() => {
                        showNotification('Terjadi kesalahan!', 'error');
                    });
            };

            // Notification
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 ${
            type === 'success' ? 'bg-green-600' : 
            type === 'error' ? 'bg-red-600' : 
            'bg-blue-600'
        }`;
                notification.textContent = message;
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Modal close on backdrop click
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                backdrop.addEventListener('click', function() {
                    if (editModal.classList.contains('show')) closeModal(editModal);
                    if (deleteModal.classList.contains('show')) closeModal(deleteModal);
                });
            });

            // Modal close on ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (editModal.classList.contains('show')) closeModal(editModal);
                    if (deleteModal.classList.contains('show')) closeModal(deleteModal);
                }
            });
        });

        function closeEditModal() {
                console.log('🔄 Menutup modal edit...');

                const modal = document.getElementById('editModal');
                if (!modal) {
                    console.error('❌ Elemen modal tidak ditemukan!');
                    return;
                }

                // 1. Tambahkan class 'hidden'
                modal.classList.add('hidden');

                // 2. Reset display (opsional untuk tambahan)
                modal.style.display = 'none';

                // 3. Reset form jika ada
                const form = document.getElementById('editCommentForm');
                if (form && typeof form.reset === 'function') {
                    form.reset();
                    console.log('🗑️ Form berhasil direset.');
                }

                // 4. Reset backdrop opacity (jika ada)
                const backdrop = modal.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.opacity = '0';
                    console.log('🔲 Backdrop opacity direset.');
                }

                // 5. Kembalikan overflow body
                document.body.style.overflow = '';

                console.log('✅ Modal berhasil ditutup.');
            }
    </script>
@endpush
