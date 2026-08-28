<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ECU Remap & Dyno Tuning (Mobil & Motor)
        $s1 = Service::updateOrCreate(
            ['slug' => 'ecu-remap-dyno-tuning'],
            [
                'title' => 'ECU Remapping & Dyno Jet Test',
                'vehicle_type' => 'both',
                'category' => 'tuning_dyno',
                'excerpt' => 'Optimasi tenaga mesin (HP & Torsi) hingga +35% dengan kalibrasi ECU profesional di mesin Dyno Jet 224xLC.',
                'description' => 'Layanan kalibrasi ECU on-the-fly untuk mobil turbo, bensin, diesel common rail, dan moge/motor sport. Dikalibrasi langsung di atas mesin Dyno Jet 224xLC bersertifikasi internasional untuk efisiensi bahan bakar dan performa puncak yang aman.',
                'base_price' => 2500000,
                'estimated_duration' => '1 Hari (4-6 Jam)',
                'warranty' => 'Garansi Software Seumur Hidup + 1x Free Fine Tuning',
                'features' => [
                    'Before & After Dyno Graph Sheet',
                    'Pop & Bang / Flame Map Options',
                    'Speed & RPM Limiter Removal',
                    'Optimasi Air-Fuel Ratio (AFR)',
                    'Safe Boost & Timing Calibration',
                ],
                'icon' => 'gauge-high',
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1000&auto=format&fit=crop',
                'order' => 1,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 2. Custom Bike Build & Cafe Racer (Motor)
        $s2 = Service::updateOrCreate(
            ['slug' => 'custom-motorcycle-build'],
            [
                'title' => 'Custom Motorcycle Build (Cafe Racer & Bobber)',
                'vehicle_type' => 'motor',
                'category' => 'modifikasi',
                'excerpt' => 'Fabrikasi rangka custom, tangki handmade, pengerjaan Cafe Racer, Scrambler, Bobber, dan Chopper.',
                'description' => 'Ubah motor standar Anda menjadi mahakarya custom handmade. Tim desainer dan builder kami menangani mulai dari perancangan subframe, tangki bensin plat galvanis handmade, knalpot stainless custom, hingga sistem kelistrikan tersembunyi berstandar kontes.',
                'base_price' => 12500000,
                'estimated_duration' => '14 - 30 Hari Kerja',
                'warranty' => 'Garansi Rangka & Konstruksi 1 Tahun',
                'features' => [
                    'Desain 3D Konsep Kustomisasi',
                    'Subframe & Swingarm Fabrikasi Khusus',
                    'Tangki & Body Billet/Plat Handmade',
                    'Custom Exhaust Stainless 304 / Titanium',
                    'Jok Kulit Asli Hand-Stitched',
                ],
                'icon' => 'motorcycle',
                'image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=1000&auto=format&fit=crop',
                'order' => 2,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 3. Widebody & Custom Aero Kit (Mobil)
        $s3 = Service::updateOrCreate(
            ['slug' => 'widebody-custom-aerokit'],
            [
                'title' => 'Widebody Kit & Carbon Fiber Aero',
                'vehicle_type' => 'mobil',
                'category' => 'body_paint',
                'excerpt' => 'Fabrikasi Widebody Kit, Overfender, Splitter Carbon Fiber, Ducktail, dan GT Wing agresif presisi tinggi.',
                'description' => 'Pembuatan bodi kit custom presisi menggunakan material FRP high-grade dan Real Dry Carbon Fiber. Dibuat dengan pemodelan 3D scanning untuk fitting sempurna tanpa celah layaknya kit pabrikan ternama.',
                'base_price' => 18000000,
                'estimated_duration' => '10 - 21 Hari Kerja',
                'warranty' => 'Garansi Pemasangan & Fitting 1 Tahun',
                'features' => [
                    '3D Digital Laser Scanning & Fitting',
                    'Material FRP & Real Carbon Fiber Infusion',
                    'Custom Front Splitter, Side Skirt, Diffuser',
                    'Overfender Widebody Stance Presisi',
                    'Pengecatan Oven Standar Pabrikan',
                ],
                'icon' => 'car-burst',
                'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1000&auto=format&fit=crop',
                'order' => 3,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 4. Custom Paint, Airbrush & Cat Oven Spies Hecker (Motor & Mobil)
        $s4 = Service::updateOrCreate(
            ['slug' => 'custom-paint-oven-airbrush'],
            [
                'title' => 'Custom Paint, Airbrush & Cat Oven Spies Hecker',
                'vehicle_type' => 'both',
                'category' => 'body_paint',
                'excerpt' => 'Pengecatan full body di ruang Oven berteknologi Spies Hecker Jerman: Candy Paint, Chameleon, Livery Racing.',
                'description' => 'Fasilitas Spray Booth Oven bebas debu dengan cat premium Spies Hecker & Glasurit. Menawarkan efek warna eksklusif mulai dari Candy Red, Chameleon ChromaFlair, Satin Chrome, hingga Realist Airbrush Grafis balap.',
                'base_price' => 4500000,
                'estimated_duration' => '5 - 12 Hari Kerja',
                'warranty' => 'Garansi Cat 2 Tahun Bebas Pudar & Mengelupas',
                'features' => [
                    'Dust-Free Down-Draft Spray Booth Oven',
                    'Spies Hecker & Glasurit Paint Material',
                    'Custom Candy, Pearl & Chameleon Finish',
                    '5x Lapisan Clear Coat High-Solid Gloss',
                    'Polishing 3-Step Finishing Mirror Look',
                ],
                'icon' => 'spray-can-sparkles',
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1000&auto=format&fit=crop',
                'order' => 4,
                'is_popular' => false,
                'is_active' => true,
            ]
        );

        // 5. Air Suspension & Big Brake Kit (Mobil & Motor)
        $s5 = Service::updateOrCreate(
            ['slug' => 'air-suspension-big-brake-kit'],
            [
                'title' => 'Air Suspension Management & Big Brake Kit',
                'vehicle_type' => 'mobil',
                'category' => 'kaki_kaki',
                'excerpt' => 'Instalasi Air Suspension 2/4 titik dengan remote Bluetooth manajemen pintar + Big Brake Kit 4/6 Pot.',
                'description' => 'Sistem suspensi udara canggih untuk stance ceper maksimal namun tetap nyaman untuk harian. Dilengkapi manajemen ketinggian otomatis via smartphone, kompresor senyap, serta upgrade pengereman Big Brake Kit (Brembo/AP Racing).',
                'base_price' => 22000000,
                'estimated_duration' => '3 - 5 Hari Kerja',
                'warranty' => 'Garansi Airbag & Kompresor 1 Tahun',
                'features' => [
                    'Air Suspension Kit 2/4 Point Smart System',
                    'Bluetooth & Hardwire Controller Display',
                    'Big Brake Kit 4/6 Pot Caliper + Floating Disc',
                    'Braided Brake Lines Stainless Steel',
                    'Free Wheel Alignment & Camber Adjustment',
                ],
                'icon' => 'gears',
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=1000&auto=format&fit=crop',
                'order' => 5,
                'is_popular' => false,
                'is_active' => true,
            ]
        );

        // 6. Ceramic Coating & Auto Detailing 9H (Motor & Mobil)
        $s6 = Service::updateOrCreate(
            ['slug' => 'ceramic-coating-detailing-9h'],
            [
                'title' => 'Nano Ceramic Coating 9H & Ultimate Detailing',
                'vehicle_type' => 'both',
                'category' => 'detailing_coating',
                'excerpt' => 'Proteksi cat kilau kaca permanen dengan 3 layer Nano Ceramic 9H, Paint Correction, dan Interior Treatment.',
                'description' => 'Perawatan cat tingkat tertinggi untuk menghilangkan goresan halus (swirl marks) hingga 95%. Dilapisi Nano Ceramic Coating 9H memberikan efek hidrofobik daun talas ekstrem, perlindungan sinar UV, dan kilap tahan hingga 3 tahun.',
                'base_price' => 1500000,
                'estimated_duration' => '1 - 2 Hari',
                'warranty' => 'Garansi Kilap & Garansi Maintenance 3 Tahun',
                'features' => [
                    'Multi-Stage Paint Correction (Menghilangkan Swirls)',
                    '3-Layer 9H Nano Ceramic Glass Coating',
                    'Hydrophobic Water Beading Effect Ekstrem',
                    'Engine Bay Detailing & Dressing',
                    'Interior Deep Clean + Fogging Anti-Bakteri',
                ],
                'icon' => 'sparkles',
                'image' => 'https://images.unsplash.com/photo-1520340356584-f9917d1eea6f?q=80&w=1000&auto=format&fit=crop',
                'order' => 6,
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        // 7. Tune Up Performa & Servis Berkala (Motor & Mobil)
        $s7 = Service::updateOrCreate(
            ['slug' => 'tune-up-performa-servis-berkala'],
            [
                'title' => 'Tune Up Performa & Servis Berkala Lengkap',
                'vehicle_type' => 'both',
                'category' => 'servis_berkala',
                'excerpt' => 'Servis berkala, gurah mesin carbon cleaner, flushing oli matic/manual, kalibrasi injektor, dan scanner diagnostik.',
                'description' => 'Servis komprehensif mengembalikan tenaga mesin seperti baru. Pemeriksaan 40 titik kendaraan, pembersihan ruang bakar tanpa bongkar mesin, flushing cairan rem, dan penggantian oli performa tinggi.',
                'base_price' => 750000,
                'estimated_duration' => '2 - 3 Jam',
                'warranty' => 'Garansi Servis 1 Bulan / 1.000 KM',
                'features' => [
                    'Pemeriksaan 40 Titik Kondisi Kendaraan',
                    'Carbon Cleaner / Gurah Ruang Bakar',
                    'Ultrasonic Cleaning Nozzle Injektor',
                    'OBD2 Computer Diagnostics Scan',
                    'Free Cuci & Vakum Mobil/Motor',
                ],
                'icon' => 'wrench',
                'image' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=1000&auto=format&fit=crop',
                'order' => 7,
                'is_popular' => false,
                'is_active' => true,
            ]
        );
    }
}
