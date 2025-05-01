# Anime List Project

Simple anime list website using Jikan API with PHP and MySQLi

## Installation

1. Create database using `database.sql`
2. Configure database in `config/database.php`
3. Upload files to your web server
4. Access via browser

## Features

- Browse popular anime
- View anime details
- Comments anime
- Bookmark anime
- User registration and login
- Responsive design with Tailwind CSS

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)

## Struktur

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
│ |── assets/ # Folder untuk aset publik lainnya
│\_\_ index.php # Entry point aplikasi (file index.php di root)
└── routes.php # File untuk routing
