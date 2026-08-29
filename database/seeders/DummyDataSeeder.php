<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Award;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\HeroSlide;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Hero Slides
        HeroSlide::truncate();
        $slides = [
            [
                'page' => 'home',
                'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1920&auto=format&fit=crop',
                'title' => 'JELAJAHI KEINDAHAN NUSANTARA BERSAMA PEMANDU RESMI',
                'subtitle' => 'Pemandu wisata privat berlisensi HPI & APGI di destinasi impian: Raja Ampat, Labuan Bajo, Bromo, Bali, hingga Tana Toraja dengan aman, nyaman, dan berkesan.',
                'button_text' => 'BOOKING PEMANDU SEKARANG',
                'button_link' => '/booking',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1920&auto=format&fit=crop',
                'title' => 'SAILING KOMODO & PADAR ISLAND LIVEABOARD',
                'subtitle' => 'Arungi keajaiban laut Flores dengan kapal Phinisi semi-luxury, berenang bersama Manta Ray, dan nikmati golden sunrise di puncak Pulau Padar.',
                'button_text' => 'LIHAT DESTINASI WISATA',
                'button_link' => '/portfolio',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1920&auto=format&fit=crop',
                'title' => 'SUNRISE BROMO & BLUE FIRE KAWAH IJEN',
                'subtitle' => 'Petualangan Jeep 4x4 melintasi lautan pasir Bromo dan pendakian malam menyaksikan fenomena api biru abadi didampingi guide gunung bersertifikasi.',
                'button_text' => 'KONSULTASI ITINERARY AI',
                'button_link' => '/contact-us',
                'order' => 3,
                'is_active' => true,
            ],
        ];
        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }

        // 2. Tourism Partners & Airlines
        Client::truncate();
        $brands = [
            ['name' => 'Wonderful Indonesia', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Wonderful_Indonesia_logo.svg/320px-Wonderful_Indonesia_logo.svg.png', 'website_url' => 'https://indonesia.travel', 'order' => 1, 'is_active' => true],
            ['name' => 'Garuda Indonesia', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/00/Garuda_Indonesia_logo.svg/320px-Garuda_Indonesia_logo.svg.png', 'website_url' => 'https://garuda-indonesia.com', 'order' => 2, 'is_active' => true],
            ['name' => 'Taman Nasional Komodo', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Coat_of_arms_of_the_Ministry_of_Environment_and_Forestry_%28Indonesia%29.svg/320px-Coat_of_arms_of_the_Ministry_of_Environment_and_Forestry_%28Indonesia%29.svg.png', 'website_url' => 'https://gatradimansipetualang.menlhk.go.id', 'order' => 3, 'is_active' => true],
            ['name' => 'ASITA (Association of The Indonesian Tours and Travel Agencies)', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/ASITA_logo.png/320px-ASITA_logo.png', 'website_url' => 'https://asitaindonesia.org', 'order' => 4, 'is_active' => true],
            ['name' => 'PHRI (Perhimpunan Hotel dan Restoran Indonesia)', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Logo_PHRI.png/320px-Logo_PHRI.png', 'website_url' => 'https://phrionline.com', 'order' => 5, 'is_active' => true],
            ['name' => 'InJourney (PT Aviasi Pariwisata Indonesia)', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/InJourney_logo.svg/320px-InJourney_logo.svg.png', 'website_url' => 'https://injourney.id', 'order' => 6, 'is_active' => true],
        ];
        foreach ($brands as $b) {
            Client::create($b);
        }

        // 3. Awards & Certifications
        Award::truncate();
        $awards = [
            [
                'title' => 'Best Indonesian Tour Operator & Guide Service 2025 — Wonderful Indonesia Award',
                'slug' => 'best-tour-operator-guide-service-2025',
                'image' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=800&auto=format&fit=crop',
                'description' => 'Penghargaan tertinggi dari Kementerian Pariwisata RI atas dedikasi pelayanan pemandu wisata berstandar internasional dan kepuasan wisatawan tertinggi.',
                'published_date' => '2025-10-15',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'HPI Certified Excellence Award 2025 — Himpunan Pramuwisata Indonesia',
                'slug' => 'hpi-certified-excellence-award',
                'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=800&auto=format&fit=crop',
                'description' => 'Apresiasi resmi untuk komitmen seluruh jaringan pemandu Nusantara Tour Guide dalam menjaga etika kepramuwisataan dan keselamatan wisata alam.',
                'published_date' => '2025-08-20',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'TripAdvisor Travelers\' Choice Award 2025 — Top 10% Attractions & Tours in Indonesia',
                'slug' => 'tripadvisor-travelers-choice-2025',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop',
                'description' => 'Dipilih langsung oleh ribuan traveler global atas ulasan bintang 5 konsisten dalam memandu ekspedisi Komodo, Bromo, dan Raja Ampat.',
                'published_date' => '2025-06-10',
                'order' => 3,
                'is_active' => true,
            ],
        ];
        foreach ($awards as $a) {
            Award::create($a);
        }

        // 4. Blog Categories
        BlogCategory::truncate();
        $cats = [
            ['title' => 'Panduan Wisata Bahari & Kepulauan', 'slug' => 'wisata-bahari'],
            ['title' => 'Gunung & Petualangan Vulkanik', 'slug' => 'gunung-petualangan'],
            ['title' => 'Warisan Budaya & Sejarah Nusantara', 'slug' => 'budaya-sejarah'],
            ['title' => 'Tips & Persiapan Traveling Indonesia', 'slug' => 'tips-traveling'],
        ];
        $catModels = [];
        foreach ($cats as $c) {
            $catModels[$c['slug']] = BlogCategory::create($c);
        }

        // 5. Blog Posts
        BlogPost::truncate();
        $posts = [
            [
                'blog_category_id' => $catModels['wisata-bahari']->id,
                'title' => 'Panduan Lengkap Snorkeling di Raja Ampat: Spot Terbaik & Musim Ombak Tenang',
                'slug' => 'panduan-lengkap-snorkeling-raja-ampat',
                'cover_image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Semua hal yang perlu Anda ketahui sebelum menjelajahi keanekaragaman hayati laut terkaya di planet bumi di Raja Ampat, Papua Barat.',
                'content' => '<p>Raja Ampat dikenal sebagai pusat Segitiga Terumbu Karang Dunia yang menyimpan lebih dari 75% spesies karang global. Artikel ini mengupas waktu terbaik berkunjung (Oktober - April), rute penerbangan menuju Sorong, serta mengapa didampingi pemandu lokal berlisensi sangat krusial untuk navigasi perairan dan keselamatan Anda.</p><h3>Spot Snorkeling Ikonik</h3><ul><li><strong>Manta Sandy:</strong> Tempat pembersihan alami pari manta raksasa.</li><li><strong>Yenbuba Jetty:</strong> Sekolah ikan barakuda dan terumbu karang hidup tepat di bawah dermaga.</li><li><strong>Friwen Wall:</strong> Dinding karang vertikal warna-warni yang spektakuler.</li></ul>',
                'author' => 'La Ode Rizal (Marine Guide)',
                'published_at' => Carbon::now()->subDays(5),
                'is_published' => true,
            ],
            [
                'blog_category_id' => $catModels['gunung-petualangan']->id,
                'title' => 'Tips Mendaki Gunung Bromo & Kawah Ijen: Perlengkapan Wajib & Etika Vulkanik',
                'slug' => 'tips-mendaki-gunung-bromo-kawah-ijen',
                'cover_image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Persiapan fisik, pemilihan pakaian hangat, masker gas respirator standar kimia, dan panduan menyaksikan Blue Fire secara aman.',
                'content' => '<p>Mendaki gunung berapi aktif di Jawa Timur membutuhkan persiapan matang. Suhu malam hari di Bromo dan Ijen dapat menyentuh 5°C. Simak tips memilih jeep off-road resmi, cara menghindari paparan asap belerang berlebih di dasar kawah Ijen, dan etika menghormati jalur penambang belerang tradisional.</p>',
                'author' => 'Bagas Pratama (APGI Mountain Guide)',
                'published_at' => Carbon::now()->subDays(12),
                'is_published' => true,
            ],
            [
                'blog_category_id' => $catModels['budaya-sejarah']->id,
                'title' => 'Eksplorasi Budaya Tana Toraja: Makna Rumah Adat Tongkonan & Upacara Rambu Solo\'',
                'slug' => 'eksplorasi-budaya-tana-toraja-rambu-solo',
                'cover_image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Memahami kearifan lokal, filosofi arsitektur atap perahu, serta tradisi penghormatan leluhur masyarakat suku Toraja di Sulawesi Selatan.',
                'content' => '<p>Tana Toraja menyimpan salah satu peradaban megalitik paling terjaga di dunia. Pemandu budaya kami merangkum etika menghadiri upacara adat pemakaman Rambu Solo, makna ukiran kayu Pa\'tedong (kepala kerbau), dan sejarah kuburan tebing batu di Lemo dan Londa.</p>',
                'author' => 'I Wayan Arta (Senior Cultural Guide)',
                'published_at' => Carbon::now()->subDays(20),
                'is_published' => true,
            ],
        ];
        foreach ($posts as $p) {
            BlogPost::create($p);
        }

        // 6. Testimonials
        Testimonial::truncate();
        $testimonials = [
            [
                'client_name' => 'dr. Hendra Wijaya',
                'client_company' => 'Wisatawan Keluarga (Jakarta)',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'message' => 'Trip keluarga 4D3N ke Labuan Bajo & Pulau Padar bersama guide La Ode Rizal luar biasa memuaskan! Pemandu sangat sabar membimbing anak-anak saat snorkeling dan foto-foto dokumentasinya kelas profesional!',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Clarissa Putri',
                'client_company' => 'Solo Traveler & Content Creator',
                'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'message' => 'Pengalaman sunrise Bromo dan Blue Fire Ijen bersama Mas Bagas tak terlupakan. Sebagai solo traveler perempuan, saya merasa sangat aman, nyaman, dan terbantu dengan masker respirator yang disediakan!',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Marcus Vance',
                'client_company' => 'Traveler from Melbourne, Australia',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'message' => 'Wayan is the best cultural guide in Bali. His knowledge about Balinese philosophy, hidden waterfalls, and secret temple ceremonies was truly mind-blowing. Highly recommend Nusantara Tour Guide!',
                'order' => 3,
                'is_active' => true,
            ],
        ];
        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // 7. Contact Messages
        ContactMessage::truncate();
        ContactMessage::create([
            'name' => 'Bpk. Gunawan Santoso',
            'email' => 'gunawan.santoso@yahoo.com',
            'company' => 'Keluarga Besar Santoso (Jakarta)',
            'message' => 'Halo Nusantara Tour Guide, kami berencana membawa rombongan keluarga besar 12 orang ke Raja Ampat bulan depan. Mohon dikirimkan rincian paket privat speedboat dan pemandu berlisensi HPI.',
            'is_read' => true,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        // 8. Demo User Vehicles / Saved Travel Preferences
        Vehicle::truncate();
        $userCustomer = User::where('email', 'customer@gmail.com')->first();
        if ($userCustomer) {
            Vehicle::create([
                'user_id' => $userCustomer->id,
                'type' => 'mobil',
                'brand' => 'Destinasi Favorit: Labuan Bajo & Komodo',
                'model' => 'Paket Private Liveaboard 3D2N',
                'license_plate' => 'Jumlah: 4 Pax Dewasa',
                'year' => 2025,
                'color' => 'Preferensi: Snorkeling & Sunset',
                'engine_cc' => 4,
                'transmission' => 'Private Speedboat',
                'notes' => 'Permintaan menu makanan ramah anak & pemandu mahir dokumentasi underwater.',
            ]);

            Vehicle::create([
                'user_id' => $userCustomer->id,
                'type' => 'motor',
                'brand' => 'Destinasi Favorit: Gunung Bromo & Ijen',
                'model' => 'Paket Jeep 4x4 & Blue Fire Midnight',
                'license_plate' => 'Jumlah: 2 Pax',
                'year' => 2025,
                'color' => 'Preferensi: Trekking & Fotografi',
                'engine_cc' => 2,
                'transmission' => 'Jeep 4x4 Off-Road',
                'notes' => 'Perlu masker respirator standar belerang & penjemputan Stasiun Malang.',
            ]);
        }

        // 9. Realistic Bookings
        Booking::truncate();
        BookingLog::truncate();
        Payment::truncate();

        $guideBali = User::where('email', 'guide@tourguide.id')->first();
        $guideBromo = User::where('email', 'putra@tourguide.id')->first();
        $guideKomodo = User::where('email', 'laode@tourguide.id')->first();

        $sPrivate = Service::where('slug', 'private-guided-custom-tour')->first();
        $sMarine = Service::where('slug', 'island-hopping-marine-guide')->first();
        $sVolcano = Service::where('slug', 'volcano-trekking-adventure')->first();

        // Booking 1 - In Progress (Sedang Berlangsung di Bali)
        if ($userCustomer && $guideBali && $sPrivate) {
            $b1 = Booking::create([
                'booking_code' => 'TG-202608-0001',
                'customer_id' => $userCustomer->id,
                'karyawan_id' => $guideBali->id,
                'service_id' => $sPrivate->id,
                'customer_name' => 'Rian Aditya',
                'customer_email' => 'customer@gmail.com',
                'customer_phone' => '081122334455',
                'vehicle_type' => 'mobil',
                'vehicle_brand' => 'Destinasi: Ubud & Nusa Penida',
                'vehicle_model' => 'Paket 3D2N Cultural & Cliff Trail',
                'license_plate' => '2 Orang (Pax)',
                'vehicle_year' => 2026,
                'vehicle_color' => 'Private MPV Ber-AC',
                'booking_date' => Carbon::now()->format('Y-m-d'),
                'booking_time_slot' => 'Pagi (08:00 WITA)',
                'custom_request' => 'Mohon sertakan sarung pura dan rekomendasi makan siang bebek tepi sawah khas Ubud.',
                'mechanic_notes' => 'Wisatawan sudah dijemput di Hotel Sanur. Menuju Pura Tirta Empul untuk prosesi melukat.',
                'progress_percentage' => 65,
                'status' => 'in_progress',
                'total_amount' => 1950000,
                'dp_amount' => 600000,
                'paid_amount' => 1950000,
                'payment_status' => 'paid',
                'payment_method' => 'qris',
                'delivery_method' => 'Penjemputan Hotel / Villa',
                'delivery_address' => 'Maya Sanur Resort & Spa, Jl. Danau Tamblingan, Sanur, Bali',
                'delivery_notes' => 'Pemandu tiba 15 menit lebih awal di lobi utama.',
            ]);

            Payment::create([
                'booking_id' => $b1->id,
                'user_id' => $userCustomer->id,
                'transaction_code' => 'PAY-' . date('Ym') . '-0001',
                'amount' => 1950000,
                'payment_type' => 'full',
                'payment_method' => 'qris',
                'payment_channel' => 'qris_gopay',
                'status' => 'settlement',
                'gateway_reference' => 'MID-SETTLED-' . time() . '-01',
                'paid_at' => Carbon::now()->subDays(1),
            ]);

            BookingLog::create([
                'booking_id' => $b1->id,
                'user_id' => $guideBali->id,
                'stage' => 'disassembly', // Meeting / Briefing
                'title' => 'Penjemputan Hotel & Briefing Perjalanan',
                'description' => 'Penjemputan tepat waktu di lobi hotel. Briefing etika adat Bali dan pembagian air mineral dingin.',
                'created_at' => Carbon::now()->subHours(4),
            ]);

            BookingLog::create([
                'booking_id' => $b1->id,
                'user_id' => $guideBali->id,
                'stage' => 'machining_dyno', // On Excursion
                'title' => 'Kunjungan Pura Tirta Empul & Tegalalang',
                'description' => 'Sesi melukat penyucian jiwa berjalan lancar dan khidmat. Melanjutkan makan siang santai di Tegalalang Rice Terrace.',
                'created_at' => Carbon::now()->subHours(1),
            ]);
        }

        // Booking 2 - Confirmed (Jadwal Terbit untuk Labuan Bajo)
        if ($userCustomer && $guideKomodo && $sMarine) {
            $b2 = Booking::create([
                'booking_code' => 'TG-202608-0002',
                'customer_id' => $userCustomer->id,
                'karyawan_id' => $guideKomodo->id,
                'service_id' => $sMarine->id,
                'customer_name' => 'Rian Aditya',
                'customer_email' => 'customer@gmail.com',
                'customer_phone' => '081122334455',
                'vehicle_type' => 'motor',
                'vehicle_brand' => 'Destinasi: Taman Nasional Komodo',
                'vehicle_model' => 'Liveaboard Phinisi 3D2N',
                'license_plate' => '4 Orang (Pax)',
                'vehicle_year' => 2026,
                'vehicle_color' => 'Kapal Phinisi Semi-Luxury',
                'booking_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'booking_time_slot' => 'Pagi (07:30 WITA)',
                'custom_request' => 'Sedia fin ukuran 38 dan 42 untuk snorkeling Manta Point.',
                'mechanic_notes' => 'Kapal Phinisi dan izin Balai TN Komodo sudah terverifikasi lengkap.',
                'progress_percentage' => 0,
                'status' => 'confirmed',
                'total_amount' => 5000000,
                'dp_amount' => 1500000,
                'paid_amount' => 1500000,
                'payment_status' => 'dp_paid',
                'payment_method' => 'bank_transfer',
                'delivery_method' => 'Penjemputan Bandara Komodo (LBJ)',
                'delivery_address' => 'Bandara Komodo, Labuan Bajo, Manggarai Barat',
                'delivery_notes' => 'Penerbangan GA-450 tiba pukul 09.15 WITA.',
            ]);

            Payment::create([
                'booking_id' => $b2->id,
                'user_id' => $userCustomer->id,
                'transaction_code' => 'PAY-' . date('Ym') . '-0002',
                'amount' => 1500000,
                'payment_type' => 'dp',
                'payment_method' => 'bank_transfer',
                'payment_channel' => 'bca_va',
                'status' => 'settlement',
                'gateway_reference' => 'MID-SETTLED-' . time() . '-02',
                'paid_at' => Carbon::now()->subDays(2),
            ]);
        }

        // Booking 3 - Completed (Selesai Sukses di Bromo)
        if ($userCustomer && $guideBromo && $sVolcano) {
            $b3 = Booking::create([
                'booking_code' => 'TG-202608-0003',
                'customer_id' => $userCustomer->id,
                'karyawan_id' => $guideBromo->id,
                'service_id' => $sVolcano->id,
                'customer_name' => 'Bambang Sudiro',
                'customer_email' => 'bambang@gmail.com',
                'customer_phone' => '081333445566',
                'vehicle_type' => 'mobil',
                'vehicle_brand' => 'Destinasi: Gunung Bromo Golden Sunrise',
                'vehicle_model' => 'Private Jeep 4x4 Excursion',
                'license_plate' => '2 Orang (Pax)',
                'vehicle_year' => 2026,
                'vehicle_color' => 'Jeep Hardtop 4x4 Kuning',
                'booking_date' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'booking_time_slot' => 'Dini Hari (03:00 WIB)',
                'custom_request' => 'Tolong sediakan sarung tangan wol tebal untuk anak.',
                'mechanic_notes' => 'Tur selesai dengan sangat memuaskan, cuaca cerah di Penanjakan 1 Bromo.',
                'progress_percentage' => 100,
                'status' => 'completed',
                'total_amount' => 1800000,
                'dp_amount' => 600000,
                'paid_amount' => 1800000,
                'payment_status' => 'paid',
                'payment_method' => 'credit_card',
                'delivery_method' => 'Meeting Point Stasiun / Hotel Malang',
                'delivery_address' => 'Hotel Santika Premiere Malang',
                'delivery_notes' => 'Diantar kembali ke hotel pukul 11.30 WIB.',
            ]);

            Payment::create([
                'booking_id' => $b3->id,
                'user_id' => $userCustomer->id,
                'transaction_code' => 'PAY-' . date('Ym') . '-0003',
                'amount' => 1800000,
                'payment_type' => 'full',
                'payment_method' => 'credit_card',
                'payment_channel' => 'visa_mastercard',
                'status' => 'settlement',
                'gateway_reference' => 'MID-SETTLED-' . time() . '-03',
                'paid_at' => Carbon::now()->subDays(5),
            ]);

            BookingLog::create([
                'booking_id' => $b3->id,
                'user_id' => $guideBromo->id,
                'stage' => 'ready', // Completed
                'title' => 'Tur Selesai & Pengantaran Kembali ke Hotel',
                'description' => 'Eksplorasi spot Sunrise, Kawah Bromo, Pasir Berbisik, dan Bukit Widodaren tuntas. Wisatawan sangat gembira.',
                'created_at' => Carbon::now()->subDays(4),
            ]);
        }

        // 10. Tour Guide Camera Webcam Attendances (with realistic Indonesian GPS)
        Attendance::truncate();
        if ($guideBali) {
            Attendance::create([
                'user_id' => $guideBali->id,
                'date' => Carbon::today()->toDateString(),
                'check_in_time' => '07:25:00',
                'check_out_time' => null,
                'check_in_photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=400&auto=format&fit=crop',
                'check_out_photo' => null,
                'check_in_lat' => -8.691234,
                'check_in_lng' => 115.263456,
                'status' => 'hadir',
                'notes' => 'Check-in persiapan penjemputan wisatawan trip Ubud & Sanur.',
            ]);
        }

        if ($guideBromo) {
            Attendance::create([
                'user_id' => $guideBromo->id,
                'date' => Carbon::today()->toDateString(),
                'check_in_time' => '02:45:00',
                'check_out_time' => '11:15:00',
                'check_in_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400&auto=format&fit=crop',
                'check_out_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=400&auto=format&fit=crop',
                'check_in_lat' => -7.942494,
                'check_in_lng' => 112.953012,
                'check_out_lat' => -7.982494,
                'check_out_lng' => 112.633012,
                'status' => 'hadir',
                'notes' => 'Selesai mendampingi sunrise jeep Bromo & kembali ke basecamp Malang.',
            ]);
        }

        if ($guideKomodo) {
            Attendance::create([
                'user_id' => $guideKomodo->id,
                'date' => Carbon::today()->toDateString(),
                'check_in_time' => '07:10:00',
                'check_out_time' => null,
                'check_in_photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=400&auto=format&fit=crop',
                'check_out_photo' => null,
                'check_in_lat' => -8.490123,
                'check_in_lng' => 119.882345,
                'status' => 'hadir',
                'notes' => 'Standby di Dermaga Marina Labuan Bajo untuk boarding Phinisi.',
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
