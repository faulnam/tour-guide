<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            // Home Page
            [
                'key' => 'home_hero_title',
                'value' => 'Jelajahi Keajaiban Nusantara Bersama Pemandu Lokal Berlisensi Resmi',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Headline',
            ],
            [
                'key' => 'home_hero_description',
                'value' => 'Layanan pemandu wisata privat & ekspedisi alam terbaik di Indonesia. Nikmati keindahan Raja Ampat, Labuan Bajo, Bromo, Bali, hingga Tana Toraja dengan aman, nyaman, dan kaya wawasan budaya bersama pemandu resmi bersertifikasi HPI.',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Description',
            ],
            [
                'key' => 'home_recent_projects_eyebrow',
                'value' => 'Destinasi Unggulan & Ekspedisi Terbaru',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Eyebrow',
            ],
            [
                'key' => 'home_recent_projects_subtitle',
                'value' => 'Dokumentasi perjalanan nyata para traveler menjelajahi surga tersembunyi Indonesia bersama tim pemandu kami.',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Subtitle',
            ],
            [
                'key' => 'home_services_eyebrow',
                'value' => 'Layanan & Paket Pemandu Wisata',
                'page' => 'home',
                'section' => 'services',
                'label' => 'Services Section Eyebrow',
            ],
            [
                'key' => 'home_services_subtitle',
                'value' => 'Pilihan layanan pemandu privat, wisata bahari & liveaboard, pendakian gunung vulkanik, hingga tur budaya & fotografi profesional.',
                'page' => 'home',
                'section' => 'services',
                'label' => 'Services Section Subtitle',
            ],
            [
                'key' => 'home_cta_title',
                'value' => 'Siap Mewujudkan Liburan Impian Anda di Indonesia?',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Title',
            ],
            [
                'key' => 'home_cta_subtitle',
                'value' => 'Booking pemandu wisata privat Anda sekarang dengan proses mudah, jadwal fleksibel, dan kunci jadwal dengan DP terjangkau.',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Subtitle',
            ],

            // About Us Page
            [
                'key' => 'about_who_we_are_title',
                'value' => 'Tentang Nusantara Tour Guide',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Title',
            ],
            [
                'key' => 'about_who_we_are_text',
                'value' => 'Berdiri sejak 2016, Nusantara Tour Guide berkomitmen menghadirkan pengalaman liburan autentik dan mendalam di seluruh pelosok Indonesia. Seluruh pemandu kami adalah putra daerah asli berlisensi resmi HPI (Himpunan Pramuwisata Indonesia) dan APGI yang terlatih dalam standar pertolongan pertama, etika konservasi alam, serta keramahtamahan khas Indonesia.',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Text',
            ],
            [
                'key' => 'about_mission_title',
                'value' => 'Visi & Misi Kami',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Mission Title',
            ],
            [
                'key' => 'about_mission_text',
                'value' => 'Menjadi platform pemandu wisata terdepan dan terpercaya di Indonesia yang menghubungkan wisatawan dengan keindahan alam, kearifan lokal, dan pemberdayaan ekonomi masyarakat pariwisata berkelanjutan (sustainable eco-tourism).',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Mission Text',
            ],

            // Values
            [
                'key' => 'about_values_title',
                'value' => 'Standar Keunggulan Pemandu Kami',
                'page' => 'about',
                'section' => 'values',
                'label' => 'About - Values Title',
            ],
            [
                'key' => 'about_values_text',
                'value' => '100% Pemandu Resmi Bersertifikat | Berorientasi Keselamatan & First-Aid | Fleksibilitas Waktu Penuh | Narasi Budaya yang Kaya & Mendalam | Menghormati Adat & Kelestarian Alam.',
                'page' => 'about',
                'section' => 'values',
                'label' => 'About - Values Text',
            ],

            // Safety & Quality Assurance
            [
                'key' => 'about_facility_title',
                'value' => 'Standar Keamanan, Lisensi & Armada',
                'page' => 'about',
                'section' => 'facilities',
                'label' => 'About - Facility Title',
            ],
            [
                'key' => 'about_facility_text',
                'value' => 'Didukung armada mobil wisata terawat, perlengkapan snorkeling steril, kapal Phinisi standar keselamatan maritim, alat navigasi GPS, serta perlengkapan respirator pendakian gunung yang selalu diinspeksi secara berkala demi keselamatan wisatawan.',
                'page' => 'about',
                'section' => 'facilities',
                'label' => 'About - Facility Text',
            ],
        ];

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                ['key' => $content['key']],
                $content
            );
        }
    }
}
