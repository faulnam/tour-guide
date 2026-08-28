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
                'value' => 'BENGKEL Performance & Custom Workshop',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Headline',
            ],
            [
                'key' => 'home_hero_description',
                'value' => 'Bengkel spesialis modifikasi performa tinggi, ECU remap dyno tuning, fabrikasi bodykit widebody, cat oven Spies Hecker, custom bike builder, air suspension, dan servis berkala terlengkap di Jakarta.',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Description',
            ],
            [
                'key' => 'home_recent_projects_eyebrow',
                'value' => 'Hasil Modifikasi Terbaru',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Eyebrow',
            ],
            [
                'key' => 'home_recent_projects_subtitle',
                'value' => 'Mahakarya modifikasi motor & mobil dengan presisi tinggi dan lonjakan tenaga teruji di atas mesin Dyno.',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Subtitle',
            ],
            [
                'key' => 'home_services_eyebrow',
                'value' => 'Layanan & Paket Modifikasi',
                'page' => 'home',
                'section' => 'services',
                'label' => 'Services Section Eyebrow',
            ],
            [
                'key' => 'home_services_subtitle',
                'value' => 'Pilihan paket pengerjaan profesional dengan jaminan garansi resmi dan suku cadang performa orisinil.',
                'page' => 'home',
                'section' => 'services',
                'label' => 'Services Section Subtitle',
            ],
            [
                'key' => 'home_cta_title',
                'value' => 'Siap Meningkatkan Performa & Tampilan Kendaraan Anda?',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Title',
            ],
            [
                'key' => 'home_cta_subtitle',
                'value' => 'Booking antrean servis & konsultasi modifikasi online sekarang dengan DP terjangkau via Payment Gateway.',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Subtitle',
            ],

            // About Us Page
            [
                'key' => 'about_who_we_are_title',
                'value' => 'Tentang BENGKEL',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Title',
            ],
            [
                'key' => 'about_who_we_are_text',
                'value' => 'Berdiri sejak 2012, BENGKEL telah menjadi destinasi utama bagi para car & motorcycle enthusiast di Indonesia. Dilengkapi fasilitas canggih mulai dari Dyno Jet 224xLC All-Wheel Drive, Spray Booth Oven Jerman, 3D Laser Scanner, hingga mesin bubut CNC presisi tinggi.',
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
                'value' => 'Menghadirkan standar modifikasi otomotif kelas dunia dengan mengutamakan aspek keselamatan, durabilitas, estetika tinggi, dan lonjakan performa yang terukur secara ilmiah dan transparan.',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Mission Text',
            ],

            // Booking Intro
            [
                'key' => 'booking_intro_title',
                'value' => 'Online Booking & Service Queue',
                'page' => 'booking',
                'section' => 'intro',
                'label' => 'Booking Intro Title',
            ],
            [
                'key' => 'booking_intro_subtitle',
                'value' => 'Pilih jadwal kedatangan, konsultasikan modifikasi yang diinginkan, dan bayar aman dengan Payment Gateway terverifikasi instan.',
                'page' => 'booking',
                'section' => 'intro',
                'label' => 'Booking Intro Subtitle',
            ],

            // Contact Page
            [
                'key' => 'contact_intro_title',
                'value' => 'Hubungi Workshop Kami',
                'page' => 'contact',
                'section' => 'intro',
                'label' => 'Contact Intro Title',
            ],
            [
                'key' => 'contact_intro_text',
                'value' => 'Kunjungi workshop kami di Cilandak, Jakarta Selatan atau hubungi hotline WhatsApp kami untuk konsultasi gratis mengenai spesifikasi modifikasi dan estimasi waktu pengerjaan.',
                'page' => 'contact',
                'section' => 'intro',
                'label' => 'Contact Intro Text',
            ],
        ];

        foreach ($contents as $item) {
            PageContent::updateOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
