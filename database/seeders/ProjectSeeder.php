<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $privateService = Service::where('slug', 'private-guided-custom-tour')->first();
        $marineService = Service::where('slug', 'island-hopping-marine-guide')->first();
        $volcanoService = Service::where('slug', 'volcano-trekking-adventure')->first();
        $cultureService = Service::where('slug', 'cultural-heritage-spiritual-tour')->first();
        $wildlifeService = Service::where('slug', 'wildlife-eco-jungle-safari')->first();
        $photoService = Service::where('slug', 'photography-drone-tour-guide')->first();

        // 1. Raja Ampat 5D4N Expedition
        Project::updateOrCreate(
            ['slug' => 'raja-ampat-misool-wayag-ultimate-expedition'],
            [
                'service_id' => $marineService?->id,
                'title' => 'Raja Ampat Ultimate Island & Marine Expedition 5D4N',
                'vehicle_type' => 'motor',
                'vehicle_model' => 'Speedboat & Phinisi Liveaboard',
                'client' => 'Bpk. Steven & Keluarga',
                'location' => 'Raja Ampat, Papua Barat Daya',
                'year' => '2025',
                'description' => 'Petualangan eksklusif menjelajahi gugusan pulau karang karst Wayag, laguna cinta Love Lagoon Misool, snorkeling bersama pari manta di Manta Sandy, dan mendaki puncak panorama Pianemo didampingi pemandu lokal asli suku Maya Raja Ampat.',
                'cover_image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 3, // Rating / Durasi hari
                'dyno_hp_after' => 5,
                'dyno_torque_before' => 8, // Jumlah Spot Wisata
                'dyno_torque_after' => 16,
                'modification_specs' => [
                    'Destinasi Utama' => 'Wayag Karst Peak, Pianemo, Star Lagoon, Misool Jellyfish Lake, Manta Sandy',
                    'Aktivitas' => 'Snorkeling, Trekking Karst, Bird Watching Cendrawasih Merah, Kayaking',
                    'Pemandu Bertugas' => 'La Ode Rizal (PADI Divemaster) & Pemandu Lokal Adat Raja Ampat',
                    'Fasilitas Termasuk' => 'Speedboat Privat Twin-Engine, Alat Snorkeling Steril, Izin PIN Konservasi Raja Ampat, Dokumentasi Drone 4K',
                    'Meeting Point' => 'Bandara Domine Eduard Osok (SOQ), Sorong',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 1,
                'status' => 'published',
            ]
        );

        // 2. Komodo & Padar Island 3D2N Liveaboard
        Project::updateOrCreate(
            ['slug' => 'komodo-padar-island-liveaboard-safari'],
            [
                'service_id' => $marineService?->id,
                'title' => 'Komodo Island & Padar Sunrise Liveaboard Safari 3D2N',
                'vehicle_type' => 'mobil',
                'vehicle_model' => 'Kapal Phinisi Semi-Luxury',
                'client' => 'Bpk. Dimas Prakoso & Rombongan',
                'location' => 'Labuan Bajo, Nusa Tenggara Timur',
                'year' => '2025',
                'description' => 'Pelayaran magis mengarungi Taman Nasional Komodo dengan kapal Phinisi tradisional. Menyaksikan reptil purba Komodo di habitat aslinya di Pulau Rinca, sunrise tiga teluk di Pulau Padar, bersantai di pasir merah muda Pink Beach, dan berenang bersama Manta Ray.',
                'cover_image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 2,
                'dyno_hp_after' => 3,
                'dyno_torque_before' => 5,
                'dyno_torque_after' => 12,
                'modification_specs' => [
                    'Destinasi Utama' => 'Pulau Padar, Pink Beach, Pulau Komodo / Rinca, Taka Makassar, Manta Point, Pulau Kalong (Sunset Kelelawar)',
                    'Aktivitas' => 'Liveaboard Sailing, Trekking Puncak Padar, Ranger Komodo Trail, Snorkeling Manta',
                    'Pemandu Bertugas' => 'Ranger Balai TNK & Pemandu Bahari HPI NTT',
                    'Fasilitas Termasuk' => 'Kabin Ber-AC Kapal Phinisi, Koki Kapal & Full-Board Meals, Tiket Masuk TN Komodo, Action Cam Underwater',
                    'Meeting Point' => 'Bandara Komodo (LBJ), Labuan Bajo',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 2,
                'status' => 'published',
            ]
        );

        // 3. Mount Bromo & Kawah Ijen Blue Fire
        Project::updateOrCreate(
            ['slug' => 'bromo-sunrise-kawah-ijen-blue-fire-expedition'],
            [
                'service_id' => $volcanoService?->id,
                'title' => 'Mount Bromo Golden Sunrise & Ijen Blue Fire Trail 2D1N',
                'vehicle_type' => 'mobil',
                'vehicle_model' => 'Jeep 4x4 Off-Road & Private Van',
                'client' => 'Bpk. Aditya Nugraha & Pasangan',
                'location' => 'Malang & Banyuwangi, Jawa Timur',
                'year' => '2025',
                'description' => 'Petualangan gunung vulkanik legendaris Jawa Timur. Menyaksikan matahari terbit keemasan di Penanjakan Bromo dengan latar kawah mengepul dan Gunung Semeru, menyeberangi Lautan Pasir Berbisik dengan Jeep 4x4, serta pendakian malam menyaksikan fenomena api biru langka di Kawah Ijen.',
                'cover_image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 1,
                'dyno_hp_after' => 2,
                'dyno_torque_before' => 4,
                'dyno_torque_after' => 9,
                'modification_specs' => [
                    'Destinasi Utama' => 'Spot Sunrise Penanjakan 1, Kawah Aktif Bromo, Pasir Berbisik, Bukit Teletubbies, Danau Asam & Blue Fire Kawah Ijen',
                    'Aktivitas' => 'Jeep 4x4 Off-Roading, Midnight Volcano Trekking, Sunrise Viewing, Geologi Vulkanik',
                    'Pemandu Bertugas' => 'Bagas Pratama (Certified Mountaineer APGI) & Local Miner Guide Ijen',
                    'Fasilitas Termasuk' => 'Jeep 4x4 Khusus Bromo, Masker Respirator Gas Standar Ijen, Senter Kepala (Headlamp), Tiket Masuk Kawasan TNBTS & Ijen',
                    'Meeting Point' => 'Stasiun / Bandara Malang atau Surabaya',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 3,
                'status' => 'published',
            ]
        );

        // 4. Bali Cultural & Nusa Penida Coastal Trail
        Project::updateOrCreate(
            ['slug' => 'bali-cultural-heritage-nusa-penida-coastal'],
            [
                'service_id' => $cultureService?->id,
                'title' => 'Bali Spiritual Heritage & Nusa Penida Cliff Excursion 3D2N',
                'vehicle_type' => 'both',
                'vehicle_model' => 'Private Van & Fast Cruise',
                'client' => 'Ibu Maya & Sahabat',
                'location' => 'Ubud & Nusa Penida, Bali',
                'year' => '2025',
                'description' => 'Menyelami harmoni budaya dan keindahan tebing samudra pulau Dewata. Melukat penyucian jiwa di Pura Tirta Empul, berjalan di pematang sawah bertingkat Tegalalang, menyusuri tebing T-Rex Pantai Kelingking dan Pantai Diamond di Nusa Penida bersama pemandu lokal berlisensi.',
                'cover_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 2,
                'dyno_hp_after' => 3,
                'dyno_torque_before' => 6,
                'dyno_torque_after' => 14,
                'modification_specs' => [
                    'Destinasi Utama' => 'Ubud Cultural Village, Tirta Empul Temple, Tegalalang Rice Terrace, Kelingking Cliff, Broken Beach, Angel Billabong, Diamond Beach',
                    'Aktivitas' => 'Spiritual Melukat Blessing, Walking Heritage Tour, Cliff Sightseeing, Coastal Photography',
                    'Pemandu Bertugas' => 'I Wayan Arta (HPI Bali Senior Cultural Guide)',
                    'Fasilitas Termasuk' => 'Private Transport Mobil Ber-AC, Tiket Fastboat PP Sanur-Nusa Penida, Sarung Masuk Pura, Donasi Upacara Adat',
                    'Meeting Point' => 'Bandara I Gusti Ngurah Rai (DPS) / Hotel Area Kuta-Sanur-Ubud',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 4,
                'status' => 'published',
            ]
        );

        // 5. Tana Toraja Ancestral Heritage Trail
        Project::updateOrCreate(
            ['slug' => 'tana-toraja-ancestral-heritage-trail'],
            [
                'service_id' => $cultureService?->id,
                'title' => 'Tana Toraja Sacred Ancestral Culture & Mist Mountain 4D3N',
                'vehicle_type' => 'mobil',
                'vehicle_model' => 'High-Clearance Tourist Van',
                'client' => 'Bpk. Hendra & Rekan Fotografi',
                'location' => 'Tana Toraja & Toraja Utara, Sulawesi Selatan',
                'year' => '2025',
                'description' => 'Ekspedisi mendalam ke jantung kebudayaan megalitik Toraja. Mengunjungi desa kuno Kete Kesu dengan rumah adat Tongkonan beratap perahu, makam tebing batu Lemo & kuburan bayi di pohon Passiliran, serta lanskap negeri di atas awan Lolai.',
                'cover_image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 3,
                'dyno_hp_after' => 4,
                'dyno_torque_before' => 6,
                'dyno_torque_after' => 11,
                'modification_specs' => [
                    'Destinasi Utama' => 'Desa Adat Kete Kesu, Kuburan Tebing Lemo & Londa, Bori Kalimbuang (Menhir Megalitik), Puncak Lolai Negeri di Atas Awan',
                    'Aktivitas' => 'Eksplorasi Budaya Rambu Solo/Tuka, Fotografi Arsitektur Tongkonan, Coffee Tasting Kopi Arabika Toraja',
                    'Pemandu Bertugas' => 'Budayawan & Pemandu Senior HPI Toraja',
                    'Fasilitas Termasuk' => 'Transportasi Privat Makassar-Toraja PP, Penginapan Heritage Toraja, Izin Masuk Objek Budaya, Pemandu Adat',
                    'Meeting Point' => 'Bandara Sultan Hasanuddin (UPG), Makassar',
                ],
                'is_featured' => true,
                'is_recent' => false,
                'order' => 5,
                'status' => 'published',
            ]
        );
    }
}
