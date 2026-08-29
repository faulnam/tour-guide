<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Private Guided Tour & Custom Itinerary (Wisata Privat Eksklusif)
        $s1 = Service::updateOrCreate(
            ['slug' => 'private-guided-custom-tour'],
            [
                'title' => 'Private Guided Tour & Custom Itinerary',
                'vehicle_type' => 'both',
                'category' => 'private_tour',
                'excerpt' => 'Layanan pemandu wisata privat berlisensi HPI dengan kebebasan waktu, rute kustom fleksibel, dan mobil ber-AC.',
                'description' => 'Eksplorasi destinasi impian Anda di Indonesia tanpa terburu-buru dengan pemandu lokal profesional bersertifikasi HPI. Kami merancang rencana perjalanan (itinerary) yang disesuaikan secara personal dengan ritme perjalanan keluarga, pasangan, maupun solo traveler.',
                'base_price' => 750000,
                'estimated_duration' => '1 Hari (10-12 Jam)',
                'warranty' => 'Jaminan Layanan Pemandu Berlisensi Resmi HPI + Asuransi Perjalanan',
                'features' => [
                    'Pemandu Lokal Berlisensi Resmi HPI (Fasih Bahasa Indonesia & Inggris)',
                    'Rute Kustom & Fleksibel Tanpa Batasan Titik Wisata',
                    'Transportasi Mobil Nyaman Ber-AC + Driver Profesional + BBM',
                    'Tiket Masuk Prioritas (Fast-Track) Destinasi Wisata Utama',
                    'Rekomendasi Kuliner Otentik Lokal Non-Turistik',
                ],
                'icon' => 'compass',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1000&auto=format&fit=crop',
                'order' => 1,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 2. Island Hopping & Marine Snorkeling Guide (Wisata Bahari & Liveaboard)
        $s2 = Service::updateOrCreate(
            ['slug' => 'island-hopping-marine-guide'],
            [
                'title' => 'Island Hopping & Marine Snorkeling Guide',
                'vehicle_type' => 'motor',
                'category' => 'marine_tour',
                'excerpt' => 'Pemandu spesialis wisata laut, snorkeling karang perawan, dan berenang bersama Pari Manta serta Penyu di Labuan Bajo & Raja Ampat.',
                'description' => 'Jelajahi keajaiban bawah laut kepulauan Indonesia didampingi PADI Divemaster dan marine naturalist guide berpengalaman. Termasuk perlengkapan snorkeling steril berstandar tinggi, briefing keselamatan arus laut, dan dokumentasi underwater Go-Pro 4K.',
                'base_price' => 1250000,
                'estimated_duration' => 'Full Day / Liveaboard 3D2N',
                'warranty' => 'Standar Keselamatan Kelautan Internasional + First-Aid Certified',
                'features' => [
                    'Pemandu Laut Bersertifikasi PADI / Naturalist Guide',
                    'Perlengkapan Snorkeling Lengkap & Steril (Mask, Snorkel, Fin, Life Jacket)',
                    'Spot Snorkeling Terbaik & Tersembunyi (Secret Corals & Manta Point)',
                    'Dokumentasi Foto & Video Bawah Air (Underwater Action Cam 4K)',
                    'Briefing Keamanan Arus & Perlindungan Ekosistem Terumbu Karang',
                ],
                'icon' => 'water',
                'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1000&auto=format&fit=crop',
                'order' => 2,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 3. Volcano Trekking & Adventure Expedition Guide (Gunung & Petualangan)
        $s3 = Service::updateOrCreate(
            ['slug' => 'volcano-trekking-adventure'],
            [
                'title' => 'Volcano Trekking & Sunrise Adventure Guide',
                'vehicle_type' => 'mobil',
                'category' => 'adventure',
                'excerpt' => 'Ekspedisi mendaki Gunung Bromo Sunrise, Fenomena Api Biru Kawah Ijen, dan Gunung Rinjani dengan pemandu gunung berlisensi.',
                'description' => 'Taklukkan puncak-puncak vulkanik spektakuler Nusantara dengan pendampingan guide gunung bersertifikasi APGI. Kami menyediakan masker gas respirator standar kimia untuk Kawah Ijen, Jeep 4x4 off-road untuk lautan pasir Bromo, serta peralatan pendukung pendakian yang aman.',
                'base_price' => 950000,
                'estimated_duration' => '1 - 3 Hari Pendakian',
                'warranty' => 'Pemandu Bersertifikasi APGI (Asosiasi Pemandu Gunung Indonesia)',
                'features' => [
                    'Pemandu Gunung Berlisensi Resmi APGI',
                    'Sewa Mobil Jeep 4x4 Off-Road Khusus Medan Vulkanik',
                    'Masker Gas Respirator Profesional & Senter Kepala (Headlamp)',
                    'Penentuan Titik Spot Golden Sunrise Terbaik & Minim Keramaian',
                    'Manajemen Waktu Pendakian & Pertolongan Pertama Medis Lapangan',
                ],
                'icon' => 'mountain',
                'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1000&auto=format&fit=crop',
                'order' => 3,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 4. Cultural Heritage & Spiritual Walking Tour (Warisan Budaya & Sejarah)
        $s4 = Service::updateOrCreate(
            ['slug' => 'cultural-heritage-spiritual-tour'],
            [
                'title' => 'Cultural Heritage & Spiritual Walking Tour',
                'vehicle_type' => 'both',
                'category' => 'culture',
                'excerpt' => 'Jelajah filosofi candi Borobudur, spiritualitas pura di Bali, hingga upacara adat sakral Tana Toraja bersama budayawan lokal.',
                'description' => 'Pahami makna mendalam di balik relief candi kuno, arsitektur keraton, dan ritual tradisi suku-suku Nusantara. Pemandu kami adalah budayawan dan sejarawan lokal yang mampu menyampaikan kisah sejarah Indonesia secara memikat dan penuh penghormatan tradisi.',
                'base_price' => 600000,
                'estimated_duration' => 'Setengah Hari (4-6 Jam)',
                'warranty' => 'Akses Khusus Budayawan & Pemandu Sejarah Senior',
                'features' => [
                    'Pemandu Sejarawan / Budayawan Lokal Berpengalaman',
                    'Eksplorasi Relief & Filosofi Candi Warisan Dunia UNESCO',
                    'Akses Upacara Adat Tradisional & Edukasi Etika Busana Sakral',
                    'Workshop Singkat Kerajinan Tangan (Batik / Anyaman / Ukir Tradisional)',
                    'Audio Receiver Wireless untuk Narasi yang Jernih di Area Candi',
                ],
                'icon' => 'landmark',
                'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?q=80&w=1000&auto=format&fit=crop',
                'order' => 4,
                'is_popular' => false,
                'is_active' => true,
            ]
        );

        // 5. Wildlife & Eco-Jungle Safari Guide (Satwa Liar & Hutan Hujan)
        $s5 = Service::updateOrCreate(
            ['slug' => 'wildlife-eco-jungle-safari'],
            [
                'title' => 'Wildlife & Eco-Jungle Safari Guide',
                'vehicle_type' => 'mobil',
                'category' => 'nature',
                'excerpt' => 'Menyusuri habitat Orangutan Tanjung Puting dengan Klotok atau melacak Komodo purba dengan ranger berlisensi konservasi.',
                'description' => 'Pengalaman ekspedisi ramah lingkungan menyusuri hutan tropis tertua di bumi dan habitat satwa endemik Indonesia. Didampingi ranger konservasi berlisensi yang memahami tingkah laku satwa liar, rute jejak satwa, serta prinsip ecotourism berkelanjutan.',
                'base_price' => 1500000,
                'estimated_duration' => '2 - 4 Hari Ekspedisi',
                'warranty' => 'Pemandu Konservasi Berizin Balai Taman Nasional RI',
                'features' => [
                    'Ranger Resmi & Pemandu Konservasi Satwa Liar',
                    'Kapal Klotok Tradisional Kayu Ulin Nyaman & Beratap',
                    'Penyusuran Sungai Hutan Hujan Tropis & Feeding Station Satwa',
                    'Peneropong Binokular Kualitas Tinggi untuk Pengamatan Burung/Satwa',
                    'Kontribusi Donasi Pelestarian Hutan & Satwa Endemik Indonesia',
                ],
                'icon' => 'tree',
                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1000&auto=format&fit=crop',
                'order' => 5,
                'is_popular' => false,
                'is_active' => true,
            ]
        );

        // 6. Travel Photography & Drone Cinematic Tour Guide (Dokumentasi Visual Liburan)
        $s6 = Service::updateOrCreate(
            ['slug' => 'photography-drone-tour-guide'],
            [
                'title' => 'Cinematic Photography & Drone Tour Guide',
                'vehicle_type' => 'both',
                'category' => 'photo_tour',
                'excerpt' => 'Pemandu sekaligus fotografer profesional bersertifikasi drone pilot untuk dokumentasi video sinematik 4K liburan Anda.',
                'description' => 'Abadikan momen liburan istimewa di lanskap terindah Indonesia dengan hasil foto beresolusi tinggi dan rekaman drone 4K siap posting di media sosial. Pemandu kami memandu rute terbaik pada golden hour dan mengarahkan pose alami terbaik.',
                'base_price' => 1100000,
                'estimated_duration' => '1 Hari Penuh',
                'warranty' => 'Hasil Foto Color Graded Selesai dalam 24 Jam',
                'features' => [
                    'Pemandu Sekaligus Fotografer & Pilot Drone Berlisensi FASI',
                    'Kamera Mirrorless Full-Frame Sony/Canon + Drone DJI 4K HDR',
                    'Pengambilan Sudut Angle Terbaik Sesuai Golden Hour',
                    '50+ Foto Edited High-Res + 3 Video Reels/TikTok Siap Upload',
                    'Semua File Mentah (RAW/Master) Dikirim via Google Drive Hari yang Sama',
                ],
                'icon' => 'camera',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1000&auto=format&fit=crop',
                'order' => 6,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // Child Services under Private Guided Custom Tour
        Service::updateOrCreate(
            ['slug' => 'bali-heritage-private-day-tour'],
            [
                'parent_id' => $s1->id,
                'title' => 'Bali Heritage & Scenic Day Excursion',
                'vehicle_type' => 'mobil',
                'category' => 'private_tour',
                'excerpt' => 'Paket pemandu privat 1 hari mengeksplorasi Ubud, Tegalalang Rice Terrace, Pura Tirta Empul, dan Air Terjun Kanto Lampo.',
                'description' => 'Pemandu privat Wayan Arta akan menjemput Anda di hotel dan mendampingi seharian penuh menjelajahi keindahan alam dan spiritualitas pulau Dewata.',
                'base_price' => 650000,
                'estimated_duration' => '10 Jam',
                'warranty' => 'HPI Bali Guide Licensed',
                'features' => ['Pemandu Lokal Asli Bali', 'Mobil Avanza/Innova Reborn', 'Air Mineral Dingin & Sarung Masuk Pura'],
                'icon' => 'map-location-dot',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=600&auto=format&fit=crop',
                'order' => 1,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        Service::updateOrCreate(
            ['slug' => 'yogyakarta-borobudur-prambanan-guide'],
            [
                'parent_id' => $s1->id,
                'title' => 'Yogyakarta Royal Heritage & Temple Trail',
                'vehicle_type' => 'mobil',
                'category' => 'private_tour',
                'excerpt' => 'Pemandu candi bersertifikasi UNESCO untuk eksplorasi Candi Borobudur, Candi Prambanan, dan Keraton Yogyakarta.',
                'description' => 'Kupas tuntas filosofi arsitektur Mataram Kuno dan relief Borobudur bersama sejarawan lokal terbaik di Yogyakarta.',
                'base_price' => 700000,
                'estimated_duration' => '9 Jam',
                'warranty' => 'Pemandu Resmi Taman Wisata Candi',
                'features' => ['Pemandu Candi Khusus Naik Struktur', 'Transportasi Nyaman', 'Tiket Reservasi Borobudur Terjamin'],
                'icon' => 'monument',
                'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?q=80&w=600&auto=format&fit=crop',
                'order' => 2,
                'is_popular' => false,
                'is_active' => true,
            ]
        );
    }
}
