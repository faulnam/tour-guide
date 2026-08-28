<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanMetrixData extends Command
{
    protected $signature = 'bengkel:clean-metrix';
    protected $description = 'Clean all old Metrix and interior architecture references from database';

    public function handle()
    {
        $this->info('Scanning database tables for old Metrix / Interior references...');

        // 1. Update SiteSettings
        if (Schema::hasTable('site_settings')) {
            $settings = DB::table('site_settings')->get();
            foreach ($settings as $setting) {
                $val = $setting->value;
                $newVal = str_ireplace(
                    ['The Metrix Interior Architecture Studio', 'The Metrix', 'Metrix Interior Architecture', 'Metrix Interior', 'Metrix Garage', 'Metrix Studio', 'Metrix Editorial', 'Metrix Research Team', 'the-metrix.com', 'metrix_interior', 'metrixinterior', 'metrix-interior'],
                    ['BENGKEL Modifikasi Motor & Mobil', 'BENGKEL', 'BENGKEL Modifikasi Motor & Mobil', 'BENGKEL', 'BENGKEL', 'BENGKEL Studio', 'BENGKEL Editorial', 'BENGKEL Tuning Team', 'bengkelmodifikasi.id', 'bengkel_modifikasi', 'bengkelmodifikasi', 'bengkel-modifikasi'],
                    $val
                );
                if ($newVal !== $val) {
                    DB::table('site_settings')->where('id', $setting->id)->update(['value' => $newVal]);
                    $this->info("Updated site_setting: {$setting->key}");
                }
            }

            // Ensure essential keys exist
            $defaults = [
                'company_name' => 'BENGKEL',
                'site_title' => 'BENGKEL — Workshop Modifikasi Motor & Mobil Jakarta',
                'company_tagline' => 'Workshop & Studio Modifikasi Motor dan Mobil',
                'meta_description_default' => 'BENGKEL adalah spesialis modifikasi performa motor dan mobil, dyno tuning ECU remap, custom builder, widebody kit, dan cat oven di Jakarta.',
                'company_address' => "BENGKEL Modifikasi Motor & Mobil\nJl. TB Simatupang No. 88\nCilandak, Jakarta Selatan 12430",
                'contact_address' => "Kawasan Otomotif Terpadu, Jl. TB Simatupang No. 88, Cilandak, Jakarta Selatan 12430",
                'company_phone_1' => '+62 21 7890 1234',
                'contact_phone' => '+62 21 7890 1234',
                'company_whatsapp' => '+6281288889999',
                'contact_whatsapp' => '+6281288889999',
                'company_email_info' => 'info@bengkelmodifikasi.id',
                'contact_email' => 'info@bengkelmodifikasi.id',
                'company_email_hr' => 'hrd@bengkelmodifikasi.id',
                'footer_copyright' => 'Copyright © ' . date('Y') . ' BENGKEL Modifikasi Motor & Mobil. All rights reserved.',
                'company_directions_url' => 'https://maps.google.com/?q=-6.3,106.8',
            ];

            foreach ($defaults as $k => $v) {
                $exists = DB::table('site_settings')->where('key', $k)->first();
                if (!$exists) {
                    DB::table('site_settings')->insert([
                        'key' => $k,
                        'value' => $v,
                        'group' => 'general',
                        'type' => 'text',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $this->info("Inserted site_setting: {$k}");
                } else if (empty($exists->value) || stripos($exists->value, 'metrix') !== false) {
                    DB::table('site_settings')->where('key', $k)->update(['value' => $v]);
                    $this->info("Refreshed site_setting: {$k}");
                }
            }
        }

        // 2. Update PageContents
        if (Schema::hasTable('page_contents')) {
            $contents = DB::table('page_contents')->get();
            foreach ($contents as $pc) {
                $val = $pc->value;
                $newVal = str_ireplace(
                    ['The Metrix', 'Metrix Garage', 'Metrix Studio', 'Metrix Interior Architecture', 'Metrix Interior', 'Metrix'],
                    ['BENGKEL', 'BENGKEL', 'BENGKEL Studio', 'BENGKEL Modifikasi Motor & Mobil', 'BENGKEL', 'BENGKEL'],
                    $val
                );
                if ($newVal !== $val) {
                    DB::table('page_contents')->where('id', $pc->id)->update(['value' => $newVal]);
                    $this->info("Updated page_content: {$pc->key}");
                }
            }
        }

        // 3. Update Blog Posts
        if (Schema::hasTable('blog_posts')) {
            $posts = DB::table('blog_posts')->get();
            foreach ($posts as $post) {
                $title = str_ireplace(['The Metrix', 'Metrix Garage', 'Metrix Interior', 'Metrix'], ['BENGKEL', 'BENGKEL', 'BENGKEL Modifikasi', 'BENGKEL'], $post->title ?? '');
                $author = str_ireplace(['Metrix Editorial', 'Metrix Research Team', 'Metrix'], ['BENGKEL Editorial', 'BENGKEL Tuning Team', 'BENGKEL Master Tuner'], $post->author ?? '');
                $excerpt = str_ireplace(['The Metrix', 'Metrix Garage', 'Metrix Interior', 'Metrix'], ['BENGKEL', 'BENGKEL', 'BENGKEL Modifikasi', 'BENGKEL'], $post->excerpt ?? '');
                $content = str_ireplace(['The Metrix', 'Metrix Garage', 'Metrix Interior', 'Metrix'], ['BENGKEL', 'BENGKEL', 'BENGKEL Modifikasi', 'BENGKEL'], $post->content ?? '');

                DB::table('blog_posts')->where('id', $post->id)->update([
                    'title' => $title,
                    'author' => $author,
                    'excerpt' => $excerpt,
                    'content' => $content,
                ]);
            }
            $this->info('Cleaned blog_posts');
        }

        // 4. Update Testimonials
        if (Schema::hasTable('testimonials')) {
            $tests = DB::table('testimonials')->get();
            foreach ($tests as $t) {
                $msg = str_ireplace(['The Metrix', 'Metrix Garage', 'Metrix Interior', 'Metrix', 'Apex Garage'], ['BENGKEL', 'BENGKEL', 'BENGKEL Modifikasi', 'BENGKEL', 'BENGKEL'], $t->message ?? '');
                DB::table('testimonials')->where('id', $t->id)->update(['message' => $msg]);
            }
            $this->info('Cleaned testimonials');
        }

        // 5. Update Users (email references)
        if (Schema::hasTable('users')) {
            DB::table('users')->where('email', 'admin@the-metrix.com')->update(['email' => 'admin@bengkelmodifikasi.id']);
            DB::table('users')->where('email', 'editor@the-metrix.com')->update(['email' => 'editor@bengkelmodifikasi.id']);
            $this->info('Cleaned users emails');
        }

        $this->info('Database cleaned successfully!');
        return 0;
    }
}
