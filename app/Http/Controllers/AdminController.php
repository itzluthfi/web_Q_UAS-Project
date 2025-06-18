<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\AnimeDetail;
use App\Models\Category;
use App\Models\AnimeSyncLog;
use App\Models\Comment;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{

    // === SHOW PAGE ===
    // Tampilkan semua user
    public function users()
    {
        // Ambil 10 user per halaman
        $users = User::paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function profile()
    {
        $user = Auth::user();
        // dd($user);
        $my_comments = Comment::where('user_id', $user->id);
        $jml_komentar = $my_comments->count();
        return view('auth.profile', compact('user', 'jml_komentar', 'my_comments'));
    }

    public function setting()
    {
        $users = User::all();
        return view('auth.setting', compact('users'));
    }

    // Tampilkan dashboard admin
    public function dashboard()
    {
        $users = User::all(); // atau data lainnya
        return view('auth.dashboard', compact('users'));
    }

    public function comment()
    {
        // Gunakan paginate() untuk mengaktifkan pagination
        $comments = Comment::with(['user', 'anime'])->paginate(10); // Tampilkan 10 komentar per halaman

        return view('admin.comment', compact('comments'));
    }
    public function syncAnimePage()
    {
        // $comments = Comment::all();
        return view('admin.sinkronisasi');
    }


    // === ACTIONS ===
    // Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    public function syncAnime(Request $request)
    {
        // Validasi input dari user
        $validated = $request->validate([
            'category' => 'required|string|in:all,top,popular,upcoming,current-season',
            'limit'    => 'nullable|integer|min:1', // Tidak dibatasi maksimum
        ]);

        $selectedCategory = $validated['category'];
        $totalAnimeToSync = $validated['limit'] ?? 25;

        // Daftar semua kategori yang tersedia dan URL API-nya
        $availableCategories = [
            'top'            => 'https://api.jikan.moe/v4/top/anime',
            'popular'        => 'https://api.jikan.moe/v4/anime',
            'upcoming'       => 'https://api.jikan.moe/v4/seasons/upcoming',
            'current-season' => 'https://api.jikan.moe/v4/seasons/now',
        ];

        // Jika "all", ambil semua kategori. Jika tidak, hanya kategori yang diminta
        $categoriesToSync = $selectedCategory === 'all'
            ? array_keys($availableCategories)
            : [$selectedCategory];


        // Hitung jumlah anime per kategori secara merata
        $animePerCategory = (int) ceil($totalAnimeToSync / count($categoriesToSync));
        $totalSyncedAnime = 0;

        // dd($animePerCategory, $categoriesToSync);

        foreach ($categoriesToSync as $category) {
            $categoryUrl = $availableCategories[$category] ?? $availableCategories['top'];
            $pagesToFetch = (int) ceil($animePerCategory / 25);
            $currentPage = 1;
            $syncedInThisCategory = 0;

            // Simpan atau temukan kategori di database
            $categoryModel = Category::firstOrCreate(['name' => $category]);

            while ($currentPage <= $pagesToFetch) {
                $response = Http::timeout(20)->retry(3, 500)->get($categoryUrl, [
                    'page' => $currentPage
                ]);
                // Dump response body untuk cek
                // return $response->body();
                // Kalau gagal request langsung stop dan kembalikan pesan error
                if (!$response->ok()) {
                    return back()->with('error', "Gagal mengambil data dari API halaman $currentPage. Sinkronisasi dihentikan.");
                }

                // Pastikan data ada dan valid, kalau gak ada atau bukan array juga stop
                if (!isset($response['data']) || !is_array($response['data'])) {
                    return back()->with('error', "Data dari API halaman $currentPage tidak valid. Sinkronisasi dihentikan.");
                }

                $animeList = $response['data'];

                foreach ($animeList as $animeData) {
                    // Simpan anime utama
                    $animeModel = Anime::updateOrCreate(
                        ['mal_id' => $animeData['mal_id']],
                        [
                            'title'         => $animeData['title'],
                            'title_english' => $animeData['title_english'] ?? null,
                            'synopsis'      => $animeData['synopsis'] ?? null,
                            'type'          => $animeData['type'],
                            'episodes'      => $animeData['episodes'],
                            'duration'      => $animeData['duration'],
                            'category'      => $category,
                            'score'         => $animeData['score'],
                            'rank'          => $animeData['rank'],
                            'popularity'    => $animeData['popularity'],
                            'status'        => $animeData['status'],
                            'season'        => $animeData['season'] ?? null,
                            'year'          => $animeData['year'] ?? null,
                            'image_url'     => $animeData['images']['jpg']['image_url'] ?? null,
                            'large_image_url' => $animeData['images']['jpg']['large_image_url'] ?? null,
                            'aired_from'    => $animeData['aired']['from'] ?? null,
                            'aired_to'      => $animeData['aired']['to'] ?? null,
                        ]
                    );

                    // Relasi genre
                    foreach ($animeData['genres'] as $genreData) {
                        $genre = Genre::updateOrCreate(
                            ['mal_id' => $genreData['mal_id']],
                            ['name' => $genreData['name']]
                        );
                        $animeModel->genres()->syncWithoutDetaching([$genre->id]);
                    }

                    // Ambil detail tambahan dari endpoint detail
                    $detailResponse = Http::timeout(20)->retry(3, 500)->get("https://api.jikan.moe/v4/anime/{$animeData['mal_id']}");
                    // dd($detailResponse);

                    if ($detailResponse->ok()) {
                        $detailData = $detailResponse['data'];
                        AnimeDetail::updateOrCreate(
                            ['anime_id' => $animeModel->id],
                            [
                                'source'       => $detailData['source'] ?? null,
                                'rating'       => $detailData['rating'] ?? null,
                                'trailer_url'  => $detailData['trailer']['url'] ?? null,
                                'scored_by'    => $detailData['scored_by'] ?? null,
                                'popularity'   => $detailData['popularity'] ?? null,
                                'members'      => $detailData['members'] ?? null,
                                'favorites'    => $detailData['favorites'] ?? null,
                                'background'   => $detailData['background'] ?? null,
                            ]
                        );
                    }

                    // Tambahkan relasi kategori
                    $animeModel->categories()->syncWithoutDetaching([$categoryModel->id]);

                    $syncedInThisCategory++;
                    $totalSyncedAnime++;

                    // Hentikan jika sudah memenuhi kuota per kategori
                    if ($syncedInThisCategory >= $animePerCategory) {
                        break 2;
                    }
                }

                $currentPage++;
            }

            // Log per kategori
            AnimeSyncLog::create([
                'category'      => $category,
                'limit_data'    => $animePerCategory,
                'pages_fetched' => $pagesToFetch,
                'anime_synced'  => $syncedInThisCategory,
                'synced_at'     => now(),
            ]);
        }

        return back()->with('success', "Sinkronisasi anime selesai. Total data disinkron: $totalSyncedAnime");
    }
}
