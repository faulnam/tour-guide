<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Statistics
            [
                'key' => 'total_projects',
                'value' => '3,000+',
                'group' => 'statistics',
                'label' => 'Total Projects Across the World',
                'type' => 'text',
            ],
            [
                'key' => 'years_experience',
                'value' => '20+',
                'group' => 'statistics',
                'label' => 'Years Working Experience',
                'type' => 'text',
            ],
            [
                'key' => 'media_awards_count',
                'value' => '17+',
                'group' => 'statistics',
                'label' => 'Media Published & Awards',
                'type' => 'text',
            ],
            [
                'key' => 'countries_served',
                'value' => '5',
                'group' => 'statistics',
                'label' => 'Total Countries Served Around The World',
                'type' => 'text',
            ],
            [
                'key' => 'associate_partners',
                'value' => '5',
                'group' => 'statistics',
                'label' => 'Associate Partners',
                'type' => 'text',
            ],
            [
                'key' => 'total_clients',
                'value' => '60+',
                'group' => 'statistics',
                'label' => 'Number of Clients',
                'type' => 'text',
            ],
            [
                'key' => 'team_members_count',
                'value' => '60',
                'group' => 'statistics',
                'label' => 'Team Members',
                'type' => 'text',
            ],
            [
                'key' => 'days_of_work',
                'value' => '9000+',
                'group' => 'statistics',
                'label' => 'Days of Work',
                'type' => 'text',
            ],

            // Company Info & Branding
            [
                'key' => 'company_name',
                'value' => 'Metrix Interior Architecture',
                'group' => 'general',
                'label' => 'Company Name',
                'type' => 'text',
            ],
            [
                'key' => 'site_title',
                'value' => 'Metrix Interior Architecture — Jakarta Interior Design Consultant',
                'group' => 'general',
                'label' => 'Site Title',
                'type' => 'text',
            ],
            [
                'key' => 'meta_description_default',
                'value' => 'Metrix Interior Architecture is an award-winning Jakarta-based interior design consultant firm serving globally.',
                'group' => 'general',
                'label' => 'Default Meta Description',
                'type' => 'textarea',
            ],

            // Contact Information
            [
                'key' => 'company_phone_1',
                'value' => '+62 21 5801 6187',
                'group' => 'contact',
                'label' => 'Office Phone 1',
                'type' => 'text',
            ],
            [
                'key' => 'company_phone_2',
                'value' => '+62 21 7501 6148',
                'group' => 'contact',
                'label' => 'Office Phone 2',
                'type' => 'text',
            ],
            [
                'key' => 'company_whatsapp',
                'value' => '+628170887720',
                'group' => 'contact',
                'label' => 'WhatsApp Number',
                'type' => 'text',
            ],
            [
                'key' => 'company_email_info',
                'value' => 'info@the-metrix.com',
                'group' => 'contact',
                'label' => 'General Inquiry Email',
                'type' => 'text',
            ],
            [
                'key' => 'company_email_hr',
                'value' => 'hrd1@the-metrix.com',
                'group' => 'contact',
                'label' => 'HR / Career Email',
                'type' => 'text',
            ],
            [
                'key' => 'company_email_marketing',
                'value' => 'marketing1@the-metrix.com',
                'group' => 'contact',
                'label' => 'Marketing Email',
                'type' => 'text',
            ],
            [
                'key' => 'company_address',
                'value' => "PT. Metrix Indonesia\nJl. Puri Indah Raya Blok I\nKomp. Ruko Puri Blok A No. 18\nPuri Indah Kembangan\nJakarta Barat 11610",
                'group' => 'contact',
                'label' => 'Office Address',
                'type' => 'textarea',
            ],
            [
                'key' => 'company_directions_url',
                'value' => 'https://maps.google.com/?q=PT.+Metrix+Indonesia',
                'group' => 'contact',
                'label' => 'Directions / Maps Link',
                'type' => 'text',
            ],
            [
                'key' => 'map_embed_url',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7328919690333!2d106.73801877583693!3d-6.166580960431309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f78bcbc1f6ff%3A0x6b107b31278ba77a!2sPT%20Metrix%20Indonesia!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid',
                'group' => 'contact',
                'label' => 'Google Map Embed URL',
                'type' => 'text',
            ],

            // Social Media
            [
                'key' => 'social_instagram',
                'value' => 'https://www.instagram.com/metrix_interior/',
                'group' => 'social',
                'label' => 'Instagram URL',
                'type' => 'text',
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://www.facebook.com/metrixinterior',
                'group' => 'social',
                'label' => 'Facebook URL',
                'type' => 'text',
            ],
            [
                'key' => 'social_pinterest',
                'value' => 'https://www.pinterest.com/metrixinterior/',
                'group' => 'social',
                'label' => 'Pinterest URL',
                'type' => 'text',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://www.youtube.com/@metrixinterior',
                'group' => 'social',
                'label' => 'YouTube URL',
                'type' => 'text',
            ],
            [
                'key' => 'footer_copyright',
                'value' => 'Copyright © 2026 PT. Metrix Indonesia All right reserved.',
                'group' => 'general',
                'label' => 'Footer Copyright Text',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
