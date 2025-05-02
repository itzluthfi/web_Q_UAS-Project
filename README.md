# Kelompok 6 , Pemrograman Web Q -ITATS

Anggota:
Muhammad Brillian Alif 06.2023.1.07663
Kuthfi Shidqi Habibulloh 06.2023.1.07702

# Judul:

“MAL (My Anime List) Website Rekomendasi Anime”

# Deskripsi:

My Anime List (MAL) adalah platform digital inovatif yang dirancang untuk memenuhi kebutuhan komunitas penggemar anime dalam mengelola, mengeksplorasi, dan berinteraksi dengan konten anime secara efisien. Dengan antarmuka yang ramah pengguna dan fitur yang komprehensif, MAL bertujuan menjadi solusi terpadu bagi penggemar anime, memberikan ulasan,saling ber interaksi serta menemukan rekomendasi anime baru berdasarkan preferensi pribadi atau tren komunitas.

# Fitur Website:

- Users dapat melakukan Login dan Register.
- Users dapat berkomentar dan saling reply
- Users dapat menandai anime favorite
- Users dapat menonton trailer anime
- Users dapat melakukan pencarian dan filter genre anime

- Admin dapat manage users
- Admin dapat manage Komentar

# Teknologi:

- HTML5, CSS, Javascript
- Tailwind untuk frontend
- PHP untuk backend
- MYSQL untuk pengelolaan database
- API jikan (api gratis untuk data anime)

## Langkah Instalasi:

1. Clone Repository
   git clone https://github.com/itzluthfi/web_Q_UAS-Project.git
   cd anime-list
2. Pindahkan ke Web Server Directory
   Jika menggunakan XAMPP:
   Pindahkan folder anime-list/ ke direktori htdocs/.

Jika menggunakan Laragon:
Pindahkan folder anime-list/ ke direktori C:\laragon\www\.

3. Setup Database
   Buka phpMyAdmin melalui XAMPP atau Laragon.

Buat database baru : ( db_anime_list ).

Import file SQL jika disediakan, atau buat struktur tabel berdasarkan kebutuhan aplikasi.

4. Konfigurasi Database
   Buka file config/database.php

Edit konfigurasi koneksi database sesuai dengan server lokalmu:

$host = 'localhost';
$db = 'db_anime_list';
$user = 'root';
$pass = '';

5. Jalankan Aplikasi
   http://localhost/anime-list/public/index.php

# Struktur Project (MVC):

anime-list/

├── app/
│ ├── controllers/ # Controller untuk aplikasi
│ │ ├── AnimeController.php
│ │ └── AuthController.php
│ ├── models/ # Model untuk aplikasi
│ │ ├── AnimeModel.php
│ │ └── UserModel.php
│ └── views/ # View untuk aplikasi
│ ├── anime/ # Halaman anime
│ │ ├── index.php
│ │ └── show.php
│ ├── auth/ # Halaman login dan register
│ │ ├── login.php
│ │ └── register.php
│ └── templates/ # Template header dan footer
│ ├── header.php
│ └── footer.php
├── config/ # Konfigurasi aplikasi
│ └── database.php
├── public/ # Public directory
│ ├── css/ # CSS untuk styling
│ │ └── style.css
│ ├── assets/ # Folder untuk aset publik lainnya
│── index.php # Entry point aplikasi (file index.php di root)
└── routes.php # File untuk routing
