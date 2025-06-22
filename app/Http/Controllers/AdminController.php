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
use Carbon\Carbon;
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
        $todayComments = Comment::whereDate('created_at', Carbon::today())->count();
        $jmlCommentReply = Comment::whereNotNull('parent_id')->count();
        return view('admin.comment', compact('comments', 'todayComments', 'jmlCommentReply'));
    }
    public function syncAnimePage()
    {
        $jmlAnime = Anime::count();
        $lastSync = AnimeSyncLog::latest()->first();
        $historySync = AnimeSyncLog::orderBy('created_at', 'desc')->get();
        // Set locale ke Indonesia
        Carbon::setLocale('id');
        $lastSyncTime = $lastSync ? Carbon::parse($lastSync->created_at)->diffForHumans() : 'Belum Ada Sinkronisasi';
        // dd($lastSync, $jmlAnime, $historySync);
        $todaySynced = Anime::whereDate('created_at', Carbon::today())->count();
        return view('admin.sinkronisasi', compact('jmlAnime', 'lastSync', 'historySync', 'lastSyncTime', 'todaySynced'));
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
        $validated = $request->validate([
            'category' => 'required|string|in:all,top,popular,upcoming,current-season',
            'limit'    => 'nullable|integer|min:1',
        ]);

        $selectedCategory = $validated['category'];
        $totalAnimeToSync = $validated['limit'] ?? 25;

        $availableCategories = [
            'top'            => 'https://api.jikan.moe/v4/top/anime',
            'popular'        => 'https://api.jikan.moe/v4/anime',
            'upcoming'       => 'https://api.jikan.moe/v4/seasons/upcoming',
            'current-season' => 'https://api.jikan.moe/v4/seasons/now',
        ];

        $categoriesToSync = $selectedCategory === 'all'
            ? array_keys($availableCategories)
            : [$selectedCategory];

        $animePerCategory = (int) ceil($totalAnimeToSync / count($categoriesToSync));
        $totalSyncedAnime = 0;

        foreach ($categoriesToSync as $category) {
            $categoryUrl = $availableCategories[$category] ?? $availableCategories['top'];
            $pagesToFetch = (int) ceil($animePerCategory / 25);
            $currentPage = 1;
            $syncedInThisCategory = 0;
            $status = 'berhasil';
            $logMessage = null;

            $categoryModel = Category::firstOrCreate(['name' => $category]);

            try {
                while ($currentPage <= $pagesToFetch) {
                    $response = Http::timeout(20)->retry(3, 500)->get($categoryUrl, [
                        'page' => $currentPage
                    ]);

                    if (!$response->ok()) {
                        $status = 'gagal';
                        $logMessage = "Gagal mengambil data dari API halaman $currentPage.";
                        break;
                    }

                    if (!isset($response['data']) || !is_array($response['data'])) {
                        $status = 'gagal';
                        $logMessage = "Data dari API halaman $currentPage tidak valid.";
                        break;
                    }

                    $animeList = $response['data'];

                    foreach ($animeList as $animeData) {
                        $animeModel = Anime::updateOrCreate(
                            ['mal_id' => $animeData['mal_id']],
                            [
                                'title'         => $animeData['title'],
                                'title_english' => $animeData['title_english'] ?? null,
                                'synopsis'      => $animeData['synopsis'] ?? null,
                                'type'          => $animeData['type'],
                                'episodes'      => $animeData['episodes'],
                                'duration'      => $animeData['duration'],
                                'url'           => $animeData['url'],
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

                        foreach ($animeData['genres'] as $genreData) {
                            $genre = Genre::updateOrCreate(
                                ['mal_id' => $genreData['mal_id']],
                                ['name' => $genreData['name']]
                            );
                            $animeModel->genres()->syncWithoutDetaching([$genre->id]);
                        }

                        // Detail tambahan
                        $detailResponse = Http::timeout(20)->retry(3, 500)->get("https://api.jikan.moe/v4/anime/{$animeData['mal_id']}");
                        if ($detailResponse->ok()) {
                            $detailData = $detailResponse['data'];
                            AnimeDetail::updateOrCreate(
                                ['anime_id' => $animeModel->id],
                                [
                                    'source'       => $detailData['source'] ?? null,
                                    'rating'       => $detailData['rating'] ?? null,
                                    'trailer_url'  => $detailData['trailer']['url'] ?? null,
                                    'trailer_embed_url'  => $detailData['trailer']['embed_url'] ?? null,
                                    'scored_by'    => $detailData['scored_by'] ?? null,
                                    'popularity'   => $detailData['popularity'] ?? null,
                                    'members'      => $detailData['members'] ?? null,
                                    'favorites'    => $detailData['favorites'] ?? null,
                                    'background'   => $detailData['background'] ?? null,
                                ]
                            );
                        }

                        $animeModel->categories()->syncWithoutDetaching([$categoryModel->id]);

                        $syncedInThisCategory++;
                        $totalSyncedAnime++;

                        if ($syncedInThisCategory >= $animePerCategory) {
                            break 2;
                        }
                    }

                    $currentPage++;
                }
            } catch (\Exception $e) {
                $status = 'gagal';
                $logMessage = $e->getMessage();
            }
            // Jika ada error, set status gagal
            if ($status === 'gagal' && !$logMessage) {
                $logMessage = "Terjadi kesalahan saat sinkronisasi kategori $category.";
            }
            // Jika berhasil, set status berhasil
            if ($status === 'berhasil' && !$logMessage) {
                $logMessage = "Sinkronisasi kategori $category berhasil.";
            }
            // dd($status, $logMessage);

            // Log per kategori
            AnimeSyncLog::create([
                'category'      => $category,
                'limit_data'    => $animePerCategory,
                'pages_fetched' => $pagesToFetch,
                'anime_synced'  => $syncedInThisCategory,
                'status'        => $status,
                'keterangan'    => $logMessage,
                'synced_at'     => now(),
            ]);

            // Jika gagal, hentikan proses dan tampilkan pesan error
            if ($status === 'gagal') {
                return back()->with('error', "Sinkronisasi kategori $category gagal: $logMessage");
            }
        }

        return back()->with('success', "Sinkronisasi anime selesai. Total data disinkron: $totalSyncedAnime");
    }
}
