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
            ['key' => 'site_title', 'value' => 'BENGKEL — Workshop Modifikasi Motor & Mobil Jakarta', 'group' => 'general', 'type' => 'text'],
            ['key' => 'company_name', 'value' => 'BENGKEL', 'group' => 'general', 'type' => 'text'],
            ['key' => 'company_tagline', 'value' => 'Workshop & Studio Modifikasi Motor dan Mobil', 'group' => 'general', 'type' => 'text'],
            ['key' => 'meta_description_default', 'value' => 'BENGKEL adalah spesialis modifikasi performa mobil dan motor, dyno tuning ECU remap, custom builder, widebody kit, dan cat oven di Jakarta.', 'group' => 'general', 'type' => 'textarea'],
            
            // Contact & Workshop
            ['key' => 'contact_email', 'value' => 'info@apexgarage.id', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+62 21 7890 1234', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_whatsapp', 'value' => '081288889999', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'emergency_towing', 'value' => '081199998888 (24 Jam Towing Service)', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'Kawasan Otomotif Terpadu, Jl. TB Simatupang No. 88, Cilandak, Jakarta Selatan 12430', 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'working_hours', 'value' => 'Senin - Sabtu: 08.30 - 18.00 WIB | Minggu: Khusus Booking & Dyno Session', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8!2d106.8!3d-6.3!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTgnMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v1', 'group' => 'contact', 'type' => 'textarea'],

            // Stats / Metrics
            ['key' => 'stat_projects_completed', 'value' => '1,450+', 'group' => 'stats', 'type' => 'text'],
            ['key' => 'stat_dyno_runs', 'value' => '3,200+', 'group' => 'stats', 'type' => 'text'],
            ['key' => 'stat_contest_awards', 'value' => '28', 'group' => 'stats', 'type' => 'text'],
            ['key' => 'stat_satisfaction_rate', 'value' => '99.4%', 'group' => 'stats', 'type' => 'text'],

            // Social Media
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/apexgarage.id', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@apexgaragetuning', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@apexgarage', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/apexgarageworkshop', 'group' => 'social', 'type' => 'text'],

            // Payment Gateway Sandbox/Simulation Settings
            ['key' => 'midtrans_merchant_id', 'value' => 'G123456789', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'midtrans_client_key', 'value' => 'SB-Mid-client-ApexGarageKey2026', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'midtrans_server_key', 'value' => 'SB-Mid-server-ApexSecretKey2026', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'midtrans_is_production', 'value' => '0', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'qris_static_qr_url', 'value' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020101021226600014ID.LINKAJA.WWW0118936009110022334455021500000000000000053033605802ID5911APEX+GARAGE6007JAKARTA61051243062070703A016304E8A9', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'bank_bca_account', 'value' => '888-019-2831 a.n. PT APEX GARAGE INDONESIA', 'group' => 'payment', 'type' => 'text'],
            ['key' => 'bank_mandiri_account', 'value' => '123-00-9876543-2 a.n. PT APEX GARAGE INDONESIA', 'group' => 'payment', 'type' => 'text'],
        ];

        foreach ($settings as $item) {
            SiteSetting::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
