<?php

namespace Tests\Feature;

use App\Models\Service;
use Tests\TestCase;

class SprintSevenTest extends TestCase
{
    /**
     * Test Dynamic XML Sitemap returns valid XML with proper headers and dynamic entries.
     */
    public function test_sitemap_xml_returns_valid_xml(): void
    {
        Service::firstOrCreate(
            ['slug' => 'interior-design'],
            ['title' => 'Interior Design', 'is_active' => true, 'order' => 1]
        );

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<urlset', false);
        $response->assertSee(url('/about-us'), false);
        $response->assertSee(url('/services/interior-design'), false);
    }

    /**
     * Test Robots.txt is present and blocks admin crawlers.
     */
    public function test_robots_txt_contains_admin_disallow_and_sitemap(): void
    {
        $robotsPath = public_path('robots.txt');
        $this->assertFileExists($robotsPath);

        $content = file_get_contents($robotsPath);
        $this->assertStringContainsString('Disallow: /admin', $content);
        $this->assertStringContainsString('sitemap.xml', $content);
    }

    /**
     * Test Dynamic SEO Meta Tags on Public Pages.
     */
    public function test_seo_meta_tags_rendered_on_public_pages(): void
    {
        // Homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('<meta name="title"', false);
        $homeResponse->assertSee('<meta property="og:title"', false);
        $homeResponse->assertSee('<meta name="twitter:card"', false);
    }
}
