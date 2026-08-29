<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Info
            ['key' => 'site_title', 'value' => 'Nusantara Tour Guide — Pemandu Wisata Berlisensi Resmi HPI & Ekspedisi Indonesia', 'group' => 'general', 'type' => 'text'],
            ['key' => 'company_name', 'value' => 'Nusantara Tour Guide', 'group' => 'general', 'type' => 'text'],
            ['key' => 'company_tagline', 'value' => 'Pemandu Wisata Resmi Berlisensi HPI & Ekspedisi Eksklusif Indonesia', 'group' => 'general', 'type' => 'text'],
            ['key' => 'meta_description_default', 'value' => 'Nusantara Tour Guide menyediakan pemandu wisata profesional berlisensi resmi HPI di seluruh penjuru Indonesia: Bali, Raja Ampat, Labuan Bajo Komodo, Bromo Ijen, Yogyakarta, dan Tana Toraja dengan jaminan kenyamanan & keamanan.', 'group' => 'general', 'type' => 'textarea'],
            
            // Contact & Hub Locations
            ['key' => 'contact_email', 'value' => 'halo@tourguide.id', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+62 361 890 5678', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_whatsapp', 'value' => '081288889999', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'emergency_towing', 'value' => '081199998888 (24 Jam Tourist Support & SAR Rescue Contact)', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'Nusantara Tourism Hub, Jl. Danau Tamblingan No. 88, Sanur, Denpasar Selatan, Bali 80228 (Cabang Operasional: Jakarta, Labuan Bajo, Sorong Raja Ampat, Malang)', 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'working_hours', 'value' => 'Setiap Hari: 07.00 - 22.00 WITA | Layanan Pendampingan Guide Lapangan 24/7', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.0!2d115.2!3d-8.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwNDInMDAuMCJTIDExNcKwMTInMDAuMCJF!5e0!3m2!1sen!2sid!4v1', 'group' => 'contact', 'type' => 'textarea'],

            // Stats / Metrics
            ['key' => 'stat_projects_completed', 'value' => '2,850+', 'group' => 'stats', 'type' => 'text'],
            ['key' => 'stat_dyno_runs', 'value' => '120+', 'group' => 'stats', 'type' => 'text'],
            ['key' => 'stat_contest_awards', 'value' => '34', 'group' => 'stats', 'type' => 'text'],
            ['key' => 'stat_satisfaction_rate', 'value' => '99.8%', 'group' => 'stats', 'type' => 'text'],

            // Social Media
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/nusantaratourguide', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@nusantaratourguide', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@nusantaratourguide', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/nusantaratourguide', 'group' => 'social', 'type' => 'text'],

            // Payment Gateway Sandbox/Simulation Settings
            ['key' => 'midtrans_merchant_id', 'value' => 'G123456789', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'midtrans_client_key', 'value' => 'SB-Mid-client-NusantaraTourKey2026', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'midtrans_server_key', 'value' => 'SB-Mid-server-NusantaraSecretKey2026', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'midtrans_is_production', 'value' => '0', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'qris_static_qr_url', 'value' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226600014ID.LINKAJA.WWW0118936009110022334455021500000000000000053033605802ID5918NUSANTARA+TOUR+GUIDE6007DENPASAR61058022862070703A016304E8A9', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'bank_bca_account', 'value' => '888-019-2831 a.n. PT NUSANTARA JELAJAH WISATA', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'bank_mandiri_account', 'value' => '123-00-9876543-2 a.n. PT NUSANTARA JELAJAH WISATA', 'group' => 'payment', 'type' => 'text'],
        ];

        foreach ($settings as $item) {
            SiteSetting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
