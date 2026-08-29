# Dokumentasi Sistem: Nusantara Tour Guide Indonesia

## 1. Judul Proyek
**Sistem Informasi Company Profile, Manajemen Operasional & Reservasi Pemandu Wisata Resmi Indonesia (HPI Certified)**

---

## 2. Deskripsi Singkat
Nusantara Tour Guide adalah platform digital komprehensif yang dirancang untuk industri pariwisata dan kepemanduan resmi di Indonesia. Platform ini mengintegrasikan etalase paket wisata bertingkat, galeri ekspedisi destinasi alam Indonesia, sistem reservasi online dengan kalkulasi otomatis uang muka (DP 30%), simulasi gateway pembayaran multi-channel, portal operasional 3 role pengguna (Administrator, Pemandu Wisata Lapangan, dan Wisatawan), sistem absensi kamera selfie ber-watermark GPS, serta asisten AI kepemanduan pariwisata berbasis Google Gemini.

---

## 3. Overview Lengkap Proyek
Platform ini menghadirkan pengalaman visual yang berkelas dan estetis dengan tema luxury eco-tourism alam Indonesia (*Deep Forest Emerald*, *Pine Green*, *Warm Sand Champagne*, *Sage Green*). Pengunjung dapat mengeksplorasi destinasi dari Sabang sampai Merauke (Bali, Raja Ampat, Labuan Bajo, Bromo, Ijen, Yogyakarta, Tana Toraja, Tanjung Puting, Derawan, Belitung), memesan pemandu berlisensi HPI/APGI, dan melakukan pembayaran secara instan.

Di sisi operasional, sistem menyediakan 3 role terintegrasi:
1. **Admin**: Mengelola seluruh katalog destinasi, paket wisata, konfirmasi reservasi, penugasan pemandu, monitoring kehadiran pemandu via foto kamera selfie GPS, dan konten website.
2. **Pemandu Wisata (Staff)**: Melakukan absensi masuk/pulang menggunakan kamera selfie dan koordinat GPS, melihat jadwal trip yang ditugaskan, memperbarui tahapan rute perjalanan, dan mengunggah foto dokumentasi momen terbaik wisatawan.
3. **Wisatawan (Customer)**: Memantau status persiapan perjalanan secara real-time, melihat dokumentasi foto dari pemandu, memeriksa keabsahan voucher & asuransi wisata, serta menyimpan preferensi destinasi impian.

---

## 4. Daftar Akun & Kredensial Pengujian

### Akun Demo (Ditampilkan di Form Login)
- **Demo Traveler**: `democustomer@tourguide.id` | Password: `democustomer123`
- **Demo Pemandu**: `demoguide@tourguide.id` | Password: `demoguide123`
- **Demo Admin**: `demoadmin@tourguide.id` | Password: `demoadmin123`

### Akun Utama / Master
- **Super Administrator**: `admin@tourguide.id` | Password: `qwertyu123`
- **Pemandu Budaya Bali (HPI)**: `wayan@tourguide.id` | Password: `qwertyu123`
- **Pemandu Gunung Bromo-Ijen (APGI)**: `bagas@tourguide.id` | Password: `qwertyu123`
- **Pemandu Bahari Labuan Bajo (HPI)**: `rizal@tourguide.id` | Password: `qwertyu123`

---

## 5. Fitur Kunci (Key Features)

1. **Company Profile Pariwisata & Galeri Destinasi Ekspedisi Nusantara**.
2. **Katalog Paket Wisata Bertingkat (Kategori Induk & Sub-Paket Rute Khusus)**.
3. **Online Booking Wizard 3 Langkah dengan Pemilihan Titik Temu & Bahasa Pemandu**.
4. **Kalkulator Otomatis Uang Muka DP 30% & Sisa Pelunasan**.
5. **Simulator Payment Gateway Interaktif (QRIS Instan, Virtual Account, Transfer Bank)**.
6. **Digital Travel Pass & E-Invoice Resmi dengan Live Activity Timeline Tracker**.
7. **Sistem Presensi Kamera Webcam Real-Time Pemandu dengan Watermark Waktu & GPS**.
8. **Manajemen Penugasan Trip & Upload Foto Dokumentasi Lapangan oleh Pemandu**.
9. **Pengecekan Keabsahan Voucher, Sertifikasi HPI & Jaminan Asuransi Perjalanan**.
10. **Panel Administrasi CMS Lengkap untuk Reservasi, Layanan, Karyawan, dan Blog**.
11. **Asisten Chatbot AI Konsultan Perjalanan Berbasis Google Gemini (Nusantara Guide AI)**.
12. **Desain Responsif & Estetis Bertema Luxury Eco-Tourism Indonesia**.

---

## 6. Arsitektur Teknologi

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Basis Data**: MySQL (`db_tourguide`)
- **Autentikasi**: Laravel Session-Based Multi-Role Guard
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js, Font Awesome 6
- **Kamera & Geolocation**: HTML5 MediaDevices API & Geolocation API
- **AI Integration**: Google Gemini API via `GeminiService`
