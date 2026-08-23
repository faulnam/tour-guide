<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Home Page
            [
                'key' => 'home_hero_title',
                'value' => 'We are an Award-Winning interior design firm',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Headline',
            ],
            [
                'key' => 'home_hero_description',
                'value' => 'Metrix Interior Architecture is a Jakarta-based interior design consultant firm serving globally. Metrix specializes in retail interior design, commercial interior design, restaurant design, bar cafe interior design, hospitality interior architecture, and office interior design projects. Variety of our portfolios can be found in Indonesia, Malaysia, Singapore and United States.',
                'page' => 'home',
                'section' => 'hero',
                'label' => 'Home Hero Description',
            ],
            [
                'key' => 'home_recent_projects_eyebrow',
                'value' => 'Recent Projects',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Section Eyebrow',
            ],
            [
                'key' => 'home_recent_projects_subtitle',
                'value' => 'We are at the forefront of contemporary new trends in interior design.',
                'page' => 'home',
                'section' => 'recent_projects',
                'label' => 'Recent Projects Section Subtitle',
            ],
            [
                'key' => 'home_latest_insights_eyebrow',
                'value' => 'Latest Insights',
                'page' => 'home',
                'section' => 'latest_insights',
                'label' => 'Latest Insights Section Eyebrow',
            ],
            [
                'key' => 'home_latest_insights_subtitle',
                'value' => 'Stay inspired with our newest articles, project showcases, and design perspectives.',
                'page' => 'home',
                'section' => 'latest_insights',
                'label' => 'Latest Insights Section Subtitle',
            ],
            [
                'key' => 'home_clients_eyebrow',
                'value' => 'Our Clients',
                'page' => 'home',
                'section' => 'clients',
                'label' => 'Our Clients Section Eyebrow',
            ],
            [
                'key' => 'home_cta_title',
                'value' => 'Want to start a new project?',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Title',
            ],
            [
                'key' => 'home_cta_subtitle',
                'value' => 'Feel free to talk, share your dream interior imagination and let us make it into reality.',
                'page' => 'home',
                'section' => 'cta',
                'label' => 'Home CTA Subtitle',
            ],

            // About Us Page
            [
                'key' => 'about_who_we_are_title',
                'value' => 'Who We Are',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Title',
            ],
            [
                'key' => 'about_who_we_are_text',
                'value' => 'Metrix Interior Architecture is an established Jakarta-based interior design consultant with over two decades of international experience. We have developed high-profile projects ranging from luxury hospitality, prestigious commercial workspaces, destination restaurants, and bespoke residential show units across Southeast Asia and the United States.',
                'page' => 'about',
                'section' => 'profile',
                'label' => 'About - Who We Are Text',
            ],
            [
                'key' => 'about_mission_title',
                'value' => 'Our Mission',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Our Mission Title',
            ],
            [
                'key' => 'about_mission_text',
                'value' => 'To conceive timeless, functional, and visually evocative architectural interiors that elevate human experience, amplify client brand identities, and establish enduring value through thoughtful craftsmanship and sustainable innovation.',
                'page' => 'about',
                'section' => 'mission',
                'label' => 'About - Our Mission Text',
            ],

            // Career Page
            [
                'key' => 'career_intro_title',
                'value' => 'Join The Crew',
                'page' => 'career',
                'section' => 'intro',
                'label' => 'Career - Intro Title',
            ],
            [
                'key' => 'career_intro_subtitle',
                'value' => 'We are always looking for passionate architects, designers, 3D visualizers, and project managers to join our dynamic studio in Jakarta.',
                'page' => 'career',
                'section' => 'intro',
                'label' => 'Career - Intro Subtitle',
            ],

            // Contact Page
            [
                'key' => 'contact_intro_title',
                'value' => 'Get In Touch',
                'page' => 'contact',
                'section' => 'intro',
                'label' => 'Contact - Intro Title',
            ],
            [
                'key' => 'contact_intro_text',
                'value' => 'We would love to hear from you. Whether you have a project in mind, a press inquiry, or simply want to say hello, get in touch with our team.',
                'page' => 'contact',
                'section' => 'intro',
                'label' => 'Contact - Intro Text',
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
