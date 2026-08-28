# Apex Garage — Bengkel Modifikasi Motor & Mobil (Performance Tuning & Custom Studio)

Aplikasi Web Company Profile & Workshop Management System terintegrasi untuk bengkel modifikasi motor dan mobil performa tinggi, dilengkapi dengan sistem **Booking Online & Payment Gateway**, **3 Role Portal (Admin, Karyawan/Mekanik, Customer)**, serta **Sistem Absensi Karyawan dengan Kamera Webcam Real-Time**.

---

## 🏎️ Fitur Utama

### 1. Rebranding Bengkel Otomotif (Motor & Mobil)
- **Layanan Modifikasi**: ECU Remap & Dyno Run, Custom Cafe Racer / Bobber, Widebody Kit, Cat Oven Spies Hecker, Air Suspension & BBK, Nano Ceramic Coating 9H.
- **Portofolio Tuning & Dyno Stats**: Tampilan Before/After dyno run (Peningkatan Horsepower & Torsi terukur), galeri modifikasi motor & mobil.
- **AI Automotive Tuning Consultant**: Chatbot cerdas berbasis Google Gemini AI untuk konsultasi modifikasi kendaraan secara interaktif.

### 2. Sistem Booking Online & Payment Gateway
- **Multi-Step Wizard**: Pemilihan kendaraan (Mobil/Motor), input plat nomor & spesifikasi, pemilihan paket servis, serta pemilihan slot tanggal dan jam.
- **Kalkulasi Down Payment (DP)**: Perhitungan DP otomatis untuk mengunci slot lift bengkel.
- **Payment Gateway Simulator**: Simulasi pembayaran via QRIS instant (Gopay/OVO/Dana/BCA), Virtual Account, dan kartu kredit.
- **Live Build Progress Tracker**: Pelanggan dapat memantau progres tahapan pengerjaan kendaraan secara real-time disertai foto dan catatan mekanik.

### 3. Tiga (3) Role Portal Pengguna
- **Admin**:
  - Dashboard analitik bengkel (omzet, antrean aktif, kehadiran mekanik).
  - Manajemen booking, assign teknisi, dan invoice.
  - **Rekap Absensi Kamera Karyawan** dengan galeri foto selfie snapshot & filter status/tanggal.
  - Manajemen karyawan & mekanik, layanan, portofolio build, partner brand, penghargaan, dan blog.
- **Karyawan / Mekanik**:
  - **Sistem Absensi Kamera Webcam**: Snapshot foto selfie saat Check-In dan Check-Out dengan watermark jam WIB dan GPS.
  - Status keterlambatan otomatis (hadir <= 08:30 WIB, terlambat > 08:30 WIB).
  - Manajemen tugas modifikasi unit kendaraan: update persentase progres, stage pengerjaan, dan upload foto log teknisi.
- **Customer**:
  - Garasi Kendaraan Saya (My Garage): Simpan data motor & mobil untuk booking cepat 1-klik.
  - Live Tracker pengerjaan unit kendaraan dan invoice digital.

---

## 🔐 Akun & Kredensial Login

Akses halaman login di `/login`. Pada halaman login hanya ditampilkan **Akun Demo**, sedangkan akun asli disembunyikan.

### 🧪 Akun Demo (Ditampilkan di Login — Auto-Reset 25 Menit)
Semua perubahan data atau data baru yang dibuat menggunakan akun demo akan otomatis dibersihkan dan kembali semula setiap **25 menit**.

| Role | Email Demo | Password Demo | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Demo Admin** | `demoadmin@bengkel.com` | `demoadmin123` | Akses penuh CMS, Booking, Rekap Absensi, Karyawan |
| **Demo Karyawan** | `demomekanik@bengkel.com` | `demomekanik123` | Portal Mekanik, Absensi Kamera Webcam, Tugas Modifikasi |
| **Demo Customer** | `democustomer@bengkel.com` | `democustomer123` | Garasi Kendaraan, Live Tracker Booking, Riwayat Invoice |

### 🛡️ Akun Asli (Disembunyikan dari Form Login Helper)
Password untuk semua akun asli adalah `qwertyu123`:

| Role | Email Asli | Password Asli | Deskripsi |
| :--- | :--- | :--- | :--- |
| **Master Admin** | `admin@bengkel.com` | `qwertyu123` | Super Admin / Workshop Director |
| **Lead Tuner** | `mekanik@bengkel.com` | `qwertyu123` | Kepala Mekanik & Dyno Tuner |
| **Bike Builder** | `indra@bengkel.com` | `qwertyu123` | Spesialis Modifikasi Motor Custom |
| **Paint Master** | `reza@bengkel.com` | `qwertyu123` | Spesialis Bodykit & Cat Oven |
| **Customer 1** | `customer@gmail.com` | `qwertyu123` | Pelanggan Rian Aditya (Civic Type R & ZX-25R) |
| **Customer 2** | `bambang@gmail.com` | `qwertyu123` | Pelanggan Bambang Sudiro (Yamaha XSR 155) |

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Database**: MySQL (`db_bengkel`)
- **Frontend**: Blade Templating, Vanilla CSS / Tailwind CLI, Alpine.js, FontAwesome 6, Swiper.js
- **Kamera & Media**: HTML5 MediaDevices API (`getUserMedia`), Canvas base64 capture
- **AI**: Google Gemini API via GeminiService

---

## 🚀 Panduan Instalasi & Menjalankan

1. **Clone repositori**:
   ```bash
   git clone https://github.com/faulnam/bengkel.git
   cd bengkel
   ```

2. **Konfigurasi Lingkungan (`.env`)**:
   ```env
   APP_NAME="Apex Garage"
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_bengkel
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Migrasi & Seed Database**:
   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```

4. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka browser di `http://localhost:8000`.

---

© 2026 **Apex Garage Indonesia**. Built with high precision.
