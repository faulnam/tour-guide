<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SprintFourTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Blog Index Page.
     */
    public function test_blog_index_returns_successful_response(): void
    {
        $response = $this->get('/our-blog');

        $response->assertStatus(200);
        $response->assertSee('Our Blog');
        $response->assertSee('Design Perspective');
        $response->assertSee('Metrix Interior at IIDA 2025');
    }

    /**
     * Test Blog Index with Category Filtering.
     */
    public function test_blog_index_with_category_filtering(): void
    {
        $response = $this->get('/our-blog?category=design-perspective');

        $response->assertStatus(200);
        $response->assertSee('Design Perspective');
        $response->assertSee('Metrix Interior at IIDA 2025');
    }

    /**
     * Test Single Blog Article Detail Page.
     */
    public function test_blog_article_detail_page_returns_successful_response(): void
    {
        $response = $this->get('/our-blog/metrix-interior-at-iida-2025-a-celebration-of-design-culture-and-craft');

        $response->assertStatus(200);
        $response->assertSee('Metrix Interior at IIDA 2025');
        $response->assertSee('Metrix Editorial');
        $response->assertSee('Recent Articles');
        $response->assertSee('Categories');
    }

    /**
     * Test Awards & Publications Index with Pagination.
     */
    public function test_awards_index_returns_successful_response(): void
    {
        $response = $this->get('/awards-publications');

        $response->assertStatus(200);
        $response->assertSee('Awards &amp; Publications', false);
        $response->assertSee('International Design Awards (IDA) 2024 - Gold Winner');
    }

    /**
     * Test Single Award Detail Page.
     */
    public function test_award_detail_page_returns_successful_response(): void
    {
        $response = $this->get('/awards-publications/ida-2024-gold-winner');

        $response->assertStatus(200);
        $response->assertSee('International Design Awards (IDA) 2024 - Gold Winner');
        $response->assertSee('Visit Official Publication');
    }
}
