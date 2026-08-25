# Sistem Informasi Company Profile dan Manajemen Portofolio Interior Design Terpadu

Sistem Informasi Company Profile dan Manajemen Portofolio Interior Design Terpadu adalah platform berbasis web modern yang dirancang untuk industri arsitektur dan desain interior mewah. Aplikasi ini mengintegrasikan portal profil interaktif untuk menampilkan portofolio proyek eksklusif, katalog layanan berjenjang 2 level, galeri foto dinamis, publikasi penghargaan dan berita desain, lowongan pekerjaan interaktif, integrasi chatbot AI cerdas berbasis Google Gemini, serta panel CMS administratif dengan kontrol akses berbasis peran (RBAC).

---

## Akun Role Asli (Production / Default)

Berikut adalah daftar akun pengguna asli untuk setiap peran sistem:

| Peran | Email | Password |
|---|---|---|
| Super Admin | `admin@the-metrix.com` | `qwertyu123` |
| Editor | `editor@the-metrix.com` | `qwertyu123` |

---

## Akun Role Demo (Fitur Auto Delete 3 Menit)

Aplikasi ini dilengkapi dengan akun demo untuk pengujian interaktif setiap peran. Setiap data atau konten baru yang dibuat oleh akun demo akan secara otomatis terhapus dari sistem dalam waktu 3 menit setelah pembuatan.

| Peran Demo | Email Demo | Password Demo | Masa Berlaku Konten |
|---|---|---|---|
| Demo Super Admin | `demo_admin@the-metrix.com` | `password` | 3 Menit Otomatis Terhapus |
| Demo Editor | `demo_editor@the-metrix.com` | `password` | 3 Menit Otomatis Terhapus |

---

## Fitur Utama

- **Portal Profil Publik & Portofolio**: Menampilkan profil perusahaan arsitektur, proyek-proyek unggulan, dan detail proyek dengan galeri multi foto beresolusi tinggi.
- **Katalog Layanan Bertingkat (2-Level Hierarchy)**: Layanan utama (Interior Design, Interior Styling, 3D Visualization) dan sub-layanan (Work Space, Public Space, Hospitality, Show Unit & Residence, Commercial & Retail, Restaurant & Bar).
- **Showcase Penghargaan & Publikasi**: Menampilkan riwayat penghargaan dan publikasi media desain dengan sistem pagination.
- **Modul Karir & Lowongan Kerja**: Pengumuman lowongan pekerjaan interaktif dengan format accordion dan tautan pengajuan lamaran.
- **Blog & Wawasan Desain**: Publikasi artikel dan wawasan tren desain interior yang dikelompokkan berdasarkan kategori.
- **Grid Logo Klien & Rekanan**: Etalase logo klien dan partner korporat yang responsif.
- **Asisten AI Chatbot (Google Gemini)**: Chatbot interaktif cerdas untuk menjawab pertanyaan pengunjung terkait layanan dan konsultasi interior secara otomatis.
- **Formulir Kontak & Inbox Admin**: Pengiriman formulir kontak yang tersimpan langsung ke inbox pesan admin dengan indikator status baca.
- **Buletin Newsletter**: Formulir berlangganan buletin email berkala dengan fitur ekspor data subscriber ke CSV.
- **Panel CMS Administratif**: Pengelolaan menyeluruh terhadap portofolio, layanan, blog, lowongan karir, slide banner, ulasan testimoni, pengaturan statistik, dan copywriting teks statis.
- **Manajemen Pengguna & Role Akses**: Pemisahan hak akses antara Super Admin (akses penuh ke sistem dan user) dan Editor (fokus pada konten portofolio dan media).
- **Pembersihan Otomatis Data Demo**: Mekanisme otomatis berbasis event listener dan cron schedule untuk menghapus konten uji coba demo setelah 3 menit.

---

## Teknologi yang Digunakan (Tech Stack)

- **Backend Framework**: PHP 8.2 & Laravel 11
- **Database**: MySQL 8
- **Autentikasi & Otorisasi**: Laravel Session-Based Authentication & Role Middleware
- **Frontend Styling**: Standalone Tailwind CSS CLI (Clean & Fast)
- **Frontend Interactivity**: Alpine.js & Vanilla JavaScript
- **Rich Text Editor**: Quill.js
- **Artificial Intelligence**: Google Gemini API (`gemini-3.5-flash-lite`)
- **Automation**: Laravel Scheduler & Eloquent Event Listeners

---

## Panduan Instalasi & Menjalankan Proyek

1. **Clone repository dan masuk ke direktori proyek**:
   ```bash
   cd d:/laragonzo/www/interior
   ```

2. **Install dependensi PHP**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan konfigurasi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) pada file `.env` sudah sesuai dengan database MySQL lokal Anda.

4. **Jalankan Migrasi dan Seeder**:
   ```bash
   php artisan migrate --seed
   ```

5. **Kompilasi Asset Tailwind CSS (Opsional / Standalone)**:
   ```bash
   ./tailwindcss-windows-x64.exe -i ./resources/css/app.css -o ./public/css/app.css --minify
   ```

6. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi siap diakses melalui peramban web di `http://localhost:8000`. Panel admin dapat diakses di `http://localhost:8000/admin`.
