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
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1920&auto=format&fit=crop',
                'title' => 'PREMIUM MOTORCYCLE & CAR CUSTOM WORKSHOP',
                'subtitle' => 'Pusat modifikasi performa tinggi, Dyno Jet tuning, fabrikasi bodykit widebody, cat oven Spies Hecker, dan custom build motor berstandar kontes.',
                'button_text' => 'BOOKING SEKARANG',
                'button_link' => '/booking',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=1920&auto=format&fit=crop',
                'title' => 'HANDMADE CAFE RACER & CUSTOM BIKE BUILD',
                'subtitle' => 'Wujudkan impian motor custom Anda bersama master builder berpengalaman. Rangka kromoli, tangki monocoque, dan performa mesin terkalibrasi.',
                'button_text' => 'LIHAT PORTOFOLIO',
                'button_link' => '/portfolio',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1920&auto=format&fit=crop',
                'title' => 'ECU REMAPPING & DYNO JET 224xLC TEST',
                'subtitle' => 'Maksimalkan potensi tenaga dan torsi kendaraan Anda hingga +35% dengan kalibrasi ECU real-time di atas mesin Dyno resmi.',
                'button_text' => 'KONSULTASI GRATIS',
                'button_link' => '/contact-us',
                'order' => 3,
                'is_active' => true,
            ],
        ];
        foreach ($slides as $slide) {
            HeroSlide::create($slide);
        }

        // 2. Partner Brands
        Client::truncate();
        $brands = [
            ['name' => 'Brembo Brakes', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Brembo_logo.svg/320px-Brembo_logo.svg.png', 'website_url' => 'https://www.brembo.com', 'order' => 1, 'is_active' => true],
            ['name' => 'Akrapovic Exhaust', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/91/Akrapovi%C4%8D_logo.svg/320px-Akrapovi%C4%8D_logo.svg.png', 'website_url' => 'https://www.akrapovic.com', 'order' => 2, 'is_active' => true],
            ['name' => 'Ohlins Suspension', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/%C3%96hlins_logo.svg/320px-%C3%96hlins_logo.svg.png', 'website_url' => 'https://www.ohlins.com', 'order' => 3, 'is_active' => true],
            ['name' => 'HKS Japan', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/HKS_logo.svg/320px-HKS_logo.svg.png', 'website_url' => 'https://www.hks-power.co.jp', 'order' => 4, 'is_active' => true],
            ['name' => 'BBS Forged Wheels', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cb/BBS_Kraftfahrzeugtechnik_Logo.svg/320px-BBS_Kraftfahrzeugtechnik_Logo.svg.png', 'website_url' => 'https://bbs.com', 'order' => 5, 'is_active' => true],
            ['name' => 'Motul Lubricants', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Motul_Logo.svg/320px-Motul_Logo.svg.png', 'website_url' => 'https://www.motul.com', 'order' => 6, 'is_active' => true],
        ];
        foreach ($brands as $b) {
            Client::create($b);
        }

        // 3. Awards
        Award::truncate();
        $awards = [
            [
                'title' => 'Best Tuner of the Year 2025 — IMX',
                'slug' => 'best-tuner-year-2025',
                'image' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=800&auto=format&fit=crop',
                'description' => 'Penghargaan atas riset kalibrasi ECU dan efisiensi tenaga mesin turbo tertinggi di ajang Indonesia Modification Expo (IMX) 2025.',
                'published_date' => '2025-10-15',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'The King of Custom Bike Builder — Kustomfest',
                'slug' => 'king-custom-bike-builder',
                'image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=800&auto=format&fit=crop',
                'description' => 'Juara 1 kategori Custom Cafe Racer dengan mahakarya Honda CB750 The Phantom di Kustomfest Indonesia.',
                'published_date' => '2025-08-20',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Master Paint & Finish Excellence — Spies Hecker',
                'slug' => 'master-paint-finish-excellence',
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=800&auto=format&fit=crop',
                'description' => 'Standar kualitas pengecatan oven dan teknik Candy Clear terbaik dengan garansi 2 tahun dari Spies Hecker.',
                'published_date' => '2024-12-10',
                'order' => 3,
                'is_active' => true,
            ],
        ];
        foreach ($awards as $aw) {
            Award::create($aw);
        }

        // 4. Testimonials
        Testimonial::truncate();
        $testimonials = [
            [
                'client_name' => 'Bpk. Steven Kurniawan',
                'client_company' => 'Owner Nissan GT-R R35 LBWK (850 HP)',
                'message' => 'Hasil dyno tuning dan pengerjaan widebody kit di BENGKEL benar-benar melampaui ekspektasi. Mesin sangat responsif, boost stabil, dan fitting bodykit super rapi tanpa celah!',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Bpk. Dimas Prakoso',
                'client_company' => 'Owner Honda CB750 "The Phantom" Cafe Racer',
                'message' => 'Detail pengerjaan subframe dan tangki handmade aluminium sangat artistik. Motor tua saya sekarang jadi pusat perhatian kemanapun saya riding. Highly recommended!',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Rian Aditya',
                'client_company' => 'Owner Honda Civic Type R FL5',
                'message' => 'Fitur booking onlinenya praktis banget, bisa bayar DP lewat QRIS langsung terkonfirmasi otomatis. Live tracker progres pengerjaannya juga bikin tenang memantau unit dari kantor.',
                'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
            ],
        ];
        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // 5. Customer Vehicles (Real & Demo)
        Vehicle::truncate();
        $cust1 = User::where('email', 'customer@gmail.com')->first();
        $cust2 = User::where('email', 'bambang@gmail.com')->first();
        $demoCust = User::where('email', 'democustomer@bengkel.com')->first();

        if ($cust1) {
            Vehicle::create([
                'user_id' => $cust1->id,
                'type' => 'mobil',
                'brand' => 'Honda',
                'model' => 'Civic Type R FL5',
                'license_plate' => 'B 1999 APX',
                'year' => '2024',
                'color' => 'Championship White',
                'engine_cc' => '2000cc VTEC Turbo',
                'transmission' => 'manual',
            ]);
            Vehicle::create([
                'user_id' => $cust1->id,
                'type' => 'motor',
                'brand' => 'Kawasaki',
                'model' => 'Ninja ZX-25R',
                'license_plate' => 'B 4444 RAC',
                'year' => '2023',
                'color' => 'Lime Green Racing',
                'engine_cc' => '250cc Inline-4',
                'transmission' => 'manual',
            ]);
        }

        if ($demoCust) {
            Vehicle::create([
                'user_id' => $demoCust->id,
                'type' => 'mobil',
                'brand' => 'Toyota',
                'model' => 'GR Yaris High Performance',
                'license_plate' => 'B 7777 DEM',
                'year' => '2024',
                'color' => 'Precious Metal',
                'engine_cc' => '1600cc Turbo 4WD',
                'transmission' => 'manual',
            ]);
            Vehicle::create([
                'user_id' => $demoCust->id,
                'type' => 'motor',
                'brand' => 'Ducati',
                'model' => 'Panigale V2 Bayliss',
                'license_plate' => 'B 9999 DMO',
                'year' => '2023',
                'color' => 'Bayliss Special Livery',
                'engine_cc' => '955cc Superquadro',
                'transmission' => 'manual',
            ]);
        }

        // 6. Mechanics & Attendances (Past and Today with camera selfie photo simulation)
        Attendance::truncate();
        $mechanics = User::where('role', 'karyawan')->get();
        $today = Carbon::today();

        // Sample camera snapshot placeholder (Webcam image URI)
        $sampleCamPhoto = 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?q=80&w=400&auto=format&fit=crop';
        $sampleCamPhoto2 = 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=400&auto=format&fit=crop';

        foreach ($mechanics as $idx => $m) {
            // Absensi Hari Ini
            Attendance::create([
                'user_id' => $m->id,
                'date' => $today->toDateString(),
                'check_in_time' => sprintf('08:%02d:15', 10 + ($idx * 5)),
                'check_in_photo' => $sampleCamPhoto,
                'check_in_lat' => -6.30123400,
                'check_in_lng' => 106.81234500,
                'check_out_time' => null, // Still on shift
                'status' => 'hadir',
                'work_summary' => 'Menangani kalibrasi ECU Honda Civic Type R dan fabrikasi pipa knalpot titanium ZX-25R.',
                'notes' => 'Hadir tepat waktu di workshop.',
            ]);

            // Absensi Kemarin
            Attendance::create([
                'user_id' => $m->id,
                'date' => $today->copy()->subDay()->toDateString(),
                'check_in_time' => '08:20:00',
                'check_in_photo' => $sampleCamPhoto,
                'check_in_lat' => -6.30123400,
                'check_in_lng' => 106.81234500,
                'check_out_time' => '17:45:00',
                'check_out_photo' => $sampleCamPhoto2,
                'check_out_lat' => -6.30123400,
                'check_out_lng' => 106.81234500,
                'status' => 'hadir',
                'work_summary' => 'Selesai pengerjaan dyno run 5 mobil dan servis berkala moge.',
                'notes' => 'Shift selesai dengan lancar.',
            ]);
        }

        // 7. Bookings & Payments
        Booking::truncate();
        Payment::truncate();
        BookingLog::truncate();

        $leadMekanik = $mechanics->first();
        $demoMekanik = User::where('email', 'demomekanik@bengkel.com')->first() ?? $leadMekanik;
        $remapService = Service::where('slug', 'ecu-remap-dyno-tuning')->first();
        $bikeService = Service::where('slug', 'custom-motorcycle-build')->first();
        $bodyService = Service::where('slug', 'widebody-custom-aerokit')->first();

        // Booking 1: In Progress with Payment Gateway DP Paid (Real Customer)
        $b1 = Booking::create([
            'booking_code' => 'BK-' . date('Ym') . '-0001',
            'customer_id' => $cust1?->id,
            'karyawan_id' => $leadMekanik?->id,
            'service_id' => $remapService?->id,
            'customer_name' => 'Rian Aditya',
            'customer_email' => 'customer@gmail.com',
            'customer_phone' => '081122334455',
            'vehicle_type' => 'mobil',
            'vehicle_brand' => 'Honda',
            'vehicle_model' => 'Civic Type R FL5',
            'license_plate' => 'B 1999 APX',
            'vehicle_year' => '2024',
            'vehicle_color' => 'Championship White',
            'booking_date' => $today->toDateString(),
            'booking_time_slot' => '10:00 WIB',
            'custom_request' => 'Remap ECU Stage 2 + Pop and Bang Map + Pemasangan Downpipe HKS.',
            'mechanic_notes' => 'Unit sudah dinaikkan ke atas Dyno Jet. Baseline dyno run mencatatkan 315 WHP. Sedang dalam proses tuning fuel map & boost controller.',
            'progress_percentage' => 65,
            'status' => 'in_progress',
            'total_amount' => 5500000,
            'dp_amount' => 1500000,
            'paid_amount' => 1500000,
            'payment_status' => 'dp_paid',
            'payment_method' => 'qris',
            'payment_ref' => 'QRIS-APX-882910',
            'payment_token' => 'snap-token-simulation-001',
            'progress_photos' => [
                'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=600&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=600&auto=format&fit=crop',
            ],
        ]);

        // Payment for Booking 1
        Payment::create([
            'booking_id' => $b1->id,
            'user_id' => $cust1?->id,
            'transaction_code' => Payment::generateTransactionCode(),
            'amount' => 1500000,
            'payment_type' => 'dp',
            'payment_method' => 'qris',
            'payment_channel' => 'QRIS Instant Payment',
            'status' => 'settlement',
            'gateway_reference' => 'QRIS-APX-882910',
            'paid_at' => Carbon::now()->subHours(2),
        ]);

        // Logs for Booking 1
        BookingLog::create([
            'booking_id' => $b1->id,
            'user_id' => $leadMekanik?->id,
            'stage' => 'received',
            'title' => 'Kendaraan Diterima di Workshop',
            'description' => 'Unit Honda Civic Type R FL5 (B 1999 APX) telah diterima oleh Lead Tuner Budi Santoso.',
        ]);
        BookingLog::create([
            'booking_id' => $b1->id,
            'user_id' => $leadMekanik?->id,
            'stage' => 'machining_dyno',
            'title' => 'Dyno Run Baseline & Calibration',
            'description' => 'Uji dyno awal mencatatkan 315 HP. Sedang dilakukan penulisan map ECU Stage 2.',
        ]);

        // Booking 2: Pending (Real Customer 2)
        Booking::create([
            'booking_code' => 'BK-' . date('Ym') . '-0002',
            'customer_id' => $cust2?->id,
            'karyawan_id' => null,
            'service_id' => $bikeService?->id,
            'customer_name' => 'Bambang Sudiro',
            'customer_email' => 'bambang@gmail.com',
            'customer_phone' => '081333445566',
            'vehicle_type' => 'motor',
            'vehicle_brand' => 'Yamaha',
            'vehicle_model' => 'XSR 155',
            'license_plate' => 'B 3030 YMH',
            'vehicle_year' => '2023',
            'vehicle_color' => 'Matte Black',
            'booking_date' => $today->copy()->addDays(2)->toDateString(),
            'booking_time_slot' => '13:00 WIB',
            'custom_request' => 'Konversi full Cafe Racer: potong subframe, ganti stang clip-on, spion bar end, knalpot full system Megaphone.',
            'mechanic_notes' => null,
            'progress_percentage' => 0,
            'status' => 'pending',
            'total_amount' => 12500000,
            'dp_amount' => 2500000,
            'paid_amount' => 0,
            'payment_status' => 'unpaid',
            'payment_method' => 'midtrans',
        ]);

        // Booking 3: Demo Booking (Assigned to Demo Customer & Demo Mekanik)
        if ($demoCust) {
            $bDemo = Booking::create([
                'booking_code' => 'BK-' . date('Ym') . '-0003',
                'customer_id' => $demoCust->id,
                'karyawan_id' => $demoMekanik?->id,
                'service_id' => $remapService?->id,
                'customer_name' => 'Demo Customer',
                'customer_email' => 'democustomer@bengkel.com',
                'customer_phone' => '081299112233',
                'vehicle_type' => 'mobil',
                'vehicle_brand' => 'Toyota',
                'vehicle_model' => 'GR Yaris High Performance',
                'license_plate' => 'B 7777 DEM',
                'vehicle_year' => '2024',
                'vehicle_color' => 'Precious Metal',
                'booking_date' => $today->toDateString(),
                'booking_time_slot' => '14:00 WIB',
                'custom_request' => 'Pemasangan Dyno ECU Remap Stage 1 + Custom Exhaust Header Simulation.',
                'mechanic_notes' => 'Unit sedang dalam persiapan Dyno Jet test oleh tim mekanik demo.',
                'progress_percentage' => 45,
                'status' => 'in_progress',
                'total_amount' => 4800000,
                'dp_amount' => 1000000,
                'paid_amount' => 1000000,
                'payment_status' => 'dp_paid',
                'payment_method' => 'qris',
                'payment_ref' => 'QRIS-DEMO-007788',
                'payment_token' => 'snap-token-simulation-demo',
                'progress_photos' => [
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=600&auto=format&fit=crop',
                ],
            ]);

            Payment::create([
                'booking_id' => $bDemo->id,
                'user_id' => $demoCust->id,
                'transaction_code' => Payment::generateTransactionCode(),
                'amount' => 1000000,
                'payment_type' => 'dp',
                'payment_method' => 'qris',
                'payment_channel' => 'QRIS Instant Payment Demo',
                'status' => 'settlement',
                'gateway_reference' => 'QRIS-DEMO-007788',
                'paid_at' => Carbon::now()->subHour(),
            ]);

            BookingLog::create([
                'booking_id' => $bDemo->id,
                'user_id' => $demoMekanik?->id,
                'stage' => 'received',
                'title' => 'Kendaraan Demo Diterima',
                'description' => 'Unit Toyota GR Yaris diterima untuk pengujian dyno dan remap.',
            ]);
        }

        // 8. Blog Posts & Categories
        BlogCategory::truncate();
        BlogPost::truncate();

        $c1 = BlogCategory::create(['title' => 'Tuning & Performa', 'slug' => 'tuning-performa']);
        $c2 = BlogCategory::create(['title' => 'Kustomisasi Motor', 'slug' => 'kustomisasi-motor']);
        $c3 = BlogCategory::create(['title' => 'Tips & Perawatan', 'slug' => 'tips-perawatan']);

        BlogPost::create([
            'blog_category_id' => $c1->id,
            'title' => 'Panduan Lengkap Remap ECU Stage 1, 2, dan 3: Apa Bedanya?',
            'slug' => 'panduan-lengkap-remap-ecu-stage-1-2-3',
            'excerpt' => 'Pelajari perbedaan peningkatan tenaga, komponen pendukung yang wajib diganti, dan risiko setiap tahapan remap ECU mobil dan motor.',
            'content' => '<p>Remap ECU (Engine Control Unit) merupakan metode paling efektif untuk meningkatkan tenaga dan torsi mesin tanpa perlu membongkar jeroan mesin...</p>',
            'cover_image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=800&auto=format&fit=crop',
            'is_published' => true,
            'published_at' => Carbon::now()->subDays(3),
        ]);

        BlogPost::create([
            'blog_category_id' => $c2->id,
            'title' => '5 Konsep Modifikasi Motor Paling Populer: Dari Cafe Racer Hingga Bobber',
            'slug' => '5-konsep-modifikasi-motor-paling-populer',
            'excerpt' => 'Karakteristik unik subframe, posisi riding, stang, dan pemilihan tangki bensin untuk gaya motor custom impian Anda.',
            'content' => '<p>Dunia motor custom terus berkembang dengan beragam aliran yang mencerminkan karakter pemiliknya...</p>',
            'cover_image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=800&auto=format&fit=crop',
            'is_published' => true,
            'published_at' => Carbon::now()->subDays(7),
        ]);

        // 9. Contact Inquiries
        ContactMessage::truncate();
        ContactMessage::create([
            'name' => 'Faisal Akbar',
            'email' => 'faisal.akbar@gmail.com',
            'company' => 'Toyota FT86 Club Indonesia',
            'message' => 'Halo tim BENGKEL, saya ingin menanyakan paket air suspension 4 titik untuk Toyota FT86 2020 lengkap dengan pemasangan dan hardline setup di bagasi. Berapa estimasi total biaya dan waktu pengerjaannya? Terima kasih.',
            'is_read' => false,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
